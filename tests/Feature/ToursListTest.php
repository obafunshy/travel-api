<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToursListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_tours_list_by_travel_slug_returns_correct_tours()
    {
       $travel = Travel::factory()->create();
       $tours = Tour::factory()->create(['travel_id' => $travel->id]);
       $response = $this->get('/api/v1/travels/'.$travel->slug . '/tours');

       $response->assertStatus(200);
       $response->assertJsonCount( 1, 'data');
       $response->assertJsonFragment(['id' => $tours->travel_id]);
    }

    public function test_tour_price_is_shown_correctly()
    {
        $travel = Travel::factory()->create();
        Tour::factory()->create([
            'travel_id'=> $travel->id,
            'price' => 123.45,
        ]);

        $response = $this->get('/api/v1/travels/'. $travel->slug .'/tours');

        $response->assertStatus(200);
        $response->assertJsonCount( 1, 'data');
        $response->assertJsonFragment(['price' => 123.45]);
    }

    public function test_tour_list_returns_pagination()
    {
        $toursPerPage = config('app.paginationPerPage.tours');
        $travel = Travel::factory()->create();
        Tour::factory($toursPerPage +1 )->create([
            'travel_id'=> $travel->id,
        ]);

        $response = $this->get('/api/v1/travels/'. $travel->slug .'/tours');

        $response->assertStatus(200);
        $response->assertJsonCount( 1, 'data');
        $response->assertJsonFragment(['meta.current_page', 1]);
    }

}
