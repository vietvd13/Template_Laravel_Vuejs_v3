<?php

namespace Repository;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository  implements AuthRepositoryInterface
{
    protected $shopRepository;

    public function __construct()
    {
    }

    /**
     *
     * Handle action login of user.
     *
     * @param LoginRequest $request
     * @param null $guard
     * @return array
     */
    public function doLogin(LoginRequest $request, $guard = null): array
    {
        $credentials = $request->only('password');
        if (Str::contains($request->user_name, "@")) {
            $credentials['email'] = $request->user_name;
        } else {
            $credentials['phone'] = $request->user_name;
        }

        $attempt = JWTAuth::attempt($credentials);
        if ($attempt) {
            $user = User::where('phone', $request->user_name)
                ->orWhere('email', $request->user_name)->firstOrFail();
            return [
                'user' => $user,
                'attempt' => $attempt
            ];
        }
        return [
            'attempt' => false
        ];
    }

    /**
     * @param array $params
     * @return bool|void
     */
    public function register(array $params)
    {
        $user = User::create($params);
        $this->grantRoleNewUser($user);

        return $user;
    }

    protected function grantRoleNewUser(User &$user)
    {
        $roleOwnerDefault = array_key_first(config('laratrust_seeder.roles_structure', []));
        $shopOwner = Role::where('name', $roleOwnerDefault)->first();
        $user->attachRole($shopOwner);
    }


    public function update(array $attributes, $id)
    {
        $user = User::find($id);
         if($user->update($attributes)){
             return $user;
         }
         return [];
    }
}
