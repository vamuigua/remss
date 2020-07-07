<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobilePayment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mobile_payments';

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
    protected $fillable = [
        'TransactionType', 'TransID', 'TransTime', 'TransAmount', 'BusinessShortCode', 'BillRefNumber',
        'InvoiceNumber', 'OrgAccountBalance', 'ThirdPartyTransID', 'MSISDN', 'FirstName', 'MiddleName', 'LastName'
    ];
}
