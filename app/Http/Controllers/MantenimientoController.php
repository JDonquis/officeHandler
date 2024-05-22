<?php

namespace App\Http\Controllers;

use inertia;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\MantenimientoService;
use App\Http\Requests\MantenimientoRequest;

class MantenimientoController extends Controller
{

    public function __construct()
    {
        $this->mantenimientoService = new MantenimientoService;

    }

    public function index(Request $request)
    {
        $services = $this->mantenimientoService->getServices($request);
        $user = User::get();

        return inertia('Dashboard/Mantenimiento',
        [
            'data' =>
            [ 
            "services" => $services,
            "user" => $user,
            "filters" => $request->only(['search']),
    
            ]
        
        ]);

    }


    public function store(MantenimientoRequest $request)
    {
        $this->mantenimientoService->create($request->all());
        return redirect('/dashboard/mantenimiento');
        
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(MantenimientoRequest $request, $id)
    {
        $this->mantenimientoService->update($request,$id);
        return redirect('/dashboard/mantenimiento');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Service::destroy($id);
        return redirect('/dashboard/mantenimiento');
        
    }
}
