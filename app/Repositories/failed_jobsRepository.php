<?php

namespace App\Repositories;

use App\Models\failed_jobs;
use App\Repositories\BaseRepository;

/**
 * Class failed_jobsRepository
 * @package App\Repositories
 * @version July 16, 2020, 3:40 am UTC
*/

class failed_jobsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at'
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
        return failed_jobs::class;
    }
}
