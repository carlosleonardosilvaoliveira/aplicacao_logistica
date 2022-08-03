<?php

namespace App\Controller\Panel;

use App\Utils\View;
use App\Model\Entity\Equipaments as EntityEquipaments;
use App\Core\Pagination;

class EquipamentsRS extends Page
{
    private static function getEquipamentsItems($request, &$obPagination)
    {
        $itens = '';

        $quantidadeTotal = EntityEquipaments::getEquipaments("uf = 'RS' AND NOT disp_atual = 'Disponível'", null, null, "COUNT(*) as qtd")->fetchObject()->qtd;

        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //PESQUISA
        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

        //CONDIÇÕES SQL
        $condicoes = [
            strlen($search) ? "uf = 'RS' AND (n_terminal LIKE '%$search%' OR req LIKE '%$search%' OR wo LIKE '%$search%') AND NOT disp_atual = 'Disponível'" : "uf = 'RS' AND NOT disp_atual = 'Disponível'"
        ];

        //CLÁUSULA WHERE
        $where = implode(' AND ', $condicoes);

        //CONDIÇÃO PARA REDUZIR A PAGINAÇÃO AO PESQUISAR
        if($search) {
            $countSearch = EntityEquipaments::getEquipaments($where, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        } else {
            $countSearch = $quantidadeTotal;
        }

        $obPagination = new Pagination($countSearch, $paginaAtual, 80);

        $results = EntityEquipaments::getEquipaments($where, "n_terminal DESC", $obPagination->getLimit());

        while($obEquipaments = $results->fetchObject(EntityEquipaments::class)) {

            $itens .= View::render('painel/modules/equipamentsRS/item',[
                'n_terminal' => $obEquipaments->n_terminal,
                'ponto'  => $obEquipaments->ponto,
                'uf' => $obEquipaments->uf,
                'n_serie' => $obEquipaments->n_serie,
                'disp_atual' => $obEquipaments->disp_atual,
                'req' => $obEquipaments->req,
                'wo' => $obEquipaments->wo,
                'data_chamado' => substr($obEquipaments->data_chamado, 0, -3),
                'obs'  => $obEquipaments->obs,
                'email' => $obEquipaments->email ? $obEquipaments->email : 'Não'
            ]);
        }

        return $itens;
    }

    public static function getEquipaments($request)
    {
        $content = View::render('painel/modules/equipamentsRS/index',[
            'itens' => self::getEquipamentsItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        return parent::getPanel('Terminais', $content, 'terminaisRS');
    }

    public static function getImportChamados($request)
    {
        return $content = View::render('painel/modules/equipamentsRS/importChamados',[
            'title' => 'Importar CSV dos Chamados'
        ]);
    }

    public static function setImportChamados($request)
    {
        if(isset($_POST["ImportChamados"])){
            $obEquipaments = new EntityEquipaments();

            $fileName = $_FILES['importFileChamados']['tmp_name'];

            if($_FILES['importFileChamados']['size'] > 0) {
                $file = fopen($fileName, 'r');
                fgetcsv($file);
                while(($data = fgetcsv($file, 10000, ';')) !== FALSE) {

                    $obEquipaments->n_terminal = $data[0];

                    $obEquipaments->wo = $data[1];
                    $obEquipaments->req = $data[2];
                    $obEquipaments->data_chamado = $data[3];
                    $obEquipaments->tipo_chamado = $data[4];
                    $obEquipaments->obs_chamado = $data[11];
                    $obEquipaments->status_chamado = $data[10];
                    $obEquipaments->updateChamados();
                }
                $request->getRouter()->redirect('/equipamentsRS?status=imported');
            }
        }
    }

    public static function getImport($request)
    {
        return $content = View::render('painel/modules/equipamentsRS/importSimga',[
            'title' => 'Importar CSV'
        ]);
    }

    public static function setImport($request)
    {
        if(isset($_POST["Import"])){
            $obEquipaments = new EntityEquipaments();

            $fileName = $_FILES['importFile']['tmp_name'];

            if($_FILES['importFile']['size'] > 0) {
                $file = fopen($fileName, 'r');
                fgetcsv($file);
                while(($data = fgetcsv($file, 10000, ';'))!== FALSE) {

                    $obEquipaments->n_terminal = $data[0];

                    $obEquipaments->disp_atual = $data[12];
                    $obEquipaments->updateSimga();
                }
                $request->getRouter()->redirect('/equipamentsRS?status=imported');
            }
        } elseif(isset($_POST["ImportChamados"])) {
            self::setImportChamados($request);

        } elseif(isset($_POST["Export"])){
            self::setExport($request);

        } else {
            self::setEditEmail($request);
        }
    }

    public static function setEditEmail($request)
    {
        if(isset($_POST["n_terminal"])){

            $obEquipaments = new EntityEquipaments();

            $postVars = $request->getPostVars();

            $obEquipaments->n_terminal = $postVars['n_terminal'];

            $obEquipaments->email   = $postVars['email'] ?? '';
            $obEquipaments->obs     = $postVars['obs'] ?? '';

            $obEquipaments->update();

            header("Refresh: 0");
        }
    }

    public static function setExport($request)
    {
        if(isset($_POST["Export"])) {

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=indisponiveisRS.csv');

            $obEquipaments = EntityEquipaments::getEquipaments("uf = 'RS' AND NOT disp_atual = 'Disponível'", null, null, "n_terminal, ponto, n_serie, status, wo, data_chamado, email, obs, req, uf")->fetchAll();

            $delimiter = ";";

            $output = fopen("php://output", "w");
            $fields = array('Terminal', 'Agência', 'Série', 'Status', 'WO', 'Data_Chamado', 'E-mail', 'Observação', 'REQ', 'UF');
            fputcsv($output, $fields, $delimiter);

            foreach($obEquipaments as $row){
                $lineData = array($row['n_terminal'], $row['ponto'], $row['n_serie'], $row['status'], $row['wo'], $row['data_chamado'], $row['email'], $row['obs'], $row['req'], $row['uf']);
                fputcsv($output, $lineData, $delimiter);
            }

            fclose($output);
        }
    }

    /*public static function getStatus($request)
    {
        $queryParams = $request->getQueryParams();

        if(!isset($queryParams['status'])) return '';

        switch ($queryParams['status']) {
            case 'imported':
                return Alert::getSuccess('Arquivo importado com sucesso');
                break;
        }
    }*/
}