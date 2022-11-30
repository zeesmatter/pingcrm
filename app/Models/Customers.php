<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'parent_id', 'subscribed', 'data', 'status'];

    protected $casts = [
      'data'    =>  AsCollection::class
    ];

    public function phones()
    {
        return $this->hasMany(CustomerPhone::class);
    }

    public function address()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function memberships()
    {
        return $this->belongsToMany(Memberships::class)->using(CustomersMemberships::class);
    }

    public function activeMembership()
    {
        return $this->memberships()->withPivot('start_at', 'expire_at', 'status')->where('expire_at', '>', NOW());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->firstOrFail();
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
