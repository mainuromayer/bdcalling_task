<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    protected $table = 'user_types';
    use HasFactory;
}
