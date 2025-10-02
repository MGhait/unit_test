<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CategoryRetrivalTest extends TestCase
{
    use RefreshDatabase;
//    protected User $user;
    protected function setUp(): void{
        parent::setUp();
        $this->actingAs(User::factory()->create());
//        $this->user = User::factory()->create();
    }

    public function test_check_if_categories_page_opens_successfully(): void
    {
        // $user = $this->getUser();

        $response = $this->get('/categories');

        $response->assertStatus(200)
            ->assertViewIs('categories.index')
            ->assertSeeText('Add New Category');
    }

    public function test_check_if_categories_page_contains_categories()
    {
        Category::factory()->count(4)->create();
        // $user = $this->getUser();

        $response = $this->get('/categories');

        $response->assertViewHas('categories', function ($categories) {
            return $categories->count() === 4;
        });
    }
    public function test_check_if_pagination_works_as_expected()
    {
        Category::factory()->count(15)->create();
        // $user = $this->getUser();

        $response = $this->get('/categories');

        $response->assertViewHas('categories', function ($categories) {
            return $categories->count() === 10;
        });
        $response = $this->get('/categories?page=2');
        $response->assertViewHas('categories', function ($categories) {
            return $categories->count() === 5;
        });
    }

//    public function getUser()
//    {
//        return User::factory()->create();
//    }
}
