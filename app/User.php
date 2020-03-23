<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class User
 * @property string id
 * @property string user_token
 * @property TempoData $tempoData
 * @package App
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'user_token', 'remember_token'
    ];

    /**
     * @param $value
     * @return $this
     */
    public function setApiToken($value): self
    {
        $this->user_token = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiToken(): string
    {
        return (string)$this->user_token;
    }

    /**
     * @return HasOne
     */
    public function tempoData(): HasOne
    {
        return $this->hasOne(TempoData::class);
    }
}
