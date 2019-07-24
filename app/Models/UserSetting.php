<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSetting
 *
 * @property int $id
 * @property int $user_id
 * @property float $initial_balance
 * @property string $created_at
 * @property string $updated_at
 *
 * @package App\Models
 */
class UserSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'language', 'initial_balance',
    ];
}
