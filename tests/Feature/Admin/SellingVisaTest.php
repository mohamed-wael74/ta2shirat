<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\SellingVisa;
use App\Models\StatusType;
use App\Models\User;
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

        $this->user = User::factory()->create();

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $this->user->attachPermission($permission);
        }

        Passport::actingAs($this->user);
    }

    public function test_index()
    {
        SellingVisa::factory(5)->create();

        $response = $this->getJson(route('admin.selling-visas.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'provider_name',
                        'contact_email',
                        'is_done',
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

    public function test_store_route_does_not_exist()
    {
        $this->assertFalse(Route::has('admin.selling-visa.store'));
    }

    public function test_show()
    {
        $sellingVisa = SellingVisa::factory()->create();

        $response = $this->getJson(route('admin.selling-visas.show', $sellingVisa->id));

        $response->assertOk()
            ->assertJson([
                'selling_visa' => [
                    'id' => $sellingVisa->id,
                ]
            ]);
    }

    public function test_delete_route_does_not_exist()
    {
        $this->assertFalse(Route::has('admin.selling-visa.destroy'));
    }
}
