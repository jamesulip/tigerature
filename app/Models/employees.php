<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class employees
 * @package App\Models
 * @version July 16, 2020, 3:40 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $logs
 * @property integer $employee_id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 */
class employees extends Model
{
    //use SoftDeletes;

    public $table = 'employees';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'address'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'address' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'employee_id' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'address' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function logs()
    {
        return $this->hasMany(\App\Models\Log::class, 'user_id');
    }
}
