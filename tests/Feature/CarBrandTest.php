<?php

namespace Tests\Feature;

use App\Models\CarBrand;
use Tests\TestCase;

/**
 * @see seeder SeedBrands
 * to seed test user please do: "php artisan db:seed --class=SeedBrands"
 */
class CarBrandTest extends TestCase
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
     * test successful get brands
     *
     * @test
     */
    public function test_get_brands()
    {
        $response = $this->get('/api/brands', $this->defaultHeaders);

        $response->assertStatus(200);
    }

    /**
     * test successful post brands
     *
     * @test
     */
    public function test_post_brands()
    {
        $response = $this->post('/api/brands', [
            'name' => 'NewAwesomeBrand',
        ], $this->defaultHeaders);

        $response->assertStatus(200);

        $carBrandExists = CarBrand::where('name', 'NewAwesomeBrand')
            ->exists();

        $this->assertTrue($carBrandExists);

        CarBrand::where('name', 'NewAwesomeBrand')
            ->delete();
    }

    /**
     * test post brands: validation errors
     *
     * @test
     */
    public function test_post_brands_validation_error()
    {
        $response = $this->post('/api/brands', [
            'name' => 'New Awesome Brand',
        ], $this->defaultHeaders);

        $response->assertStatus(422);
    }

    /**
     * test successful update brands
     *
     * @test
     */
    public function test_update_brands()
    {
        $carBrand = CarBrand::create([
            'name' => 'NewAwesomeBrand'
        ]);

        $response = $this->patch('/api/brands/' . $carBrand->id, [
            'name' => 'NewAwesomeBrandUpdated',
        ], $this->defaultHeaders);

        $response->assertStatus(200);

        $carBrandExists = CarBrand::where('name', 'NewAwesomeBrandUpdated')
            ->exists();

        $this->assertTrue($carBrandExists);

        CarBrand::where('name', 'NewAwesomeBrandUpdated')
            ->delete();
    }

    /**
     * test update brands validation error
     *
     * @test
     */
    public function test_update_brands_validation_error()
    {
        $carBrand = CarBrand::create([
            'name' => 'NewAwesomeBrand'
        ]);

        $response = $this->patch('/api/brands/' . $carBrand->id, [
            'name' => 'NewAwesomeBrand Updated',
        ], $this->defaultHeaders);

        $response->assertStatus(422);

        CarBrand::where('name', 'NewAwesomeBrand')
            ->delete();
    }

    /**
     * test delete brands
     *
     * @test
     */
    public function test_delete_brands()
    {
        $carBrand = CarBrand::create([
            'name' => 'NewAwesomeBrand'
        ]);

        $response = $this->delete('/api/brands/' . $carBrand->id, [], $this->defaultHeaders);

        $response->assertStatus(200);

        $carBrandExists = CarBrand::where('name', 'NewAwesomeBrand')
            ->exists();

        $this->assertTrue(!$carBrandExists);
    }

    /**
     * test delete brands: validation error
     *
     * @test
     */
    public function test_delete_brands_validation_error()
    {
        $response = $this->delete('/api/brands/' . PHP_INT_MAX, [], $this->defaultHeaders);

        $response->assertStatus(422);
    }
}
