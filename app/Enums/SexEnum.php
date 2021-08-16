<?php
/**
 * Created by PhpStorm.
 * User: cuongn
 * Date: 11/23/2020
 */

namespace Enum;

/**
 * @OA\Schema(
 *     schema="Sex",
 *     title="Sex",
 *     description="Gới tính:
 *     - `1`: Nam
 *     - `2`: Nữ",
 *     type="int",
 *     enum={1,2},
 * )
 */
class SexEnum extends Enum
{
    const MALE  = [1, 'Nam'];
    const FEMALE = [2, 'Nữ'];
}
