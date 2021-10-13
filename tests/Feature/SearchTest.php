<?php

namespace Tests\Feature;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * please make sure you run seeders
 */
class SearchTest extends TestCase
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
     * test if search return correct results
     */
    public function test_search_successful()
    {
        //seed some random brand
        $brandName = Str::random() . now();
        $brand = CarBrand::create(['name' => $brandName]);

        //seed some random model
        $modelName = Str::random() . now();
        CarModel::create([
            'name' => $modelName,
            'brand_id' => $brand->id,
        ]);

        $response = $this->get('/api/search?search=' . $brandName, $this->defaultHeaders);
        $results = json_decode($response->getContent());

        $this->assertNotEmpty($results->data);
        $this->assertTrue(count($results->data) === 1);

        $response = $this->get('/api/search?test=1&search=' . $modelName, $this->defaultHeaders);
        $results = json_decode($response->getContent());

        $this->assertNotEmpty($results->data);
        $this->assertTrue(count($results->data) === 1);

        //clear after yourself
        CarModel::where('name', $modelName)
            ->delete();

        CarBrand::where('name', $brandName)
            ->delete();
    }

    /**
     * test with no results
     */
    public function test_search_no_results()
    {
        $response = $this->get('/api/search?search=' . Str::random(), $this->defaultHeaders);
        $results = json_decode($response->getContent());

        $this->assertEmpty($results->data);
    }

    /**
     * test validation error
     */
    public function test_search_validation_error()
    {
        $response = $this->get('/api/search', $this->defaultHeaders);

        $response->assertStatus(422);
    }
}
