<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TempoData
 * @package App
 *
 * @property string $tempo_token
 * @property string $jira_account_id
 * @property string $user_id
 */
class TempoData extends Model
{
    protected $table = 'tempo_data';

    protected $fillable = [
        'tempo_token', 'jira_account_id'
    ];
}
