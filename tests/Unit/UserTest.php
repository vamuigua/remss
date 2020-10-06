<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Tests\Traits\MainActions as TraitMainActions;

class UserTest extends TestCase
{
    use RefreshDatabase, TraitMainActions;

    /** @test  */
    public function a_user_belongs_to_many_roles()
    {
        $user = factory(User::class)->create();
        $this->generateAdminRole();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->roles);
    }
}
