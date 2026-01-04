<?php

namespace Tests\Feature;

use App\Models\Fault;
use App\Models\Repair;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepairTest extends TestCase
{

    use RefreshDatabase;

    protected User $user;
    protected Truck $truck;
    protected Fault $fault;
    protected Repair $repair;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->truck = Truck::factory()->create();
        $this->fault = Fault::factory()->create();
        $this->repair = Repair::factory()->create();
    }

    public function test_guest_cannot_access_repairs()
    {
        $response  = $this->get('/repairs');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_repairs()
    {
        $response = $this->actingAs($this->user)->get('/repairs');
        $response->assertStatus(200);
    }


    public function test_truckid_is_required_when_creating_repair()
    {

        $response = $this->actingAs($this->user)->post('/repairs', [
            'fault_id' => 10,
        ]);
        $response->assertSessionHasErrors('truck_id');
    }

    public function test_authenticated_user_can_create_repair()
    {


        $response = $this->actingAs($this->user)->post('/repairs', [
            'truck_id' => $this->truck->id,
            'fault_id' => $this->fault->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Record created Successful');
        $this->assertDatabaseHas('repairs', [
            'truck_id' => $this->truck->id,
            'fault_id' => $this->fault->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_cannot_create_duplicate_pending_repair()
    {

        Repair::factory()->create([
            'truck_id' => $this->truck->id,
            'fault_id' => $this->fault->id,
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

         $response = $this->actingAs($this->user)->post('/repairs', [
            'truck_id' => $this->truck->id,
            'fault_id' => $this->fault->id,
        ]);

        $response->assertSessionHas('warning');
    }

    public function test_unauthenticated_user_cannot_create_repair()
    {

        $response = $this->post('/repairs', [
            'truck_id' => $this->truck->id,
            'fault_id' => $this->fault->id,
        ]);
        $response->assertRedirect('/login');
    }


    public function test_authenticated_user_can_close_repair()
    {
        $repair = Repair::factory()->create();

        $response = $this->actingAs($this->user)->put(
            route('closerepair', $repair->id),
            [
                'comments' => 'Loose Connection',
                'repairedondate' => now()->toDateString(),
                'donebyid' => $this->user->id,
            ]
        );
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('repairs', [
            'id' => $repair->id,
            'status' => 'completed',
        ]);
    }


    public function test_unauthenticated_user_cannot_close_repair()
    {
        $repair = Repair::factory()->create();

        $response = $this->put(
            route('closerepair', $repair->id),
            [
                'comments' => 'Loose Connection',
                'repairedondate' => now()->toDateString(),
                'donebyid' => $this->user->id,
            ]
        );
        $response->assertRedirect('/login');
    }


    public function test_comments_are_required_when_closing_repair()
    {

        $repair = Repair::factory()->create();

        $response = $this->actingAs($this->user)->put(
            route('closerepair', $repair->id),
            [
                'repairedondate' => now()->toDateString(),
            ]
        );

        $response->assertSessionHasErrors('comments');
    }

    public function test_repaired_on_date_cannot_be_in_future_when_closing_repair()
    {
        $response = $this->actingAs($this->user)->put(
            route('closerepair', $this->repair->id),
            [
                'comments' => 'Done',
                'repairedondate' => now()->addDay()->toDateString(),
            ]
        );

        $response->assertSessionHasErrors('repairedondate');
    }

    public function test_closing_non_existent_repair_returns_404()
    {

        $response = $this->actingAs($this->user)->put(
            route('closerepair', 1023),
            [
                'comments' => 'Done',
                'repairedondate' => now()->toDateString(),
                'donebyid' => $this->user->id,
            ]
        );

        $response->assertStatus(404);
    }
}
