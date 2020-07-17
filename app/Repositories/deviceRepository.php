<?php

namespace App\Repositories;

use App\Models\device;
use App\Repositories\BaseRepository;

/**
 * Class deviceRepository
 * @package App\Repositories
 * @version July 16, 2020, 3:40 am UTC
*/

class deviceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
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
        return device::class;
    }
}
