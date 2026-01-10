<?php

namespace Tests\Feature;

use App\Models\Truck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DistanceCalibrationTest extends TestCase
{

    use RefreshDatabase;
    protected User $user;
    protected Truck $truck;


    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->truck = Truck::factory()->create();
    }

    public function test_authenticated_user_can_access_distancecalibration_route()
    {
        $response = $this->actingAs($this->user)->get('/dstcalibrations');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_distancecalibration()
    {
        $response = $this->actingAs($this->user)->post('/dstcalibrations', [
            'trucks' => ['' . $this->truck->unitname . '']
        ]);

        $response->assertRedirect(route('dstcalibrations.index'));
    }


    public function test_unauthenticated_user_cannot_create_distancecalibration()
    {
        $response = $this->post('/dstcalibrations', [
            'trucks' => ['' . $this->truck->unitname . '']
        ]);

        $response->assertRedirect('/login');
    }

    public function test_validation_fails_if_truck_does_not_exist()
    {
        $response = $this->actingAs($this->user)->post('/dstcalibrations', [
            'trucks' => ['CARGO100']
        ]);

        $response->assertSessionHasErrors('trucks');
    }
}
