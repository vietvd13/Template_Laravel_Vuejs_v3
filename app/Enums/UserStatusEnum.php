<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Date: 11/03/2020
 * Time: 10:54
 */

namespace Enum;

/**
 * @OA\Schema(
 *     title="UserStatus",
 *     description="Trạng thái người dùng:
 *     - `1`: Đang hoạt động
 *     - `2`: Đã khóa",
 *     type="int",
 *     enum={1,2},
 * )
 */
class UserStatusEnum extends Enum
{
    const ACTIVE = [1, 'Đang hoạt động'];
    const BLOCKED = [2, 'Đã khóa'];
}