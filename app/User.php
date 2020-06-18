<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @OA\Schema(
 *   type="object",
 *   required={"id", "email", "api_token"},
 * )
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @OA\Property(type="integer", format="int64")
     */
    public $id;

    /**
     * @OA\Property(type="string")
     */
    private $api_token;
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
