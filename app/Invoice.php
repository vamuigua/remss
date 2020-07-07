<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no', 'invoice_date', 'due_date',
        'title', 'sub_total', 'discount',
        'grand_total', 'tenant_id',
        'client_address', 'status'
    ];

    public function statusOptions(){
        return [
            'active' => 'Active',
            'closed' => 'Closed',
        ];
    }

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
