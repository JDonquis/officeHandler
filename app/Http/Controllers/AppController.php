<?php

namespace App\Http\Controllers;

use Inertia\Response;

class AppController {
    public function index(): Response
    {
        return inertia('Index', [
            'title' => 'Laravel 10, Inertia.js, Svelte, Tailwind CSS',
        ]);
    }

    public function dashboard(): Response
    {
        return inertia('Dashboard/Index',['title' => 'Hola']);
    }

    public function maquinas(): Response
    {
        return inertia('Dashboard/Maquinas');
    }
}
