<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'password',
    ];

    // public function changes()
    // {
    //     return $this->morphMany(Change::class, 'changeable');
    // }

    // public function makeChange($description, $dataKey, $linkedable)
    // {
    //     $change = $this->changes()->create([
    //         'change_description' => $description,
    //         'data_key' => $dataKey,
    //         'linkedable_id' => $linkedable->id,
    //         'linkedable_type' => get_class($linkedable),
    //     ]);

    //     return $change;
    // }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
