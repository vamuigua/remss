<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tenants';

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
    protected $fillable = ['surname', 'other_names', 'gender', 'national_id', 'phone_no', 'email', 'image', 'file'];

    public function genderOptions(){
        return [
            'male' => 'Male',
            'female' => 'Female',
        ];
    }

    public function tenantImage(){
        return ($this->image) ? '/storage/' . $this->image : '/img/no-image-available.png'; 
    }

    /**
     * Get the house record associated with the tenant.
     */
    public function house()
    {
        return $this->hasOne('App\House');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user(){
        return $this->belongsTo('\App\User');
    }
}
