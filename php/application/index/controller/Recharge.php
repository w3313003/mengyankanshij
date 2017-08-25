<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\Qure;
class Recharge extends Controller
{
    //在线购买
    public function pay()
    { 
        vendor('wxpay.WxPay_JsApiPay');
        vendor('wxpay.WxPay_Config');
        vendor('wxpay.WxPay_Exception');
        vendor('wxpay.WxPay_Data');
        vendor('wxpay.WxPay_Api');
           if (request()->isPost()) {
                $arr=input('post.');
               if(!is_array($arr['id'])){
                $collec = db('user')->field('purchase')->where('id', getSessionCookie('memberinf.id'))->find();
                $collecarr = explode(",", $collec["purchase"]);
                if (in_array(input("post.id"), $collecarr)) {
                    return '您已经购买过了';

                }
               setSessionCookie('videoname',input('post.videoname'));
                 setSessionCookie('videoid',input('post.id'));
                   setSessionCookie('videoprice',input('post.videoprice'));
                   
               }else{
                   $collec = db('user')->field('purchase')->where('id', getSessionCookie('memberinf.id'))->find();
                $collecarr = explode(",", $collec["purchase"]);
               $flg=true;
                foreach($arr['id'] as $v){
                if (!in_array($v, $collecarr)) {
                    $flg=false;
                     }
                }
              if($flg){
                return '您已经购买过了';
                    }
                 setSessionCookie('videoname',input('post.videoname'));
                 setSessionCookie('videoid',$arr['id']);
                   setSessionCookie('videoprice',input('post.videoprice'));
               }
               
             $tools = new \JsApiPay();
            $openId = $tools->GetOpenid();
			return $openId;
		}
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("萌眼看世界视频购买");
        $input->SetAttach("萌眼看世界视频购买");
        $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee(getSessionCookie('videoprice')*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("萌眼看世界视频购买");
        $input->SetNotify_url("http://www.test.com/php/public/index.php/index/recharge/notify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        $editAddress = $tools->GetEditAddressParameters();
        $orderarr=[
            'videoid'=>getSessionCookie('videoid'),
            'phone'=>getSessionCookie('memberinf.phone'),
            'videoname'=>getSessionCookie('videoname'),
            'videoprice'=>getSessionCookie('videoprice'),
            'ordersum'=>$input->GetOut_trade_no(),
            'status'=>0
        ];
        setSessionCookie('ordersum',$orderarr['ordersum']);
        db('apply')->insert($orderarr);
         $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign('editAddress',$editAddress);
        return $this->fetch('pay');

    }
    public function notify()
    {
        $notify_data = file_get_contents("php://input");
        if(!$notify_data){
            exit('123');
        }else{
            $arr=[
                'status'=>1
            ];
                $update=db('apply')->where('ordersum',getSessionCookie('ordersum'))->update($arr);
                $videoid=getSessionCookie('videoid');
         if(!is_array($videoid)){
                $collec = db('user')->field('purchase')->where('phone', getSessionCookie('memberinf.phone'))->find();
                $collecarr = explode(",", $collec["purchase"]);
                    $collecarr[] = $videoid;
                    $newcollec= ltrim(implode(',', $collecarr),',');
                    $idarr = [
                        'purchase' => $newcollec,

                    ]; 
                $idupdate=db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($idarr);
         }else{
            $collec = db('user')->field('purchase')->where('phone', getSessionCookie('memberinf.phone'))->find();
            if($collec['purchase']){
                    $collecarr = explode(",", $collec["purchase"]);
                    $collecarr= array_merge($collecarr,$arr['id']);
                    $newcollec= ltrim(implode(',', $collecarr),',');
                    $idarr = [
                        'purchase' => $newcollec,

                    ]; 
                    $idupdate=db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($idarr);
            if ($update && $idupdate){
               $cont=db('apply')->where(['phone'=>getSessionCookie('memberinf.phone'),'status'=>1])->count();
                   $findarr=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
                   $fanli=db('rebate')->where('id',1)->find();
                   
                   $vprice=db('apply')->where('ordersum',getSessionCookie('ordersum'))->find();
                      $fkarr1=$findarr['rebate']+getSessionCookie('videoprice')*$fanli['first']/100;
                   $rebatearr=[
                      'rebate'=>round($fkarr1,2)
                   ];
                   $fl=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($rebatearr);
                   $upfindarr=db('user')->where('mycode',$findarr['yourscode'])->find();
                   if ($upfindarr){
                   $fkarr2=$upfindarr['rebate']+getSessionCookie('videoprice')*$fanli['second']/100;
                       $uprebatearr=[
                           'rebate'=>round($fkarr2,2)
                       ];
                       db('user')->where('mycode',$findarr['yourscode'])->update($uprebatearr);
                
                       return '购买成功';
                   }else{
                       return '购买成功';
                   }
           }else{
               return '网络错误';
           }
        }else{
                    $collecarr = explode(",", $collec["purchase"]);
                    $collecarr= array_merge($collecarr,$arr['id']);
                    $newcollec= ltrim(implode(',', $collecarr),',');
                    $idarr = [
                        'purchase' => $newcollec,

                    ]; 
                    $idupdate=db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($idarr);
                   $findarr=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
                   $upfindarr=db('user')->where('mycode',$findarr['yourscode'])->find();
                   if ($upfindarr){
                       $fkarr3=$upfindarr['rebate']+getSessionCookie('videoprice')*$findarr['second']/100;
                       $uprebatearr=[
                           'rebate'=>round($fkarr3,2)
                       ];
                       db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($uprebatearr);
                       return '购买成功';
                   }else{
                       return '购买成功';
                   }
               }
               
             }
         }
    }

    //个人账户充值
    public function recharge(){
        vendor('wxpay.WxPay_JsApiPay');
        vendor('wxpay.WxPay_Config');
        vendor('wxpay.WxPay_Exception');
        vendor('wxpay.WxPay_Data');
        vendor('wxpay.WxPay_Api');
           if (request()->isPost()) {
               setSessionCookie('picesum',input('post.picesum'));
           $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();
			return $openId;
		}
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("萌眼看世界充值账户");
        $input->SetAttach("萌眼看世界充值账户");
        $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee(getSessionCookie('picesum')*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("萌眼看世界充值账户");
        $input->SetNotify_url("http://www.renjing.xin/php/public/index.php/index/recharge/fnotify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        $editAddress = $tools->GetEditAddressParameters();
        $orderarr=[
            'picesum'=>getSessionCookie('picesum'),
            'phone'=>getSessionCookie('memberinf.phone'),
            'ordernum'=>$input->GetOut_trade_no(),
            'status'=>0
        ];
        setSessionCookie('ordernum',$orderarr['ordernum']);
        db('recharge')->insert($orderarr);
         $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign('editAddress',$editAddress);
        return $this->fetch('pay');
    }
    

    //重写回调处理函数
    public function fnotify()
    {
        $notify_data = file_get_contents("php://input");
        if(!$notify_data){
            exit('123');
        }else{
            $rarr=[
                'status'=>1
            ];
            $update=db('recharge')->where('ordernum',getSessionCookie('ordernum'))->update($rarr);
            if ($update){
                $find=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
                $vprice=db('recharge')->where('ordernum',getSessionCookie('ordernum'))->find();
                $fanli1=db('free')->where('id',1)->find();
                $fanli2=db('free')->where('id',2)->find();
                $fanli3=db('free')->where('id',3)->find();
                if ($vprice['$videoprice']>=$fanli1['base'] && $vprice['videoprice']<$fanli2['base']){
                    $find['givefree']=$find['givefree']+$fanli1['givefree'];
                    $rebatearr=[
                        'picesum'=>$vprice['$videoprice'],
                        'givefree'=>$find['givefree']
                    ];
                    
                    if(db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($rebatearr)){
                        return '充值成功';
                    }
                   
                }
                if ($vprice['$videoprice']>=$fanli2['base'] && $vprice['videoprice']<$fanli3['base']){
                    $find['givefree']=$find['givefree']+$fanli2['givefree'];
                    $rebatearr=[
                        'picesum'=>$vprice['$videoprice'],
                        'givefree'=>$find['givefree']
                    ];
                         
                    if(db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($rebatearr)){
                        return '充值成功';
                    }
                }
                if ($vprice['$videoprice']>=$fanli3['base']){
                    $find['givefree']=$find['givefree']+$fanli3['givefree'];
                    $rebatearr=[
                        'picesum'=>$vprice['$videoprice'],
                        'givefree'=>$find['givefree']
                    ];
                         
                    if(db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($rebatearr)){
                        return '充值成功';
                    }
                }
                if ($vprice['$videoprice']<$fanli1['base']){
                   
                    $rebatearr=[
                        'picesum'=>$vprice['$videoprice']
                    ];
                         
                    if(db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($rebatearr)){
                        return '充值成功';
                    }
                }
            }
        }
    }
    //个人会员账户购买
    public function mypay(){
        if (request()->isPost()){
            $arr=input('post.');
            if(!is_array($arr['id'])){
            $collec = db('user')->field('purchase')->where('phone', getSessionCookie('memberinf.phone'))->find();
            $collecarr = explode(",", $collec["purchase"]);
            
            if (in_array(input("post.id"), $collecarr)) {
                return '您已经购买过了';
               
             }else {
                $pricearr=db('user')->where('phone', getSessionCookie('memberinf.phone'))->find();
                if($pricearr['picesum'] >=trim(input("post.videoprice"))){
                    $pricearrs=$pricearr['picesum']-input("post.videoprice");
                        $smearr=[
                            'picesum'=>round($pricearrs,2)
                        ];
                        $yuprice1=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($smearr);
                        if (!$yuprice1){
                            return '购买失败1';
                        }
                }elseif(($pricearr['rebate']+$pricearr['picesum']) >= trim(input("post.videoprice"))){
                     $rebates=$pricearr['rebate']+$pricearr['picesum']-input("post.videoprice");
                        $mearr=[
                            'picesum'=>0,
                            'rebate'=>round($rebates,2)
                        ];
                        $yuprice2=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($mearr);
                        if (!$yuprice2){
                            return '购买失败2';
                        }
                }elseif(($pricearr['rebate']+$pricearr['picesum']+$pricearr['givefree']) >= input("post.videoprice")){
                    $givefrees=$pricearr['givefree']+$pricearr['rebate']+$pricearr['picesum']-input("post.videoprice");
                        $newmearr=[
                            'picesum'=>0,
                            'rebate'=>0,
                            'givefree'=>round($givefrees,2)
                        ];
                         $yuprice3=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($newmearr);
                         if (!$yuprice3){
                             return '购买失败3';
                         }
                }else{
                     return '账户余额不足';
                }
             $videoid=input("post.id");
             $collec = db('user')->field('purchase')->where('phone', getSessionCookie('memberinf.phone'))->find();
             if($collec['purchase']){
                     $collecarr = explode(",", $collec["purchase"]);
                    $collecarr[] = $videoid;
                    $newcollec= ltrim(implode(',', $collecarr),',');
                    $idarr = [
                        'purchase' => $newcollec,
                    ]; 
            $idupdate=db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($idarr);

           if ($idupdate){
               $cont=db('user')->field('purchase')->where('phone', getSessionCookie('memberinf.phone'))->find();
                   $findarr=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
                   $fanli=db('rebate')->where('id',1)->find();
                   $rebatearr=[
                      'rebate'=>$findarr['rebate']+input("post.videoprice")*$fanli['first']/100,
                   ];
                   $fl=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($rebatearr);
                
                   $upfindarr=db('user')->where('mycode',$findarr['yourscode'])->find();
                   if ($upfindarr){
                    
                       $uprebatearr=[
                           'rebate'=>$upfindarr['rebate']+input("post.videoprice")*$fanli['second']/100,
                       ];
                       db('user')->where('mycode',$findarr['yourscode'])->update($uprebatearr);
                
                       return '购买成功';
                   }else{
                       return '购买成功';
                   }
               
           }else{
               return '网络错误';
                    }
             }else{
                 $collecarr = explode(",", $collec["purchase"]);
                    $collecarr[] = $videoid;
                    $newcollec= ltrim(implode(',', $collecarr),',');
                    $idarr = [
                        'purchase' => $newcollec,
                    ]; 
                    $idupdate=db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($idarr);

                   $findarr=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
                   $upfindarr=db('user')->where('mycode',$findarr['yourscode'])->find();
                  
                   if ($upfindarr){
                       $uprebatearr=[
                           'rebate'=>$upfindarr['rebate']+input("post.videoprice")*$findarr['second']/100,
                       ];
                       db('user')->where('mycode',$findarr['yourscode'])->update($uprebatearr);
                       return '购买成功';
                   }else{
                       return '购买成功';
                   }
               }
            
            
                 }
     }else{
            $collec = db('user')->field('purchase')->where('id', getSessionCookie('memberinf.id'))->find();
            $collecarr = explode(",", $collec["purchase"]);
            $flg=true;
            foreach($arr['id'] as $v){
                if (!in_array($v, $collecarr)) {
                     $flg=false;
                     }
                }
              if($flg){
                return '您已经购买过了';
              }else{
                     $pricearr=db('user')->where('phone', getSessionCookie('memberinf.phone'))->find();
                if($pricearr['picesum'] >=trim(input("post.videoprice"))){
                    $pricearrs=$pricearr['picesum']-input("post.videoprice");
                        $smearr=[
                            'picesum'=>round($pricearrs,2)
                        ];
                        $yuprice1=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($smearr);
                        if (!$yuprice1){
                            return '购买失败1';
                        }
                }elseif(($pricearr['rebate']+$pricearr['picesum']) >= trim(input("post.videoprice"))){
                     $rebates=$pricearr['rebate']+$pricearr['picesum']-input("post.videoprice");
                        $mearr=[
                            'picesum'=>0,
                            'rebate'=>round($rebates,2)
                        ];
                        $yuprice2=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($mearr);
                        if (!$yuprice2){
                            return '购买失败2';
                        }
                }elseif(($pricearr['rebate']+$pricearr['picesum']+$pricearr['givefree']) >= input("post.videoprice")){
                    $givefrees=$pricearr['givefree']+$pricearr['rebate']+$pricearr['picesum']-input("post.videoprice");
                        $newmearr=[
                            'picesum'=>0,
                            'rebate'=>0,
                            'givefree'=>round($givefrees,2)
                        ];
                         $yuprice3=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($newmearr);
                         if (!$yuprice3){
                             return '购买失败3';
                         }
                }else{
                     return '账户余额不足';
                }
                $collec = db('user')->field('purchase')->where('phone', getSessionCookie('memberinf.phone'))->find();
                if($collec['purchase']){
                     $collecarr = explode(",", $collec["purchase"]);
                    $collecarr= array_merge($collecarr,$arr['id']);
                    $newcollec= ltrim(implode(',', $collecarr),',');
                    $idarr = [
                        'purchase' => $newcollec,

                    ]; 
            $idupdate=db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($idarr);
             if ($idupdate){
               $cont=db('user')->field('purchase')->where('phone', getSessionCookie('memberinf.phone'))->find();
                   $findarr=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
                   $fanli=db('rebate')->where('id',1)->find();
                   $ress=$findarr['rebate']+(input("post.videoprice")*$fanli['first']/100);
                   $rebatearr=[
                      'rebate'=>round($ress,2),
                   ];
                   $fl=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($rebatearr);
                
                   $upfindarr=db('user')->where('mycode',$findarr['yourscode'])->find();
                   if ($upfindarr){
                    $ssrebate=$upfindarr['rebate']+input("post.videoprice")*$fanli['second']/100;
                       $uprebatearr=[
                           'rebate'=>round($ssrebate,2)
                       ];
                       db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($uprebatearr);
                
                       return '购买成功';
                   }else{
                       return '购买成功';
                   }
           }else{
               return '网络错误';
             }
                }else{
                        $collecarr = explode(",", $collec["purchase"]);
                    $collecarr= array_merge($collecarr,$arr['id']);
                    $newcollec= ltrim(implode(',', $collecarr),',');
                    $idarr = [
                        'purchase' => $newcollec,

                    ]; 
            $idupdate=db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($idarr);
                   $findarr=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
                   $upfindarr=db('user')->where('mycode',$findarr['yourscode'])->find();
                  
                   if ($upfindarr){
                       $uprebatearr=[
                           'rebate'=>$upfindarr['rebate']+input("post.videoprice")*$findarr['second']/100,
                       ];
                       db('user')->where('mycode',$findarr['yourscode'])->update($uprebatearr);
                       return '购买成功';
                   }else{
                       return '购买成功';
                   }
               }
             
           }
       }
     }
   }


}
