<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    // Nama tabel (opsional, karena otomatis "categories")
    protected $table = 'categories';

    // Kolom yang bisa diisi secara mass assignment
    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];

    // Relasi ke model User (pembuat kategori)
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}