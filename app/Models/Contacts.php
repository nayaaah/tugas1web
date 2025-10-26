<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacts extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'address',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
