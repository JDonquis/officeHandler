<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\BitacoraService;
use App\Http\Requests\ActivityRequest;

class BitacoraController extends Controller
{
    
    
    public function __construct()
    {
        $this->bitacoraService = new BitacoraService;

    }

    public function index()
    {   
        $activities = $this->bitacoraService->getActivities();
        return inertia('Dashboard/Bitacora',['data' => $activities]);
        // return response()->json($activities);
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
