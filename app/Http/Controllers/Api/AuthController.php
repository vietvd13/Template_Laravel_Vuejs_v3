<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RemindRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Mail\RemindPasswordEmail;
use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Repository\AuthRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    protected $authRepository;
    protected $userRepository;

    public function __construct(AuthRepositoryInterface $authRepository, UserRepositoryInterface $userRepository)
    {
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Post(
     *   path="/api/auth/login",
     *   tags={"Auth"},
     *   summary="User Login",
     *   operationId="user_login",
     *   @OA\Parameter(
     *     name="user_name",
     *     in="query",
     *     description="Số điện thoại hoặc Email",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="password",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"Bearer ...","profile":{"id":1,"full_name":null,"email":"example@gmail.com","phone":null,"company":null,"address":null,"created_at":1570031021}}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Đăng nhập thất bại",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Sai tài khoản hoặc mật khẩu"}
     *     )
     *   ),
     *   security={},
     * )
     * Display a listing of the resource.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $loginResult = $this->authRepository->doLogin($request);
        if ($loginResult['attempt']) {
            $user = $loginResult['user'];
            return $this->responseJson(Response::HTTP_OK, [
                'access_token' => "Bearer " . $loginResult['attempt'],
                'profile' => new UserResource($user)
            ]);
        }
        return $this->responseJsonError(Response::HTTP_UNAUTHORIZED, "Sai tài khoản hoặc mật khẩu");
    }

    /**
     * @OA\Post(
     *   path="/api/auth/register",
     *   tags={"Auth"},
     *   summary="User register",
     *   operationId="user_register",
     *   @OA\Parameter(
     *     name="name",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="phone",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="email",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="password",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="password_confirmation",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"","profile":{"id":1,"name":null,"email":"example@gmail.com","phone":null,"address":null,"created_at":1570031021}}}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            /* @see AuthRepository::register() */
            $user = $this->authRepository->register($request->all());

            $token = JWTAuth::fromUser($user);
            DB::commit();
            return $this->responseJson(200, [
                'access_token' => "Bearer " . $token,
                'profile' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @OA\Post(
     *   path="/api/auth/remind-password",
     *   tags={"Auth"},
     *   summary="Remind password",
     *   operationId="user_remind",
     *   @OA\Parameter(
     *     name="email",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":"Gửi yêu cầu thành công"}
     *     )
     *   ),
     *   security={},
     * )
     * @param RemindRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function remindPassword(RemindRequest $request) {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $randPass = Str::random(8);
            $user->update([
                'password' => $randPass
            ]);
            $detail = [
                'email' => $user->email,
                'password' => $randPass,
            ];
            Mail::to($user->email, $user->name)->send(new RemindPasswordEmail($detail));
            return $this->responseJson(200, null, "Gửi yêu cầu thành công.");
        } catch (\Exception $e) {
            return $this->responseJsonError(403, trans('errors.'), null, $e->getTrace());
        }

    }

    /**
     * @OA\Post(
     *   path="/api/auth/refresh",
     *   tags={"Auth"},
     *   summary="User register",
     *   operationId="user_reset_token",
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"...."}}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function refresh()
    {
        return $this->responseJson(200, ['access_token' => auth()->refresh()]);
    }

    /**
     * @OA\Get(
     *   path="/api/profile",
     *   tags={"Auth"},
     *   summary="Get Profile",
     *   operationId="user_profile",
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1, "name":"abc","email":"abc@gmail.com","phone":"0988737723","address":"Dia chi"}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Đăng nhập thất bại",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Sai tài khoản hoặc mật khẩu"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function getProfile(){
//        return $this->responseJson(200, auth()->user());
//    }
    public function getProfile(){
//        $user = User::find(auth()->user()->id)->with('images');
        $user = $this->userRepository->getImageidbyUser(auth()->user()->id);
        return $this->responseJson(200, $user);
    }


    /**
     * @OA\Put(
     *   path="/api/profile",
     *   tags={"Auth"},
     *   summary="Update Profile",
     *   operationId="update_user_profile",
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"username":"string","email":"string","phone":"string", "name": "string", "password": "string", "fax": "string", "address": "string"},
     *          @OA\Schema(
     *            required={"username"},
     *            @OA\Property(
     *              property="username",
     *              format="string",
     *            ),
     *            @OA\Property(
     *              property="email",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="name",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="phone",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="password",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="fax",
     *              format="string",
     *            ),
     *           @OA\Property(
     *              property="address",
     *              format="string",
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"name":  "............."}}
     *     ),
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Từ chối quyền truy cập",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Từ chối quyền truy cập"}
     *     ),
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request){
        $data = $this->authRepository->update($request->all(), Auth::id());
        return $this->responseJson(200, new BaseResource($data));
    }
}

