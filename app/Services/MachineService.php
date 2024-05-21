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

        $newActivity->update(['search' => $search]);

    }

    public function update($data,$id)
    {
        $activity = Activity::find($id);
        $user = auth()->user();
        
        $activity->update(

            [
                "status_id" => $data["status_id"],
                "title" => $data["title"],
                "user_id" => $user->id,
                "start_date" => $data["start_date"],
                "end_date" => $data["end_date"],
                "location_id" => $data["location_id"],
                "office_id" => $data["office_id"],
                "division_id" => $data["division_id"],
                "department_id" => $data["department_id"],
                "progress" => $data["progress"],
                "observation" => $data["observation"],
                "area_id" => $data["area_id"],
                "type_activity_id" => $data["type_activity_id"],
            ]
        );
    

        $activity->load('user','location','office','division','department','area','typeActivity','status');

        $search = $this->generateSearch($activity);
        
        $activity->update(['search' => $search]);

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
