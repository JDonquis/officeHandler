<?php  

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Models\Machine;

class MachineService
{	
	private User $userModel;


    public function __construct()
    {
        $this->machineModel = new Machine;
    }

    public function getMachines($request)
    {
        $machines = Machine::query()
        ->when($request->input('search'), function ($query, $search) 
        {
            $query->where('search','like','%' . $search . '%');
        })
        ->with('location','office','division','department')
        ->paginate(25)
        ->withQueryString()
        ->through(fn($machine) => [

            "id" => $machine->id,
            "code" => $machine->code,
            "name" => $machine->name,
            "brand" => $machine->brand,
            "model" => $machine->model,
            "manufacturer" => $machine->manufacturer,
            "serial_number" => $machine->serial_number,
            "location_id" => $machine->location->id,
            "location_name" => $machine->location->name,
            "office_id" => $machine->office->id,
            "office_name" => $machine->office->name,
            "division_id" => $machine->division->id,
            "division_name" => $machine->division->name,
            "department_id" => $machine->department->id,
            "department_name" => $machine->department->name,
            "photo" => $machine->photo,
            "observation" => $machine->observation
        ]);

        return $machines;
    }

    public function searchMachines($request)
    {
        $machines = Machine::query()
        ->when($request->input('search'), function ($query, $search) 
        {
            $query->where('search','like','%' . $search . '%');
        })
        ->get()
        ->withQueryString()
        ->through(fn($machine) => [

            "id" => $machine->id,
            "code" => $machine->code,
            "name" => $machine->name,
            "brand" => $machine->brand,
            "model" => $machine->model,
            "manufacturer" => $machine->manufacturer,
            "serial_number" => $machine->serial_number,
            "photo" => $machine->photo,
            "observation" => $machine->observation
        ]);

        return $machines;
    }

    public function create($request)
    {

        $newMachine = Machine::create($request->only(
        [
            "code",
            "name",
            "brand",
            "model",
            "manufacturer",
            "serial_number",
            "location_id",
            "office_id",
            "division_id",
            "department_id",
            "observation"
        ]));

        if($request->hasFile('photo'))
            $this->handlePhoto($request,$newMachine);


        $newMachine->load('location','division','office','department');

        $search = $this->generateSearch($newMachine);

        $newMachine->update(['search' => $search]);

    }

    public function update($request,$id)
    {
        $machine = Machine::find($id);
        
        $machine->update(

            [

                "code" => $request->input('code'),
                "name" => $request->input('name'),
                "brand" => $request->input('brand'),
                "model" => $request->input('model'),
                "manufacturer" => $request->input('manufacturer'),
                "serial_number" => $request->input('serial_number'),
                "location_id" => $request->input('location_id'),
                "office_id" => $request->input('office_id'),
                "division_id" => $request->input('division_id'),
                "department_id" => $request->input('department_id'),
                "observation" => $request->input('observation')

            ]
        );
        
        $machine->load('location','division','office','department');


        $search = $this->generateSearch($machine);
        
        $machine->update(['search' => $search]);

    }

    private function generateSearch($machine)
    {
        $search = 
        $machine->name . ' '
        . $machine->code . ' '
        . $machine->brand . ' '
         . $machine->model . ' '
         . $machine->manufacturer . ' '
         . $machine->serial_number . ' '
         . $machine->location->name . ' '
         . $machine->office->name . ' '
         . $machine->division->name . ' '
         . $machine->department->name . ' '
         . $machine->observation ?? null . ' ';
         
         return $search;
    }

    private function handlePhoto($request,$machine)
    {

        $path = $request->file('photo')->store('machines','public');

        $machine->update(['photo' => $path]);
    }
    

}
