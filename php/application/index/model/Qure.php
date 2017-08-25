<?php
namespace app\index\model;
class Qure extends \think\Model
{
public function Queryorder($transaction_id)
    {vendor('wxpay.WxPay_JsApiPay');
        vendor('wxpay.WxPay_Config');
        vendor('wxpay.WxPay_Exception');
        vendor('wxpay.WxPay_Data');
        vendor('wxpay.WxPay_Api');
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }
}