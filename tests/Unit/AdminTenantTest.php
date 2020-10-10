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
}
