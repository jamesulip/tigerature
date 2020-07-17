<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class log
 * @package App\Models
 * @version July 16, 2020, 3:40 am UTC
 *
 * @property \App\Models\Device $device
 * @property \App\Models\Employee $user
 * @property number $temp
 * @property integer $user_id
 * @property integer $device_id
 */
class log extends Model
{
    //use SoftDeletes;

    public $table = 'log';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'temp',
        'user_id',
        'device_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'temp' => 'float',
        'user_id' => 'integer',
        'device_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'temp' => 'required',
        'user_id' => 'required',
        'device_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function device()
    {
        return $this->belongsTo(\App\Models\Device::class, 'device_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(employees::class, 'user_id');
    }
}
