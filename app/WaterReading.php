<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaterReading extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'water_readings';

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
    protected $fillable = ['house_id', 'prev_reading', 'current_reading', 'units_used', 'cost_per_unit', 'total_charges'];

    public function house()
    {
        return $this->belongsTo('App\House');
    }
}
