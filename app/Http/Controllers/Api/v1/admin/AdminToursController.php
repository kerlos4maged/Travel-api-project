<?php

namespace App\Http\Controllers\Api\v1\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\AdminToursRequest;
use App\Http\Resources\ToursResource;
use App\Models\Travel;

class AdminToursController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function store(AdminToursRequest $request, Travel $travel)
    {
        //

        $tour = $travel->tours()->create($request->validated());

        return new ToursResource($tour);
    }
}
