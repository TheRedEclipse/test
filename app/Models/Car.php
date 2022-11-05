<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Fillable Car model fields
     */
    protected $fillable = [
        'user_id',
        'name',
        'title'
    ];

    /**
     * Call automatically relationships
     */
    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function isNotTaken()
    {
        return $this->user_id === null;
    }

    public function isTaken()
    {
        return $this->user_id === null;
    }
}
