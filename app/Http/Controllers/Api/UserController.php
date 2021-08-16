<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends BaseController
{
    protected $repository;
    protected $userRepository;

    public function __construct(UserRepository $repository, UserRepositoryInterface $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Get(
     *   path="/api/user",
     *   tags={"User"},
     *   summary="List user",
     *   operationId="user_index",
     *   @OA\Response(
     *     response=200,
     *     description="response success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       example={"code":200,"data":{{"id":1,"email":"test@gmail.com","username":"test","name":"abc","created_at":1604982690,"updated_at":1604982690},{"id":2,"email":"test1@gmail.com","username":"test1","name":"abcd","created_at":1604982690,"updated_at":1604982690},"pagination":{"display":1,"total_records":1,"per_page":15,"current_page":1,"total_pages":1}}}
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *   ),
     *   @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Chưa đăng nhập"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Từ chối quyền truy cập",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Từ chối quyền truy cập"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function index(UserRequest $request){
//        $users = $this->repository->paginate($request->per_page);
//        return $this->responseJson(200, BaseResource::collection($users));
//    }

    public function index(UserRequest $request){
//        $user = User::find(auth()->user()->id)->with('images');
        $user = $this->userRepository->getImagebyUser($request->per_page);
        return $this->responseJson(200, $user);
    }


    /**
     * @OA\Get(
     *   path="/api/user/{id}",
     *   tags={"User"},
     *   summary="Xem thông tin user",
     *   operationId="user_show",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       example={"code":200,"data":{"result":{{"id":1,"email":"example@domain.com","username":"NCC1","phone":null,"created_at":1604910110,"updated_at":1604910680}}}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Not login"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Từ chối quyền truy cập",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Access deny permission"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
//    public function show($id){
//        $user = $this->repository->find($id);
//        return $this->responseJson(200, new BaseResource($user));
//    }
    public function show($id){
//        $user = User::find(auth()->user()->id)->with('images');
        $user = $this->userRepository->getImageidbyUser($id);
        return $this->responseJson(200, $user);
    }

    /**
     * @OA\Put(
     *   path="/api/user/{id}",
     *   tags={"User"},
     *   summary="Cập nhật user",
     *   operationId="user_update",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"username":"string","email":"string","phone":"string", "name": "string", "password": "string", "fax": "string", "address": "string", "gender": {1, 2}, "status": "int"},
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
     *            @OA\Property(
     *              property="gender",
     *              format="array",
     *              description="Mảng giới tính"
     *            ),
     *            @OA\Property(
     *              property="status",
     *              format="number",
     *              description="1: Đang hoạt động, 2: khóa"
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *       example={"code":200,"data":{"result":{{"id":1,"email":"example@domain.com","username":"NCC1","phone":null,"created_at":1604910110,"updated_at":1604910680}}}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Chưa đăng nhập"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Từ chối quyền truy cập",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Từ chối quyền truy cập"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request, $id){

        $user = $this->repository->update($request->all(), $id);
        return $this->responseJson(200, new BaseResource($user));
    }

    /**
     * @OA\Post(
     *   path="/api/user",
     *   tags={"User"},
     *   summary="Add new User",
     *   operationId="User_create",
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"username":"string","email":"string","phone":"string", "name": "string", "password": "string", "fax": "string", "address": "string", "gender": {1, 2}, "status": "int"},
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
     *            @OA\Property(
     *              property="gender",
     *              format="array",
     *              description="Mảng giới tính"
     *            ),
     *            @OA\Property(
     *              property="status",
     *              format="number",
     *              description="1: Đang hoạt động, 2: khóa"
     *            ),
     *         )
     *      )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"id": 1,"name": "......"}}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(UserRequest $request){
        $user =  $this->repository->create($request->all());
        return $this->responseJson(CODE_SUCCESS, new BaseResource($user));
    }

    /**
     * @OA\Delete(
     *   path="/api/user/{id}",
     *   tags={"User"},
     *   summary="Delete ..............",
     *   operationId="user_delete",
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Send request Success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":"Send request Success"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * */
    public function destroy($id){
        $this->repository->delete($id);
        return $this->responseJson(CODE_SUCCESS, null, trans('messages.mes.delete_success'));
    }
}
