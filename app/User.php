<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class User
 * @property string id
 * @property string email
 * @property string password
 * @property string user_token
 * @property string first_name
 * @property string last_name
 * @property TempoData tempoData
 * @property mixed reports
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
     * @return HasOne
     */
    public function tempoData(): HasOne
    {
        return $this->hasOne(TempoData::class);
    }

    /**
     * @return HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(UserReport::class);
    }

    /**
     * @return HasMany
     */
    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'owner_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function participateTeams(): BelongsToMany
    {
        return $this->belongsToMany(
            Team::class,
            'teams_users',
            'user_id',
            'team_id'
        );
    }
}
