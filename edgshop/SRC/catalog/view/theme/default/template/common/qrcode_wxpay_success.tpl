<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="cn" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="cn" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="cn">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>微信扫码支付</title>
<base href="http://edgteam.cn/" />
<meta property="wb:webmaster" content="1119a2bc45a7adcc" />
<meta property="qc:admins" content="236147231165474515636" />
<link rel="stylesheet" type="text/css" href="assets/default/css/bootstrap.min.css"/>
</head>
<body class="checkout-qrcode_wxpay_success">
      <h1 class="text-center"><?php echo $heading_title; ?></h1>
      <div class="text-center">
        <p>
          <img alt="微信扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($code_url); ?>" style="width:300px;height:300px;">
        </p>
        <h2>请打开您的手机微信，点击扫一扫，扫描如下二维码图片进行支付。</h2>
      </div>
    </div>
  </div>
</div>

    <script type="text/javascript">
        $(document).ready(function(){
            setInterval(queryOrderState, 3000);
        });

        function queryOrderState(){
            $.ajax({
                type: "GET",
                url: "https://cashier.jd.com/lazy/getState.action?orderId=18919214625&orderType=0&PassKey=C2193B89C8B07B8CA526E2D87D2C4154",
                data: "",
                dataType: "json",
                timeout: 4000,
                async:false,
                success: function(result) {

                    if(result.state==1){
                        //直接跳到成功页
                        window.location.href = "http://cashier.jd.com/payment/payResult.action?orderId=18919214625&amount=2999.00&companyId=10&OrderType=0&toType=10&code=100000&PassKey=D0D948E8ACBDD0B6D10CE8943CD8D944CD20389A635AFAFF404994C8D9C63699&installment=&repayDate=&bundCard=&cardId=";
                    }
                }
            });
        }
    </script>
<script>
    $(function(){
        // 二维码超时提醒
        paymentUI.setAuthCountdown('.j_qrCodeCountdown',45, function(){
            $('.j_weixinInfo').html('二维码已过期，<a href="javascript:window.location.reload();">刷新</a>页面重新获取二维码。').addClass('font-red');
        });
    });
</script>


