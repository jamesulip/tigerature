<?php

namespace App\Repositories;

use App\Models\log;
use App\Repositories\BaseRepository;

/**
 * Class logRepository
 * @package App\Repositories
 * @version July 16, 2020, 3:40 am UTC
*/

class logRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'temp',
        'user_id',
        'device_id'
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
        return log::class;
    }
}
