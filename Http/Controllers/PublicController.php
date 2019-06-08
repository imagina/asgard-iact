<?php

namespace Modules\Iact\Http\Controllers;

use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iact\Repositories\ActRepository;
use Route;

class PublicController extends BasePublicController
{
    /**
     * @var PostRepository
     */
    private $act;


    public function __construct(ActRepository $act)
    {
        parent::__construct();
        $this->act=$act;
    }

    public function pdf($id)
    {
        $act = $this->act->find($id);

        $view =  \View::make('iact::frontend.pdf', compact('act'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('Solicitud de Crédito.pdf');
    }
}