<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

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
    protected $fillable = ['tenant_id', 'invoice_id', 'payment_type', 'payment_date', 'payment_no', 'amount_paid', 'balance', 'comments'];

    public function paymentTypeOptions(){
        return [
            'rent' => 'Rent',
            'water' => 'Water',
            'electricity' => 'Electricity'
        ];
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}