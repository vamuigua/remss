<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

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
    protected $fillable = ['event_name', 'description', 'all_day', 'start_date', 'end_date', 'start_time', 'end_time', 'bg_color'];

    public function fullDayOptions()
    {
        return [
            'false' => 'No',
            'true' => 'Yes',
        ];
    }

    public function colorOptions()
    {
        return [
            '#007bff' => 'Blue',
            '#ffc107' => 'Yellow',
            '#28a745' => 'Green',
            '#dc3545' => 'Red',
            '#6c757d' => 'Grey',
        ];
    }
}
