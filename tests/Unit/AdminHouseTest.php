<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\MainActions as TraitMainActions;
use App\House;

class AdminHouseTest extends TestCase
{
    use RefreshDatabase, WithFaker, TraitMainActions;

    public function createHouse()
    {
        // create a house
        $house = House::create([
            'house_no' => 'A1',
            'features' => 'One Bedroom, Open-Kitchen Plan',
            'rent' => '200000',
            'status' => 'vacant',
            'water_meter_no' => '65458552',
            'electricity_meter_no' => '52526458'
        ]);
        return $house;
    }

    /** @test */
    public function generated_user_has_admin_role()
    {
        $user = $this->generateUserWithRoleAdmin();
        $this->assertEquals(true, $user->hasRole('Admin'));
    }

    /** @test */
    public function a_house_can_be_created_by_an_admin()
    {
        $this->generateUserWithRoleAdmin();
        $response = $this->post('admin/houses', [
            'house_no' => 'A1',
            'features' => 'One Bedroom, Open-Kitchen Plan',
            'rent' => '200000',
            'status' => 'vacant',
            'water_meter_no' => '65458552',
            'electricity_meter_no' => '52526458'
        ]);
        // Assert the request was successful and was redirected
        $response->assertRedirect();
        $this->assertCount(1, House::all());
    }

    /** @test */
    public function all_houses_can_be_viewed_by_admin()
    {
        $this->generateUserWithRoleAdmin();
        $this->createHouse();
        // get the Houses index route
        $response = $this->get('admin/houses');
        $response->assertOk();
        $this->assertCount(1, House::all());
    }

    /** @test */
    public function a_single_house_can_be_viewed_by_admin()
    {
        $this->generateUserWithRoleAdmin();
        $house = $this->createHouse();
        // get the Houses show route
        $response = $this->get('admin/houses/' . $house->id);
        $response->assertOk();
        $this->assertEquals('A1', $house->house_no);
        $this->assertEquals('One Bedroom, Open-Kitchen Plan', $house->features);
    }

    /** @test */
    public function a_house_details_can_be_updated_by_admin()
    {
        $this->generateUserWithRoleAdmin();
        $house = $this->createHouse();
        // update a house details
        $response = $this->patch('admin/houses/' . $house->id, [
            'house_no' => 'A4',
            'features' => 'Two Bedroom, Fully-Furnished',
            'rent' => '200000',
            'status' => 'vacant',
            'water_meter_no' => '65458552',
            'electricity_meter_no' => '52526458'
        ]);
        $response->assertRedirect();
        $updated_house = House::findOrFail($house->id);
        $this->assertEquals('A4', $updated_house->house_no);
        $this->assertEquals('Two Bedroom, Fully-Furnished', $updated_house->features);
    }

    /** @test */
    public function a_house_can_be_deleted_by_admin()
    {
        $this->generateUserWithRoleAdmin();
        $house = $this->createHouse();
        // delete house
        $response = $this->delete('admin/houses/' . $house->id);
        $response->assertRedirect();
        $this->assertCount(0, House::all());
    }
}
