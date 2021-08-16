<?php
/**
 * Created by PhpStorm.
 * User: TanTan
 * Date: 11/26/2020
 * Time: 17:33
 */

namespace App\Services\Exceptions;


class ShippingException extends \Exception
{
    protected $code;

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param $message
     * @return ShippingException
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}