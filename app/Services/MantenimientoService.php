<?php  

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Models\Machine;
use App\Models\Service;

class MantenimientoService
{	
	private Service $serviceModel;


    public function __construct()
    {
        $this->serviceModel = new Service;
    }

    public function getServices($request)
    {
        $services = Service::query()
        ->when($request->input('search'), function ($query, $search) 
        {
            $query->where('search','like','%' . $search . '%');
        })
        ->with('machine','typeService','user')
        ->paginate(25)
        ->withQueryString()
        ->through(fn($service) => [

            "id" => $service->id,
            'machine_id' => $service->machine_id,
            'machine_code' => $service->machine->code,
            'machine_name' => $service->machine->name,
            'machine_brand' => $service->machine->brand,
            'machine_model' => $service->machine->model,
            'type_service_id' => $service->type_service_id,
            'type_service_name' => $service->typeService->name,
            'user_id' => $service->user_id,
            'user_name' => $service->user->name,
            'user_last_name' => $service->user->last_name,
            'start' => $service->start,
            'description' => $service->description,
            'status' => $service->status,
            'duration' => $service->duration,
            'end' => $service->end,
            'next_service_date' => $service->next_service_date,
            'search' => $service->search,
        ]);

        return $services;
    }

    public function create($request)
    {

        $newService = Service::create($request->only(
        [
            'machine_id',
            'type_service_id',
            'user_id',
            'start',
            'description',
            'status',
            'duration',
            'end',
            'next_service_date',
        ]));

        $newService->load('user','machine','typeService');


        $search = $this->generateSearch($newService);

        $newService->update(['search' => $search]);

    }

    public function update($request,$id)
    {
        $service = Service::find($id);
        
        $service->update(

            [
                'machine_id' => $request->input('machine_id'),
                'type_service_id' => $request->input('type_service_id'),
                'user_id' => $request->input('user_id'),
                'start' => $request->input('start'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'duration' => $request->input('duration'),
                'end' => $request->input('end'),
                'next_service_date' => $request->input('next_service_date'),

            ]
        );
    

        $search = $this->generateSearch($service);
        
        $service->update(['search' => $search]);

    }

    private function generateSearch($newService)
    {
        $status = 'En proceso';
        if($newService->status != 1)
            $status = 'Completada';


        $search = 
        $newService->machine->name . ' '
        . $newService->user->name . ' '
        . $newService->user->last_name . ' '
        . $newService->typeService->name . ' '
         . $newService->start . ' '
         . $newService->description . ' '
         . $status . ' '
         . $newService->duration ?? null . ' '
         . $newService->end ?? null . ' '
         . $newService->next_service_date ?? null . ' ';
         
         return $search;
    }

    

}
