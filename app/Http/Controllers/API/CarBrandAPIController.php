<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateCarBrandRequest;
use App\Http\Requests\DeleteCarBrandRequest;
use App\Http\Requests\GetCarBrandRequest;
use App\Http\Requests\UpdateCarBrandRequest;
use App\Models\CarBrand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Controller;

class CarBrandAPIController extends Controller
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return CarBrand::with('models')->get();
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getModelsById(int $id): Collection
    {
        return CarBrand::where('id', $id)
            ->with('models')
            ->get();
    }

    /**
     * @param int $id
     * @param int $modelId
     * @return Collection
     */
    public function getModelById(int $id, int $modelId): Collection
    {
        return CarBrand::where('id', $id)->with([
                'models' => function ($query) use ($modelId) {
                    $query->where('car_models.id', $modelId);
                }
            ])->get();
    }

    /**
     * @param GetCarBrandRequest $request
     * @return CarBrand
     */
    public function get(GetCarBrandRequest $request): CarBrand
    {
        return CarBrand::findOrFail($request->id);
    }

    /**
     * @param CreateCarBrandRequest $request
     */
    public function create(CreateCarBrandRequest $request): void
    {
        CarBrand::create(['name' => $request->name]);
    }

    /**
     * @param DeleteCarBrandRequest $request
     */
    public function delete(DeleteCarBrandRequest $request): void
    {
        CarBrand::findOrFail($request->id)
            ->delete();
    }

    /**
     * @param UpdateCarBrandRequest $request
     */
    public function update(UpdateCarBrandRequest $request): void
    {
        CarBrand::findOrFail($request->id)
            ->update($request->only('name'));
    }
}
