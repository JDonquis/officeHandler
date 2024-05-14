<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Illuminate\Support\Facades\Request;

class AppController 
{   
    

    public function index(): Response
    {
        return inertia('Index');
    }

    public function dashboard(): Response
    {
        return inertia('Dashboard/Index');
    }

    public function maquinas(): Response
    {
        return inertia('Dashboard/Maquinas');
    }

    public function bitacora(): Response
    {
        return inertia('Dashboard/Bitacora');
    }
}
