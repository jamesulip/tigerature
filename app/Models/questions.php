<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class questions
 * @package App\Models
 * @version July 17, 2020, 2:51 pm PST
 *
 * @property string $text
 * @property string $description
 * @property string $type
 */
class questions extends Model
{
    // use SoftDeletes;

    public $table = 'questions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'text',
        'description',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'text' => 'string',
        'description' => 'string',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'text' => 'required',
        'description' => 'required',
        'type' => 'required'
    ];


}
