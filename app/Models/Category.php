<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // Tentukan kolom yang dapat diisi 
    protected $fillable = [
        'title', // Nama kategori
        'user_id', // ID pengguna yang memiliki kategori
    ];

    // Relasi ke model lain 
    public function todo()
    {
        return $this->hasMany(Todo::class);
    }
}
