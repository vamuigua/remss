<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\MainActions as TraitMainActions;
use App\Tenant;

class AdminTenantTest extends TestCase
{
    use RefreshDatabase, WithFaker, TraitMainActions;

    public function createTenant()
    {
        // create a tenant
        $tenant = Tenant::create([
            'surname' => 'John',
            'other_names' => 'Doe',
            'gender' => 'male',
            'national_id' => '12345678',
            'phone_no' => '0712345678',
            'email' => 'john@test.com'
        ]);
        return $tenant;
    }

    /** @test */
    public function a_tenant_can_be_created_by_an_admin()
    {
        $this->generateUserWithRoleAdmin();
        // create a tenant
        $response = $this->post('admin/tenants', [
            'surname' => 'John',
            'other_names' => 'Doe',
            'gender' => 'male',
            'national_id' => '12345678',
            'phone_no' => '0712345678',
            'email' => 'john@test.com'
        ]);
        $response->assertRedirect();
        $this->assertCount(1, Tenant::all());
    }

    /** @test */
    public function all_tenants_can_be_viewed_by_admin()
    {
        $this->generateUserWithRoleAdmin();
        factory(Tenant::class)->create();
        // get the Tenants index route
        $response = $this->get('admin/tenants');
        $response->assertOk();
        $this->assertCount(1, Tenant::all());
    }

    /** @test */
    public function a_single_tenant_can_be_viewed_by_admin()
    {
        $this->generateUserWithRoleAdmin();
        $tenant = $this->createTenant();
        // get the Tenants show route
        $response = $this->get('admin/tenants/' . $tenant->id);
        $response->assertOk();
        $this->assertEquals('John', $tenant->surname);
        $this->assertEquals('Doe', $tenant->other_names);
    }

    /** @test */
    public function a_tenant_details_can_be_updated_by_admin()
    {
        $this->generateUserWithRoleAdmin();
        $tenant = $this->createTenant();
        // update a tenant details
        $response = $this->patch('admin/tenants/' . $tenant->id, [
            'surname' => 'Peter',
            'other_names' => 'Bow',
            'gender' => 'male',
            'national_id' => '12345678',
            'phone_no' => '0712345678',
            'email' => 'john@test.com'
        ]);
        $response->assertRedirect();
        $updated_tenant = Tenant::findOrFail($tenant->id);
        $this->assertEquals('Peter', $updated_tenant->surname);
        $this->assertEquals('Bow', $updated_tenant->other_names);
    }

    /** @test */
    public function a_tenant_can_be_deleted_by_admin()
    {
        $this->generateUserWithRoleAdmin();
        $tenant = factory(Tenant::class)->create();
        // delete tenant
        $response = $this->delete('admin/tenants/' . $tenant->id);
        $response->assertRedirect();
        $this->assertCount(0, Tenant::all());
    }
}
