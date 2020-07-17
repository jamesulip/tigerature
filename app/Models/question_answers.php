<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class question_answers
 * @package App\Models
 * @version July 17, 2020, 7:30 pm PST
 *
 * @property \App\Models\Employee $user
 * @property integer $user_id
 * @property string $question_id
 * @property string $answer
 */
class question_answers extends Model
{
    // use SoftDeletes;

    public $table = 'question_answers';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'question_id',
        'answer'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'question_id' => 'string',
        'answer' => 'json'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'question_id' => 'required',
        'answer' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'user_id');
    }
}
