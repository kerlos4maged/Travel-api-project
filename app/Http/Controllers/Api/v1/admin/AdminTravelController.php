<?php

namespace App\Http\Controllers\api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AdminTravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

class AdminTravelController extends Controller
{
    public function store(AdminTravelRequest $request)
    {
        $travel = Travel::create($request->validated());

        return new TravelResource($travel);
    }

    public function update(AdminTravelRequest $request, Travel $travel)
    {
        $travel->update($request->validated());

        return new TravelResource($travel);
    }
}
