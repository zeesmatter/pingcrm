<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Memberships extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'trial_allowed', 'period', 'status', 'data'];

    protected $casts = [
        'data' =>   AsCollection::class,
    ];

    public function getTrialAllowedAttribute($value)
    {
        return $value ? true : false;
    }

    public function getStatusAttribute($value)
    {
        return $value ? true : false;
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
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
