<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'expenditures';

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
    protected $fillable = ['outgoings', 'amount', 'particulars', 'expenditure_date'];

    public $keyType = 'string';

    // get all months of the year with its respective no. in the calender
    public static function monthsOfTheYear()
    {
        $months = array();

        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            array_push($months, [$month => $m]);
        }

        return $months;
    }
}
