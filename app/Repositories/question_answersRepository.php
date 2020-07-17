<?php

namespace App\Repositories;

use App\Models\question_answers;
use App\Repositories\BaseRepository;

/**
 * Class question_answersRepository
 * @package App\Repositories
 * @version July 17, 2020, 7:30 pm PST
*/

class question_answersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'question_id',
        'answer'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return question_answers::class;
    }
}
