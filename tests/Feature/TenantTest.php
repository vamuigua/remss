<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\MainActions as TraitMainActions;

class TenantTest extends TestCase
{
    use RefreshDatabase, TraitMainActions;

    /** @test  */
    public function tenants_not_authenticated_get_redirected_to_login()
    {
        $this->get('/tenant/dashboard')->assertRedirect('/login');
    }

    /** @test  */
    public function authenticated_tenants_can_see_tenant_dashboard()
    {
        $this->generateUserWithRoleUser();
        $this->get('/tenant/dashboard')->assertOk();
    }
}
