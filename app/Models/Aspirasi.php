<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Aspirasi extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $table=['aspirasi'];
    protected $fillable=[
    'title',
    'id_user',
    'deskripsi',
    'foto',
    'lokasi',
    'category_id',
    'status',
    'deleted_by'
    ];

    public function User():BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function Category():BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function Feedback():HasMany
    {
        return $this->HasMany(Feedback::class, 'aspirasi_id');
    }

    public function destroyer():BelongsTo{
        return$this->belongsTo(User::class, 'deleted_by');
    }
}
