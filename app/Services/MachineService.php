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
            "observation"
        ]));

        if($request->hasFile('photo'))
            $this->handlePhoto($request,$newMachine);


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
                "observation" => $request->input('observation')

            ]
        );
    

        $search = $this->generateSearch($machine);
        
        $machine->update(['search' => $search]);

    }

    private function generateSearch($machine)
    {
        $search = 
        $machine->name . ' '
         . $machine->code . ' '
         . $machine->model . ' '
         . $machine->manufacturer . ' '
         . $machine->serial_number . ' ';
         
         return $search;
    }

    private function handlePhoto($request,$machine)
    {

        $path = $request->file('photo')->store('machines','public');

        $machine->update(['photo' => $path]);
    }
    

}
