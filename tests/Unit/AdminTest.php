<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\MainActions as TraitMainActions;
use App\Tenant;

class AdminTest extends TestCase
{
    use RefreshDatabase, WithFaker, TraitMainActions;

    /** @test */
    public function a_tenant_can_be_added_through_form()
    {
        // create an admin
        // $this->generateUserWithRoleAdmin();

        // create a tenant
        $response = $this->post('admin/tenants', [
            'surname' => 'John',
            'other_names' => 'Doe',
            'gender' => 'male',
            'national_id' => '45969682',
            'phone_no' => '+254789654521',
            'email' => 'test@test.com',
        ]);

        // Assert the request was successful and redirected
        $response->assertStatus(302);

        // assert count in DB
        $this->assertCount(0, Tenant::all());
    }
}
