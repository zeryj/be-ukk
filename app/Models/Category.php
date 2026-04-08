<?php

namespace App\Models;

use App\Models\Aspirasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, Notifiable;
    protected   $fillable = [
        'nama_kategori'
    ];
    public function aspirasi():HasMany
    {
        return $this->hasMany(Aspirasi::class, 'category_id');
    }
}
