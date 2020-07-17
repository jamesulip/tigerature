<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class migrations
 * @package App\Models
 * @version July 16, 2020, 3:40 am UTC
 *
 * @property string $migration
 * @property integer $batch
 */
class migrations extends Model
{
    //use SoftDeletes;

    public $table = 'migrations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'migration',
        'batch'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'migration' => 'string',
        'batch' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'migration' => 'required',
        'batch' => 'required'
    ];


}
