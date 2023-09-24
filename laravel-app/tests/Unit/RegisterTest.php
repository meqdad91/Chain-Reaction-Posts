<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    private $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * This test will try to Register with
     * correct data
     *
     * @return void
     */
    public function test_register_with_success_response(): void
    {
        $response = $this->post('/api/v1/register',[
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'c_password' => 'password'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * This test will try to Register with
     * Existed email
     *
     * @return void
     */
    public function test_register_with_existed_email(): void
    {
        $response = $this->post('/api/v1/register',[
            'name' => fake()->name(),
            'email' => $this->user->email,
            'password' => 'password',
            'c_password' => 'password'
        ]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * This test will try to Register with
     * missing data
     *
     * @return void
     */
    public function test_register_with_missing_data(): void
    {
        $response = $this->post('/api/v1/register',[
            'name' => $this->user->name,
        ]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
    /**
     * this test will try to Log in with
     * correct username and password
     *
     * @return void
     */
    public function test_login_with_success_response(): void
    {
        $response = $this->post('/api/v1/login',[
            'email' => $this->user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * this test will try to Log in with
     * wrong password
     *
     * @return void
     */
    public function test_login_with_wrong_password(): void
    {
        $response = $this->post('/api/v1/login',[
            'email' => $this->user->email,
            'password' => 'paassword'
        ]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
