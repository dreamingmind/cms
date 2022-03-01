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
            'tiles_wide' => 20,
            'tiles_high' => 10,
            'tile_size' => 70,
        ]);
        $Canvas->output();
    }
}
