<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\MainActions as TraitMainActions;

class AdminTest extends TestCase
{
    use RefreshDatabase, TraitMainActions;

    /** @test  */
    public function admins_not_authenticated_get_redirected_to_login()
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    /** @test  */
    public function authenticated_admins_can_see_admin_dashboard()
    {
        $this->generateUserWithRoleAdmin();
        $this->get('/admin/dashboard')->assertOk();
    }
}
