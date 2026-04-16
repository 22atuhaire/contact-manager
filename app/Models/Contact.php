<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'normalized_phone',
        'email',
        'address',
        'group_id',
        'is_favorite',
    ];

    protected function casts(): array
    {
        return [
            'is_favorite' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(ContactGroup::class, 'group_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ContactTag::class, 'contact_contact_tag', 'contact_id', 'tag_id')
            ->withTimestamps();
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(ContactInteraction::class)->latest('interacted_at');
    }
}
