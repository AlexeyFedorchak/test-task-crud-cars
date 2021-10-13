<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateCarModelRequest;
use App\Http\Requests\DeleteCarModelRequest;
use App\Http\Requests\GetCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Controller;

class CarModelAPIController extends Controller
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return CarModel::with('brand')->get();
    }

    /**
     * @param GetCarModelRequest $request
     * @return CarModel
     */
    public function get(GetCarModelRequest $request): CarModel
    {
        return CarModel::findOrFail($request->id);
    }

    /**
     * @param CreateCarModelRequest $request
     */
    public function create(CreateCarModelRequest $request): void
    {
        CarModel::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
        ]);
    }

    /**
     * @param DeleteCarModelRequest $request
     */
    public function delete(DeleteCarModelRequest $request): void
    {
        CarModel::findOrFail($request->id)
            ->delete();
    }

    /**
     * @param UpdateCarModelRequest $request
     */
    public function update(UpdateCarModelRequest $request): void
    {
        CarModel::findOrFail($request->id)
            ->update($request->only('name'));
    }
}
