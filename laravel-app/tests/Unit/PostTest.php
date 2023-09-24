<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostTest extends TestCase
{

    private $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * This test will try to create a post
     * with correct data
     *
     * @return void
     */
    public function test_create_post_successfully(): void
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->json('POST', '/api/v1/posts', [
                'title' => fake()->title(),
                'description' => fake()->text()
            ],
            [
                'Accept' => 'application/json'
            ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * This test will try to creat a post
     * without authentication
     *
     * @return void
     */

    public function test_create_post_without_auth(): void
    {
        $response = $this->json('POST', '/api/v1/posts', [
            'title' => fake()->title(),
            'description' => fake()->text()
        ],
        [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
    /**
     * This test will try to get
     * all the posts that belong
     * to the logined user when
     * its empty
     *
     * @return void
     */
    public function test_get_all_posts_for_the_user(): void
    {
        $auth = $this->actingAs($this->user, 'sanctum');
        $post =$auth->json('POST', '/api/v1/posts', [
                'title' => fake()->title(),
                'description' => fake()->text()
            ],
            [
                'Accept' => 'application/json'
            ]);

        $response = $auth->json('GET', '/api/v1/posts', [],
            [
                'Accept' => 'application/json'
            ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * This test will try to get
     * all the posts that belong
     * to the logined user
     *
     * @return void
     */
    public function test_update_post_successfully(): void
    {
        $auth = $this->actingAs($this->user, 'sanctum');
        $post = $auth->json('POST', '/api/v1/posts', [
                'title' => fake()->title(),
                'description' => fake()->text()
            ],
            [
                'Accept' => 'application/json'
            ]);
        $postId = $post->getData()->data->id;
        $response = $auth->json('PATCH', '/api/v1/posts/'.$postId, [
            'title' => fake()->title(),
            'description' => fake()->text()
            ],
            [
                'Accept' => 'application/json'
            ]);
       $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * This test will try to get
     * all the posts that belong
     * to the logined user
     *
     * @return void
     */
    public function test_delete_post_successfully(): void
    {
        $auth = $this->actingAs($this->user, 'sanctum');
        $post = $auth->json('POST', '/api/v1/posts', [
            'title' => fake()->title(),
            'description' => fake()->text()
        ],
            [
                'Accept' => 'application/json'
            ]);
        $postId = $post->getData()->data->id;
        $response = $auth->json('DELETE', '/api/v1/posts/'.$postId, [],
            [
                'Accept' => 'application/json'
            ]);
        $response->assertStatus(Response::HTTP_OK);
    }


}
