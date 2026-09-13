<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'address',
        'city',
        'province',
        'zip_code',
        'property_type',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }
}