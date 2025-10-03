<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryUpdatingTest extends TestCase
{
    use RefreshDatabase;
    protected User $user;
    protected function setUp(): void{
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_check_if_category_edit_page_contains_the_right_content(): void
    {
        $category = Category::factory()->create();
        $response = $this->actingAs($this->user)->get(route('categories.edit', $category));

        $response->assertStatus(200)
            ->assertViewIs('categories.edit')
            ->assertViewHas('category', $category)
            ->assertSee($category->name)
            ->assertSee($category->description);
    }
    public function test_update_category(): void
    {
        $category = Category::factory()->create();
        $updatedCategory = [
            'name' => 'updating test name',
            'description' => 'updating test description ',
        ];

//        $response = $this->actingAs($this->user)->post(route('categories.update'), $category);
        $response = $this->actingAs($this->user)->put(route('categories.update', $category),$updatedCategory );
        $response->assertStatus(302)
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Category updated successfully');

        $this->assertDatabaseHas('categories', $updatedCategory);
        $this->assertDatabaseMissing('categories', $category->toArray());
    }

    public function test_category_name_is_required(): void
    {
        $category = Category::factory()->create();
        $updatedCategory = [
            'name' => '',
            'description' => 'updating test description ',
        ];

//        $response = $this->actingAs($this->user)->post(route('categories.update'), $category);
        $response = $this->actingAs($this->user)->patch(route('categories.update', $category),$updatedCategory );

        $response->assertStatus(302)
            ->assertSessionHasErrors('name','The name field is required.');

//        $this->assertDatabaseMissing('categories', $category->toArray());
        $this->assertDatabaseHas('categories', $category->toArray());
        $this->assertDatabaseMissing('categories', $updatedCategory);
    }

    public function test_category_name_is_at_least_3_characters(): void
    {
        $category = Category::factory()->create();
        $updatedCategory = [
            'name' => 'aa',
            'description' => 'updating test description ',
        ];

        $response = $this->actingAs($this->user)->patch(route('categories.update', $category),$updatedCategory );

        $response->assertStatus(302)
            ->assertSessionHasErrors('name','The name field must be at least 3 characters.');

        $this->assertDatabaseMissing('categories', $updatedCategory);
        $this->assertDatabaseHas('categories', $category->toArray());
    }
    public function test_category_name_must_be_at_most_255_characters(): void
    {
        $category = Category::factory()->create();
        $updatedCategory = [
            'name' => str_repeat('a', 256),
            'description' => 'updating test description ',
        ];

        $response = $this->actingAs($this->user)->patch(route('categories.update', $category),$updatedCategory );

        $response->assertStatus(302)
            ->assertSessionHasErrors('name');

        $this->assertDatabaseMissing('categories', $updatedCategory);
    }

    public function test_category_description_is_optional(): void
    {
        $category = Category::factory()->create();
        $updatedCategory = [
            'name' => 'updating test name',
        ];

        $response = $this->actingAs($this->user)->patch(route('categories.update', $category),$updatedCategory );

        $response->assertStatus(302)
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Category updated successfully');

        $this->assertDatabaseHas('categories', $updatedCategory);
    }
    public function test_category_description_must_be_at_most_1000_character(): void
    {
        $category = Category::factory()->create();
        $updatedCategory = [
            'name' => 'updating test name',
            'description' => str_repeat('a', 10001),
        ];

        $response = $this->actingAs($this->user)->patch(route('categories.update', $category),$updatedCategory );

        $response->assertStatus(302)
            ->assertSessionHasErrors('description','The description field must not be greater than 1000 characters.');

        $this->assertDatabaseHas('categories', $category->toArray());
        $this->assertDatabaseMissing('categories', $updatedCategory);
    }
}
