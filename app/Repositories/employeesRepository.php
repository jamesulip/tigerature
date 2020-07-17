<?php

namespace App\Repositories;

use App\Models\employees;
use App\Repositories\BaseRepository;

/**
 * Class employeesRepository
 * @package App\Repositories
 * @version July 16, 2020, 3:40 am UTC
*/

class employeesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'first_name',
        'last_name',
        'address'
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
        return employees::class;
    }
}
