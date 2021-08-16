<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Date: 6/28/2019
 * Time: 8:43 AM
 */

namespace Repository;

use App\Models\Role;
use App\Models\Supplier;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    public function model()
    {
        return Role::class;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return parent::create($attributes);
    }

}
