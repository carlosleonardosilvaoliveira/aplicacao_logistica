<?php

namespace App\Controller\Panel;

use App\core\Pagination;
use App\Utils\View;

class Page
{
    private static $modules = [
        'terminaisRS' => [
            'label' => 'Terminais RS',
            'link'  => URL.'/equipamentsRS'
        ],
        'terminaisPR' => [
            'label' => 'Terminais PR',
            'link'  => URL.'/equipamentsPR'
        ],
        'terminaisSC' => [
            'label' => 'Terminais SC',
            'link'  => URL.'/equipamentsSC'
        ]
    ];

    public static function getPage($title, $content)
    {
        return View::render('painel/page',[
            'title' => $title,
            'content' => $content
        ]);
    }

    private static function getMenu($currentModule)
    {
        $links = '';

        foreach(self::$modules as $hash=>$module) {
            $links .= View::render('painel/menu/link',[
                'label' => $module['label'],
                'link'  => $module['link'],
                'current' => $hash == $currentModule ? 'active' : ''
            ]);
        }

        return View::render('painel/menu/box',[
            'links' => $links
        ]);
    }

    public static function getPanel($title, $content, $currentModule)
    {
        $contentPanel = View::render('painel/panel',[
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);

        return self::getPage($title, $contentPanel);
    }

    /**
     * Método responsável por renderizar o layout de paginação
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination)
    {
        //PÁGINAS
        $pages = $obPagination->getPages();

        //VERIFICA A QUANTIDADE DE PÁGINAS
        if(count($pages) <= 1) return '';

        //LINKS
        $links = '';

        //URL ATUAL (SEM GETS)
        $url = $request->getRouter()->getCurrentUrl();

        //GET
        $queryParams = $request->getQueryParams();

        //RENDERIZA OS LINKS
        foreach($pages as $page) {

            //ALTERA A PÁGINA
            $queryParams['page'] = $page['page'];

            //LINK
            $link = $url.'?'.http_build_query($queryParams);

            //VIEW
            $links .= View::render('pagination/link',[
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        //RENDERIZA BOX DE PAGINAÇÃO
        return View::render('pagination/box',[
           'links' => $links
        ]);
    }
}