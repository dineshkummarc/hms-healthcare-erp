<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'dependencies' => 'array',
            'is_core' => 'boolean',
            'is_active_default' => 'boolean',
        ];
    }

    public function activations(): HasMany
    {
        return $this->hasMany(ModuleActivation::class, 'module_key', 'key');
    }
}
