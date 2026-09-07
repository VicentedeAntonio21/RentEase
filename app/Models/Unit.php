<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'unit_name',
        'rent_price',
        'bedrooms',
        'bathrooms',
        'area_sqm',
        'status',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeInCity($query, ?string $city)
    {
        return $query->when($city, function ($q) use ($city) {
            $q->whereHas('property', fn($p) => $p->where('city', 'like', "%{$city}%"));
        });
    }

    public function scopePriceBetween($query, ?float $min, ?float $max)
    {
        return $query
            ->when($min, fn($q) => $q->where('rent_price', '>=', $min))
            ->when($max, fn($q) => $q->where('rent_price', '<=', $max));
    }

    public function scopeMinBedrooms($query, ?int $bedrooms)
    {
        return $query->when($bedrooms, fn($q) => $q->where('bedrooms', '>=', $bedrooms));
    }

    public function scopePropertyType($query, ?string $type)
    {
        return $query->when($type, function ($q) use ($type) {
            $q->whereHas('property', fn($p) => $p->where('property_type', $type));
        });
    }
}