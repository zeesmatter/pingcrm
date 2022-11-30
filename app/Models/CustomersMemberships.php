<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomersMemberships extends Pivot
{
    protected $fillable = ['customers_id', 'memberships_id', 'start_at', 'expire_at', 'status'];

    public function forceExpire()
    {
        $this->status = 'force_expired';
        $this->expire_at = NOW();
        $this->save();
    }

    public function getStartAtAttribute($value)
    {
        return Carbon::make($value)->format('d M Y');
    }

    public function getExpireAtAttribute($value)
    {
        return Carbon::make($value)->format('d M Y');
    }

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Expired';
    }

}
