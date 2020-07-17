<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class failed_jobs
 * @package App\Models
 * @version July 16, 2020, 3:40 am UTC
 *
 * @property string $connection
 * @property string $queue
 * @property string $payload
 * @property string $exception
 * @property string|\Carbon\Carbon $failed_at
 */
class failed_jobs extends Model
{
    //use SoftDeletes;

    public $table = 'failed_jobs';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'connection' => 'string',
        'queue' => 'string',
        'payload' => 'string',
        'exception' => 'string',
        'failed_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'connection' => 'required',
        'queue' => 'required',
        'payload' => 'required',
        'exception' => 'required',
        'failed_at' => 'required'
    ];


}
