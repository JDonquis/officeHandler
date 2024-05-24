<?php

namespace App\Http\Controllers;

use inertia;
use App\Models\Office;
use App\Models\Machine;
use App\Models\Service;
use App\Models\Division;
use App\Models\Location;
use App\Models\Department;
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
        $locations = Location::get();
        $offices = Office::get();
        $divisions = Division::get();
        $departments = Department::with('division')->get();

        return inertia('Dashboard/Maquinas',
        [
            'data' =>
            [ 
            "machines" => $machines,
            "locations" => $locations,
            "offices" => $offices,
            "divisions" => $divisions,
            "departments" => $departments,
            "filters" => $request->only(['search']),
    
            ]
        
        ]);

        return inertia('Dashboard/Maquinas');
    }

    public function search(Request $request)
    {
        $machines = $this->machineService->searchMachines($request);

        return response()->json(['machines' => $machines]);
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
        $this->machineService->update($request,$id);
        return redirect('/dashboard/maquinas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {   
        $service = Service::where('machine_id',$id)->first();
        if(isset($service->id))
        {

            return redirect('/dashboard/maquinas')->withErrors(['data' => 'Esta maquina no puede eliminarse debido a que ya se le hizo un mantenimiento']);

        }

        Machine::destroy($id);
        return redirect('/dashboard/maquinas');
    }
}
