<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryAuthorizationTest extends TestCase
{
    public function test_guest_cannot_access_categories_page()
    {
        $response = $this->get(route('categories.index'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function test_guest_cannot_access_create_page()
    {
        $response = $this->get(route('categories.create'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function test_guest_cannot_store_categories()
    {
        $category = Category::factory()->make();
        $response = $this->post(route('categories.store', $category));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function test_guest_cannot_access_show_page()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('categories.show', $category));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function test_guest_cannot_access_edit_page()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('categories.edit', $category));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function test_guest_cannot_update_category()
    {
        $category = Category::factory()->create();
        $updatedCategory = [
            'name' => 'updating test name',
            'description' => 'updating test description ',
        ];

        //        $response = $this->actingAs($this->user)->post(route('categories.update'), $category);
        $response = $this->patch(route('categories.update', $category), $updatedCategory);

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
    public function test_guest_cannot_delete_category()
    {
        $category = Category::factory()->create();
        
        $response = $this->delete(route('categories.destroy', $category));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

}
