<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryDeletingTest extends TestCase
{
    use RefreshDatabase;
    protected User $user;
    protected function setUp(): void{
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_delete_category()
    {
        // store category
        $category = Category::factory()->create();

        //act as & go to delete
        $response = $this->actingAs($this->user)->delete(route('categories.destroy', $category));

        // redirect with success message & assertion
        $response->assertStatus(302)
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Category deleted successfully');

        $this->assertDatabaseMissing('categories', $category->toArray());
    }
}
