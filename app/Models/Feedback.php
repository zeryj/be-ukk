<?php

namespace App\Models;

use App\Models\Aspirasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Feedback extends Model
{
    use HasFactory, Notifiable;
    protected   $fillable = [
        'keterangan',
        'aspirasi_id',
        'author'
    ];
    public function user():BelongsTo{
        return $this->belongsTo(User::class,'author');

    }
    public function aspirasi():BelongsTo{
        return $this->belongsTo(Aspirasi::class,'aspirasi_id');
    }
}
