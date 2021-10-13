<?php

namespace Tests\Feature;

use App\Models\CarBrand;
use App\Models\CarModel;
use Tests\TestCase;

/**
 * @see seeder SeedModels
 * to seed test user please do: "php artisan db:seed --class=SeedModels"
 */
class CarModelTest extends TestCase
{
    /**
     * default headers
     *
     * @var string[]
     */
    protected $defaultHeaders =  [
        'Accept' => 'application/json',
    ];

    /**
     * set up basic configs
     */
    protected function setUp(): void
    {
        parent::setUp();

        $response = $this->post('/api/login', [
            'email' => 'test@mail.com',
            'password' => 'test1234',
        ], $this->defaultHeaders);

        $responseData = json_decode($response->getContent());

        $this->defaultHeaders = array_merge(
            $this->defaultHeaders,
            ['Bearer' => $responseData->access_token]
        );
    }

    /**
     * test successful get models
     *
     * @test
     */
    public function test_get_models()
    {
        $response = $this->get('/api/models', $this->defaultHeaders);

        $response->assertStatus(200);
    }

    /**
     * test successful post brands
     *
     * @test
     */
    public function test_post_models()
    {
        $brand = CarBrand::first();

        $response = $this->post('/api/models', [
            'name' => 'NewAwesomeModel',
            'brand_id' => $brand->id
        ], $this->defaultHeaders);

        $response->assertStatus(200);

        CarModel::where('name', 'NewAwesomeModel')
            ->delete();
    }

    /**
     * test post models: validation errors
     *
     * @test
     */
    public function test_post_models_validation_error()
    {
        $response = $this->post('/api/models', [
            'name' => '12',
        ], $this->defaultHeaders);

        $response->assertStatus(422);
    }

    /**
     * test successful update brands
     *
     * @test
     */
    public function test_update_models()
    {
        $carModel = CarModel::create([
            'name' => 'NewAwesomeModel'
        ]);

        $response = $this->patch('/api/models/' . $carModel->id, [
            'name' => 'NewAwesomeModelUpdated',
        ], $this->defaultHeaders);

        $response->assertStatus(200);

        $carModelExists = CarModel::where('name', 'NewAwesomeModelUpdated')
            ->exists();

        $this->assertTrue($carModelExists);

        CarModel::where('name', 'NewAwesomeModelUpdated')
            ->delete();
    }

    /**
     * test update models validation error
     *
     * @test
     */
    public function test_update_models_validation_error()
    {
        $carModel = CarModel::create([
            'name' => 'NewAwesomeModel'
        ]);

        $response = $this->patch('/api/models/' . $carModel->id, [
            'name' => 'NewAwesomeModel Updated',
        ], $this->defaultHeaders);

        $response->assertStatus(422);

        CarModel::where('name', 'NewAwesomeModel')
            ->delete();
    }

    /**
     * test delete models
     *
     * @test
     */
    public function test_delete_brands()
    {
        $carModel = CarModel::create([
            'name' => 'NewAwesomeModel'
        ]);

        $response = $this->delete('/api/models/' . $carModel->id, [], $this->defaultHeaders);

        $response->assertStatus(200);

        $carModelExists = CarModel::where('name', 'NewAwesomeModel')
            ->exists();

        $this->assertTrue(!$carModelExists);
    }

    /**
     * test delete models: validation error
     *
     * @test
     */
    public function test_delete_models_validation_error()
    {
        $response = $this->delete('/api/models/' . PHP_INT_MAX, [], $this->defaultHeaders);

        $response->assertStatus(422);
    }
}
