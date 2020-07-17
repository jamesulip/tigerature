<?php

namespace App\Repositories;

use App\Models\password_resets;
use App\Repositories\BaseRepository;

/**
 * Class password_resetsRepository
 * @package App\Repositories
 * @version July 16, 2020, 3:40 am UTC
*/

class password_resetsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email',
        'token'
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
        return password_resets::class;
    }
}
