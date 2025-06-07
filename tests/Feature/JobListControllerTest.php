<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobListControllerTest extends TestCase
{
    use RefreshDatabase;

    protected string $globalApiToken;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->globalApiToken = env('API_GLOBAL_TOKEN');

        Category::factory()->count(2)->create();
        Location::factory()->count(2)->create();
        Job::factory()->count(30)->create();
    }

    public function test_it_returns_paginated_list_with_defaults(): void
    {
        $response = $this->actingAs($this->user)->get('/jobs');

        $response->assertStatus(200);
        $response->assertViewIs('jobs.index');
    }

    public function test_it_filters_by_category_and_location(): void
    {
        $category = Category::first();
        $location = Location::first();

        $job = Job::factory()->create([
            'category_id' => $category->id,
            'location_id' => $location->id,
        ]);

        $response = $this->actingAs($this->user)->get("/jobs?category_id={$category->id}&location_id={$location->id}", [ 'X-API-KEY' => $this->globalApiToken ]);

        $response->assertStatus(200);
        $response->assertSee($category->name);
        $response->assertSee($location->name);
    }
}
