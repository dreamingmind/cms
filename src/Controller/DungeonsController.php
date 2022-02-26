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
            'tiles_wide' => 18,
            'tiles_high' => 8,
            'tile_size' => 200,
        ]);
        $Canvas->output();
    }
}
