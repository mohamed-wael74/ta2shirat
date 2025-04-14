<?php

namespace Tests\Feature\Website;

use App\Models\Country;
use App\Models\EmploymentType;
use App\Models\SellingVisa;
use App\Models\StatusType;
use App\Models\User;
use App\Models\VisaType;
use Database\Seeders\StatusTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SellingVisaTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(StatusTypeSeeder::class);

        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }
    public function test_index()
    {
        SellingVisa::factory(5)->for($this->user)->create();

        $response = $this->getJson(route('website.selling-visas.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'provider_name',
                        'contact_email',
                        'done',
                        'created_at',
                        'user',
                        'nationality',
                        'destination',
                        'visa_type',
                        'employment_type',
                        'current_status',
                        'statuses',
                    ],
                ],
            ]);
    }

    public function test_store()
    {
        $data = [
            'nationality' => Country::factory()->create()->id,
            'destination' => Country::factory()->create()->id,
            'visa_type' => VisaType::factory()->create()->id,
            'employment_type' => EmploymentType::factory()->create()->id,
            'provider_name' => $this->faker->name,
            'contact_email' => $this->faker->email,
            'required_qualifications' => $this->faker->sentence,
            'message' => $this->faker->sentence,
        ];

        $response = $this->postJson(route('website.selling-visas.store'), $data);

        $response->assertOk()
            ->assertJson([
                'selling_visa' => [
                    'provider_name' => $data['provider_name'],
                    'contact_email' => $data['contact_email'],
                ],
            ]);

        $this->assertDatabaseHas('selling_visas', [
            'contact_email' => $data['contact_email'],
        ]);
    }

    public function test_show()
    {
        $sellingVisa = SellingVisa::factory()->for($this->user)->create();

        $response = $this->getJson(route('website.selling-visas.show', $sellingVisa->id));

        $response->assertOk()
            ->assertJson([
                'selling_visa' => [
                    'id' => $sellingVisa->id,
                ]
            ]);
    }

    public function test_update()
    {
        $sellingVisa = SellingVisa::factory()->for($this->user)->create([
            'is_done' => false,
        ]);

        $statusTypes = StatusType::whereIn('type', [
            'pending',
            'reviewing',
            'accepted',
            'rejected',
            'sold',
            'canceled'
        ])->get();

        foreach ($statusTypes as $statusType) {
            $sellingVisa->statuses()->create([
                'status_type_id' => $statusType->id,
            ]);
        }

        $response = $this->putJson(route('website.selling-visas.update', $sellingVisa));
        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'selling_visa' => [
                    'id',
                    'provider_name',
                    'contact_email',
                    'required_qualifications',
                    'message',
                    'done',
                    'created_at',
                    'user',
                    'nationality',
                    'destination',
                    'visa_type',
                    'employment_type',
                    'statuses',
                    'current_status',
                ]
            ]);

        $this->assertTrue(SellingVisa::find($sellingVisa->id)->is_done);
    }

    public function test_delete_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.selling-visa.destroy'));
    }
}
