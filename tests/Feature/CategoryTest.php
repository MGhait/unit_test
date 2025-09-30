<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     * must start with test
     */
    public function test_example_custom(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    // will not exeute
    public function example_custom(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_example_custom_2(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    // will run but not best practice must be descriptive
    public function test_test1(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_check_if_home_page_works_fine(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    // camel case will work fine but not human readable
    //  if was pascal case will not executed [pascal case is camal case with first letter capital]
    //  cabab case will cause an error
    public function testCheckIfHomePageWorksFine(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
