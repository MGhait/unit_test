<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryAPITest extends TestCase
{
    use RefreshDatabase;
    protected User $user;
    protected function setUp(): void
    {
        parent::setUp();
        //        $this->user = User::factory()->create();
        if ($this->name() !== 'test_prevent_unauthenticated_user_from_listing_categories') {
            Sanctum::actingAs(
                User::factory()->create(),
                ['view-tasks']
            );
        }
    }
    // auth user to run manually in each funtion that we need insted of setup
    //    public function authUser()
    //    {
    //        Sanctum::actingAs(
    //            User::factory()->create(),
    //            ['view-tasks']
    //        );
    //    }

    public function test_prevent_unauthenticated_user_from_listing_categories(): void
    {
        $response = $this->getJson('/api/categories');

        $response->assertStatus(401);
    }

    public function test_list_all_categories(): void
    {
        Category::factory()->count(5)->create();
        //        $this->authUser();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }
    public function test_create_category(): void
    {
        $category = Category::factory()->make();

        $response = $this->postJson('/api/categories', $category->toArray());

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => $category->name]);
    }
    public function test_show_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name]);
    }

    public function test_update_category(): void
    {
        $category = Category::factory()->create();
        $categoryUpdated = [
            'name' => 'Updated name',
            'description' => 'Updated description',
        ];

        $response = $this->patchJson("/api/categories/{$category->id}", $categoryUpdated);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $categoryUpdated['name']]);
    }
    public function test_delete_category(): void
    {
        $category = Category::factory()->create();


        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(204);
    }
}
