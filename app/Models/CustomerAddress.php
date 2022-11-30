<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = ['street_number', 'customers_id', 'street_name', 'area', 'city', 'postal_code', 'notes', 'state', 'country',
        'lat', 'lng', 'google_address_id', 'data'];

    public static function fillableFields()
    {
        return (new static())->fillable;
    }

    public function user()
    {
        return $this->belongsTo(Customers::class);
    }
}
