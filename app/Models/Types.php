<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Types extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'resource_name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Types::class, 'parent_id');
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function getParentNameAttribute()
    {
        return $this->parent ? Str::of($this->parent->name)->title() : null;
    }

    public function getResourceNameAttribute($value)
    {
        return Str::of($value)->title();
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
