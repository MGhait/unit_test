<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_check_if_home_page_works_fine(): void
    {
        // go to url "/"
        // $response = $this->get('/');
        $response = $this->get(route('index'));
        // dd($response);

        // response with status code 200
        $response->assertStatus(200);

        // view opened sucssefully
        $response->assertViewIs('welcome');
        // $response->assertSeeText("Laracast");
    }
}
