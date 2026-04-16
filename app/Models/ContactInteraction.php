<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'user_id',
        'kind',
        'note',
        'interacted_at',
    ];

    protected function casts(): array
    {
        return [
            'interacted_at' => 'datetime',
        ];
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
