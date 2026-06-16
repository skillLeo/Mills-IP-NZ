<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    protected $fillable = [
        'trademark_description',
        'logo_file_path',
        'business_description',
        'legal_owner_name',
        'legal_owner_type',
        'abn',
        'contact_name',
        'contact_email',
        'contact_phone',
        'additional_notes',
        'status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public function notes(): HasMany
    {
        return $this->hasMany(ApplicationNote::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(ApplicationHistory::class);
    }
}
