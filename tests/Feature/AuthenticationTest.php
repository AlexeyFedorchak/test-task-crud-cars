<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @see seeder UserSeeder
 * to seed test user please do: "php artisan db:seed --class=SeedUsers"
 */
class AuthenticationTest extends TestCase
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
     * test successful login
     *
     * @test
     */
    public function test_successful_login()
    {
        $response = $this->post('/api/login', [
            'email' => 'test@mail.com',
            'password' => 'test1234',
        ], $this->defaultHeaders);

        $response->assertStatus(200);
    }

    /**
     * test failed login
     *
     * @test
     */
    public function test_failed_login()
    {
        $response = $this->post('/api/login', [
            'email' => 'test@mail.com',
            'password' => Str::random(),
        ], $this->defaultHeaders);

        $response->assertStatus(401);
    }

    /**
     * test successful logout
     *
     * @test
     */
    public function test_successful_logout()
    {
        $authenticationData = $this->post('/api/login', [
            'email' => 'test@mail.com',
            'password' => 'test1234',
        ], $this->defaultHeaders);

        $responseData = json_decode($authenticationData->getContent());

        $response = $this->post('/api/logout', [],
            array_merge(
                $this->defaultHeaders,
                ['Bearer' => $responseData->access_token]
            )
        );

        $response->assertStatus(200);
    }

    /**
     * test failed logout
     *
     * @test
     */
    public function test_failed_logout()
    {
        $response = $this->post('/api/logout', [], $this->defaultHeaders);

        $response->assertStatus(401);
    }

    /**
     * test successful sign up
     *
     * @test
     */
    public function test_successful_registration()
    {
        $response = $this->post('/api/registration', [
            'name' => 'NewName',
            'email' => 'email@new.com',
            'password' => 'newtestpassword',
        ], $this->defaultHeaders);

        $response->assertStatus(200);

        User::where('email', 'email@new.com')
            ->delete();
    }

    /**
     * test failed sign up when validation is failed
     *
     * @test
     */
    public function test_failed_registration_with_validation()
    {
        //case: incorrect password
        $response = $this->post('/api/registration', [
            'name' => 'NewName',
            'email' => 'email+1@new.com',
            'password' => 'newt',
        ], $this->defaultHeaders);

        $response->assertStatus(422);

        //case: incorrect name
        $response = $this->post('/api/registration', [
            'name' => 'New Name',
            'email' => 'email+1@new.com',
            'password' => 'newtest',
        ], $this->defaultHeaders);

        $response->assertStatus(422);

        //case: incorrect email
        $response = $this->post('/api/registration', [
            'name' => 'NewName',
            'email' => 'email+1new.com',
            'password' => 'newtest',
        ], $this->defaultHeaders);

        $response->assertStatus(422);
    }
}
