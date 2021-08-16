<?php
namespace App\Repositories\Contracts;

use App\Http\Requests\LoginRequest;

interface AuthRepositoryInterface {

    /**
     *
     * Handle action login of user.
     *
     * @param LoginRequest $r
     * @param object
     * @return boolean
     */
    public function doLogin(LoginRequest $r, $guard = null);

    /**
     *
     * Handle action login of user.
     *
     * @param array $params
     * @param object
     * @return boolean
     */
    public function register(array $params);
}
