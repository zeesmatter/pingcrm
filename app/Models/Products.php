<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'types_id', 'created_by', 'status', 'parent_id'];


    public function parent()
    {
        return $this->belongsTo(Products::class, 'parent_id');
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function getParentNameAttribute()
    {
        return $this->parent ? Str::of($this->parent->name)->title() : null;
    }

    public function type()
    {
        return $this->belongsTo(Types::class, 'types_id');
    }

    public function getTypeNameAttribute()
    {
        return $this->type ? Str::of($this->type->name)->title() : null;
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%' . $search . '%' )
                    ->orWhere('status', 'like', '%' . $search . '%' )
                    ->orWhere('description', 'like', '%' . $search . '%' )
                    ->orWhereHas('type', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    });
                ;
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
