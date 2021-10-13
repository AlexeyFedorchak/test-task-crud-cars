<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\SearchCarAPIRequest;
use App\Models\CarBrand;
use Illuminate\Routing\Controller;

class SearchCarAPIController extends Controller
{
    /**
     * default per page value
     *
     * @var int
     */
    protected $perPage = 5;

    /**
     * @param SearchCarAPIRequest $request
     * @return mixed
     */
    public function search(SearchCarAPIRequest $request)
    {
        $carBrandIds = CarBrand::select('car_brands.id')
            ->leftJoin('car_models', 'car_models.brand_id', '=', 'car_brands.id')
            ->where(function ($query) use ($request) {
                $query->where('car_brands.name', 'like', '%' . $request->search . '%')
                    ->orWhere('car_models.name', 'like', '%' . $request->search . '%');
            })
            ->get('car_brands.id');

        $ids = array_unique($carBrandIds->pluck('id')->toArray());

        $query = CarBrand::whereIn('id', $ids)
            ->with('models');

        return $query->paginate($request->per_page);
    }
}
