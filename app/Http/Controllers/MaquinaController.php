<?php

namespace App\Http\Controllers;

use inertia;
use Illuminate\Http\Request;
use App\Services\MachineService;
use App\Http\Requests\CreateMachineRequest;

class MaquinaController extends Controller
{   

    public function __construct()
    {
        $this->machineService = new MachineService;

    }

    public function index(Request $request)
    {   
        $machines = $this->machineService->getMachines($request);

        return inertia('Dashboard/Maquinas',
        [
            'data' =>
            [ 
            "machines" => $machines,
            "filters" => $request->only(['search']),
    
            ]
        
        ]);

        return inertia('Dashboard/Maquinas');
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMachineRequest $request)
    {
        $this->machineService->create($request);
        return redirect('/dashboard/maquinas');
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(CreateMachineRequest $request, $id)
    {
        // $this->machineService->update($request->all(), $id);
        // return redirect('/dashboard/maquinas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
