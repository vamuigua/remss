<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'houses';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['house_no', 'features', 'rent', 'status', 'water_meter_no', 'electricity_meter_no'];

    public function statusOptions(){
        return [
            'vacant' => 'Vacant',
            'occipied' => 'Occupied'
        ];
    }

    /**
     * Get the tenant that owns the house.
     */
    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }
}
