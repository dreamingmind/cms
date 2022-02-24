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
            'tiles_wide' => 15,
            'tiles_high' => 10,
        ]);
        $Canvas->output();
    }
}
