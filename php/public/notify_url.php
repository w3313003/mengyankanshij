<?php
require_once("config.php");
require_once '../vendor/alippy/wappay/service/AlipayTradeService.php';


$arr=$_POST;
$alipaySevice = new AlipayTradeService($config); 
$alipaySevice->writeLog(var_export($_POST,true));
$result = $alipaySevice->check($arr);

if($result) {

	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号

	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];


    if($_POST['trade_status'] == 'TRADE_FINISHED') {
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
    }

        
	echo "success";		//请不要修改或删除
		
}else {
    //验证失败
    echo "fail";
    Header("Location:index");//请不要修改或删除

}

?>

