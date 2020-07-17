<?php

namespace App\Repositories;

use App\Models\questions;
use App\Repositories\BaseRepository;

/**
 * Class questionsRepository
 * @package App\Repositories
 * @version July 17, 2020, 2:51 pm PST
*/

class questionsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'text',
        'description',
        'type'
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
        return questions::class;
    }
}
