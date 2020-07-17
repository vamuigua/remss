<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseAdvert extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'house_adverts';

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
    protected $fillable = ['house', 'location', 'images', 'details', 'description', 'rent', 'booking_status', 'file'];

    public function bookingStatusOptions()
    {
        return [
            'Not Booked' => 'Not Booked',
            'Booked' => 'Booked'
        ];
    }
}
