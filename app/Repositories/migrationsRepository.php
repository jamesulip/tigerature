<?php

namespace App\Repositories;

use App\Models\migrations;
use App\Repositories\BaseRepository;

/**
 * Class migrationsRepository
 * @package App\Repositories
 * @version July 16, 2020, 3:40 am UTC
*/

class migrationsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'migration',
        'batch'
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
        return migrations::class;
    }
}
