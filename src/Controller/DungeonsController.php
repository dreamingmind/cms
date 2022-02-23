<?php

namespace App\Controller;

use App\GDPrimitives\Canvas;

class DungeonsController extends AppController
{

    public function view()
    {
        $this->viewBuilder()->setLayout('ajax');
    }

    public function dun()
    {
        $Canvas = new Canvas([
            'width' => 50,
            'height' => 25,
        ]);
        $Canvas->output();
    }
}
