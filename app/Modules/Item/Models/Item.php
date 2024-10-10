<?php

namespace App\Modules\Item\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'status'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
