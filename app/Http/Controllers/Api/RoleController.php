<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Repository\RoleRepository;

class RoleController extends BaseController
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @OA\Get(
     *   path="/api/roles",
     *   tags={"Phân quyền"},
     *   summary="Danh sách vai trò",
     *   operationId="role_index",
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       example={"code":200,"data":{{"id":2,"name":"1_department_manager","display_name":"Quản lý chi nhánh","description":"","created_at":1604982690,"updated_at":1604982690},{"id":3,"name":"1_warehouse_manager","display_name":"Nhân viên kho","description":"","created_at":1604982691,"updated_at":1604982691},{"id":4,"name":"1_sale","display_name":"Nhân viên bán hàng","description":"","created_at":1604982691,"updated_at":1604982691}}}
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $roles = $this->roleRepository->all();
        return $this->responseJson(200, BaseResource::collection($roles));
    }

    /**
     * @OA\Get(
     *   path="/api/permissions",
     *   tags={"Phân quyền"},
     *   summary="Danh sách quyền hạn",
     *   operationId="role_list_permission",
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       example={"code":200,"data":{{"name":"Sản phẩm","description":"Có quyền: Xem sản phẩm, Tạo sản phẩm","items":{{"id":1,"name":"product_view","display_name":"Xem sản phẩm"},{"id":2,"name":"product_create","display_name":"Tạo sản phẩm"}}}}}
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function listPermission()
    {
        $permissionData = Permission::get(['id', 'name', 'display_name']);
        $permissionConfig = config('laratrust_seeder.permissions_map', []);
        $permissionArr = [];
        foreach ($permissionConfig as $key => $item) {
            foreach ($item['items'] as $name => $value) {
                $item['items'][] = $permissionData->where('name', $key.'_'.$name)->first();
                unset($item['items'][$name]);
            }
            $permissionArr[] = $item;
        }
        return $this->responseJson(200, $permissionArr);
    }

    /**
     * @OA\Post(
     *   path="/api/roles",
     *   tags={"Phân quyền"},
     *   summary="Tạo mới vai trò",
     *   operationId="role_store",
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"name": "admin","display_name":"string","description":"","permission_ids":{1,2}},
     *          @OA\Schema(
     *            required={"display_name"},
     *            @OA\Property(
     *              property="display_name",
     *              format="string",
     *            ),
     *            @OA\Property(
     *              property="description",
     *              format="string",
     *            ),
     *            @OA\Property(
     *              property="permission_ids",
     *              format="array",
     *              description="Mảng các permission ID"
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"name":"nhan_vien_xuat_hang","display_name":"Nhân viên xuất hàng","description":null,"updated_at":1604979156,"created_at":1604979156,"id":5}}
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
    public function store(Request $request)
    {
        $request->validate([
            "display_name" => "required|max:125",
            "description" => "max:255",
        ], [
            'display_name' => "Tên vai trò",
        ]);
        $role = $this->roleRepository->create($request->all());
        if($request->permission_ids && is_array($request->permission_ids)) {
            $role->permissions()->sync($request->permission_ids);
        }
        return $this->responseJson(200, new BaseResource($role));
    }

    /**
     * @OA\Get(
     *   path="/api/roles/{id}",
     *   tags={"Phân quyền"},
     *   summary="Xem thông tin vai trò",
     *   operationId="role_show",
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
     *       example={"code":200,"data":{"result":{{"id":1,"title":"string","code":"NCC1","description":null,"phone":null,"fax":null,"website":null,"email":"example@domain.com","tax_code":"Mã số thuế","address_label":"Nơi giao hàng","address_1":"Dia chi 1","address_2":null,"province_id":null,"district_id":null,"ward_id":null,"data":null,"is_active":1,"created_at":1604910110,"updated_at":1604910680}},"pagination":{"display":1,"total_records":1,"per_page":15,"current_page":1,"total_pages":1}}}
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $role = $this->roleRepository->find($id);
        $role->permissions = $role->permissions()->pluck('id');
        return $this->responseJson(200, new BaseResource($role));
    }

    /**
     * @OA\Put(
     *   path="/api/roles/{id}",
     *   tags={"Phân quyền"},
     *   summary="Cập nhật vai trò",
     *   operationId="role_update",
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
     *          example={"name":"string","display_name":"string","description":"","permission_ids":{1,2}},
     *          @OA\Schema(
     *            required={"display_name"},
     *            @OA\Property(
     *              property="display_name",
     *              format="string",
     *            ),
     *            @OA\Property(
     *              property="description",
     *              format="string",
     *            ),
     *            @OA\Property(
     *              property="permission_ids",
     *              format="array",
     *              description="Mảng các permission ID"
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Gửi yêu cầu thành công",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"name":"nhan_vien_xuat_hang","display_name":"Nhân viên xuất hàng","description":null,"updated_at":1604979156,"created_at":1604979156,"id":5}}
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
    public function update(Request $request, $id)
    {
        $request->validate([
            "display_name" => "required|max:125",
            "description" => "max:255",
        ], [
            'display_name' => "Tên vai trò",
        ]);
        $role = $this->roleRepository->update($request->all(), $id);
        if($request->permission_ids && is_array($request->permission_ids)) {
            $role->permissions()->sync($request->permission_ids);
        }
        return $this->responseJson(200, new BaseResource($role));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
