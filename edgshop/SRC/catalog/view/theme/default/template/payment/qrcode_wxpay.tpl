<?php echo $header; ?>
    
        <div id="detail-top" class="container-fluid">
                <div class="container" style="min-width: 1170px;">
                        <div class="row well">
                                <h5>微信支付</h5>
                                <div class="col-md-12">
                                        <div class="qrcode center-block">
                                            <img class="qrcode-img"  alt="微信扫码支付"  src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($code_url); ?>" />
                                                     <img class="wechat" src="<?php echo THEME_PATH; ?>/img/wechat.png"/>
                                                <img class="scanqr" src="<?php echo THEME_PATH; ?>/img/scanqr.png"/>
                                        </div>
                                        <p class="scan-info"><img src="<?php echo THEME_PATH; ?>/img/scan.png"/>请打开您的手机<span>微信</span>，点击<span>扫一扫</span>，扫描二维码图片进行支付</p>
                                </div>
                        </div>
                </div>
        </div>
    



    <script type="text/javascript">
        $(document).ready(function(){
            setInterval(queryOrderState, 3000);
            // $('title').text('微信扫码支付');
/*             setTimeout(function(){
             $('iframe').remove();
            }, 3000); */
        });
        var stateurl = "/payment/qrcode_wxpay/getstate?orderid=<?php echo $order_id; ?>&code=<?php echo $code; ?>";
        function queryOrderState(){
            $.ajax({
                type: "GET",
                url: stateurl,
                data: "",
                dataType: "json",
                timeout: 4000,
                async:false,
                success: function(result) {
                        if(result['redirect']){
                            //直接跳到成功页
                            window.location.href = result['redirect'];
                        }
                    }
                });
        }
    </script>
<?php echo $footer; ?>