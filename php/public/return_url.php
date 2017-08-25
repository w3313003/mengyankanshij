<?php
require_once("config.php");
require_once '../vendor/alippy/wappay/service/AlipayTradeService.php';


$arr=$_GET;
$alipaySevice = new AlipayTradeService($config); 
$result = $alipaySevice->check($arr);

if($result) {//验证成功

	//商户订单号

	$out_trade_no = htmlspecialchars($_GET['out_trade_no']);

	//支付宝交易号

	$trade_no = htmlspecialchars($_GET['trade_no']);
    $conn = new mysqli("localhost","root","123456","jiniu");
    if (!$conn)
    {
        die('Could not connect: ' . mysqli_error());
    }

    $conn -> select_db("jiniu");
    $result=$conn -> query("UPDATE apply SET status =1
WHERE orderid =$out_trade_no");
    mysqli_close($conn);
    echo "验证成功<br />外部订单号：".$out_trade_no;




}
else {
    //验证失败
    echo "验证失败";
}
?>
<title>即牛网校</title>
	</head>
    <body>
    </body>
</html>