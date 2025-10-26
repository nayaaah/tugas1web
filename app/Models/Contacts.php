<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
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
