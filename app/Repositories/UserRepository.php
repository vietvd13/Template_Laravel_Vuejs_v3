<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Repository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    public function model()
    {
        return User::class;
    }

    public function getImageidbyUser($id){
        return User::with('images')->find($id);
//        return $this->syncWithoutDetaching($id, 'images', 'url');
    }
    public function getImagebyUser(){
        return User::with('images')->get();
//        return $this->syncWithoutDetaching($id, 'images', 'url');
    }
}
