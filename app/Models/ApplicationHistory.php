<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationHistory extends Model
{
    protected $table = 'application_history';

    public $timestamps = false;

    protected $fillable = ['application_id', 'admin_user_id', 'action', 'old_value', 'new_value'];

    // This model must never be updated or deleted — it is a permanent audit log.
    public function save(array $options = []): bool
    {
        if ($this->exists) {
            throw new \LogicException('ApplicationHistory records are immutable.');
        }
        return parent::save($options);
    }

    public function delete(): bool|null
    {
        throw new \LogicException('ApplicationHistory records cannot be deleted.');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class);
    }
}
