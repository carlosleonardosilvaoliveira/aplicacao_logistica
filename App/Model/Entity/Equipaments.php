<?php

namespace App\Model\Entity;

use \App\Core\Database;

class Equipaments
{
    public $id;
    public $n_terminal;
    public $ponto;
    public $uf;
    public $tipo;
    public $marca;
    public $modelo;
    public $n_serie;
    public $ip;
    public $h_operacional;
    public $status;
    public $disp_atual;
    public $req;
    public $wo;
    public $data_chamado;
    public $tipo_chamado;
    public $obs_chamado;
    public $status_chamado;
    public $obs;
    public $email;

    /*public function cadastrarTerminais()
    {

        $this->id = (new Database('terminais'))->insert([
            'n_terminal' => $this->n_terminal,
            'ponto' => $this->ponto,
            'uf' => $this->uf,
            'tipo' => $this->tipo,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'n_serie' => $this->n_serie,
            'ip' => $this->ip,
            'h_operacional' => $this->h_operacional,
            'status' => $this->status,
            'disp_atual' => $this->disp_atual
        ]);

        return true;
    }*/

    public function updateSimga()
    {
        ini_set('max_execution_time', 500);

        return (new Database('terminais'))->update("n_terminal = '{$this->n_terminal}'",[
            'disp_atual' => $this->disp_atual
        ]);
    }

    public function updateChamados()
    {
        return (new Database('terminais'))->update("n_terminal = '{$this->n_terminal}'",[
            'req' => $this->req,
            'wo' => $this->wo,
            'data_chamado' => $this->data_chamado,
            'tipo_chamado' => $this->tipo_chamado,
            'obs_chamado' => $this->obs_chamado,
            'status_chamado' => $this->status_chamado
        ]);
    }

    public function update()
    {
        return (new Database('terminais'))->update("n_terminal = '{$this->n_terminal}'",[
           'obs'    => $this->obs,
           'email'  => $this->email
        ]);
    }

    public static function getEquipamentsByNumTerminal($n_terminal)
    {
        return self::getEquipaments("n_terminal = '{$n_terminal}'")->fetchObject(self::class);
    }

    public static function getEquipaments($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('terminais'))->select($where, $order, $limit, $fields);
    }
}