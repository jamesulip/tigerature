<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class password_resets
 * @package App\Models
 * @version July 16, 2020, 3:40 am UTC
 *
 * @property string $email
 * @property string $token
 */
class password_resets extends Model
{
    //use SoftDeletes;

    public $table = 'password_resets';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'email',
        'token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required',
        'token' => 'required'
    ];


}
