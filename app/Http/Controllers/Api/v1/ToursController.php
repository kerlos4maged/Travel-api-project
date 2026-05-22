<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToursRequest;
use App\Http\Resources\ToursResource;
use App\Models\Travel;

class ToursController extends Controller
{
    public function index(Travel $travel, ToursRequest $request)
    {
        $tours = $travel
            ->tours()
            ->when($request->has('dateFrom'), function ($query) use ($request) {
                $query->where('starting_date', '>=', $request->input('dateFrom'));
            })
            ->when($request->has('dateTo'), function ($query) use ($request) {
                $query->where('ending_date', '<=', $request->input('dateTo'));
            })
            ->when($request->has('pricefrom'), function ($query) use ($request) {
                $query->where('price', '>=', $request->input('pricefrom') * 100);
            })
            ->when($request->has('priceTo'), function ($query) use ($request) {
                $query->where('price', '<=', $request->input('priceTo') * 100);
            })
            // Note: SortOrder should be either 'asc' or 'desc' || sortBy should be a valid column name in the tours table
            ->when($request->has('sortBy') && $request->has('sortOrder'), function ($query) use ($request) {

                // create validation for input parameter
                // this is mean if sortBy value any value either those two values return

                if (! in_array($request->has('sortBy'), ['asc', 'desc'])) {
                    return;
                }

                $query->orderBy($request->input('sortBy'), $request->input('sortOrder'));
            })
            ->orderBy('starting_date')
            ->get();

        return ToursResource::collection($tours);
    }
}
