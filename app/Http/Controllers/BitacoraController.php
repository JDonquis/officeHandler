<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Office;
use App\Models\Status;
use App\Models\Activity;
use App\Models\Division;
use App\Models\Location;
use App\Models\Department;
use App\Models\TypeActivity;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\BitacoraService;
use App\Http\Requests\ActivityRequest;
use App\Services\TypeActivitiesService;

class BitacoraController extends Controller
{
    
    
    public function __construct()
    {
        $this->bitacoraService = new BitacoraService;
        $this->typeActivityService = new TypeActivitiesService;

    }

    public function index()
    {   
        $activities = $this->bitacoraService->getActivities();
        $typeActivities = TypeActivity::get();
        $locations = Location::get();
        $offices = Office::get();
        $divisions = Division::get();
        $departments = Department::get();
        $status = Status::get();
        $areas = Area::get();
        
        return inertia('Dashboard/Bitacora',
        [
            'data' => $activities,
            'typeActivities' => $typeActivities, 
            'locations' => $locations, 
            'offices' => $offices, 
            'divisions' => $divisions, 
            'departments' => $departments, 
            'status' => $status,
            'areas' => $areas,
        
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityRequest $request)
    {
        $this->bitacoraService->create($request->all());
        return redirect('/dashboard/bitacora');
        
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityRequest $request, $id)
    {
        $this->bitacoraService->update($request->all(),$id);
        return redirect('/dashboard/bitacora');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->destroy();
        return redirect('/dashboard/bitacora');

    }
}
