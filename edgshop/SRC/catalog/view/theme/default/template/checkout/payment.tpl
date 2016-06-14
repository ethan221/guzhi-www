<?php echo $header; ?>
<div id="detail-top" class="container-fluid">
			<div class="container" style="min-width: 1170px;">
				<div class="row well">
					<div class="row bs-wizard" style="border-bottom:0;">
		                <div class="col-xs-4 bs-wizard-step complete">
		                  <div class="text-center bs-wizard-stepnum">1.我的购物车</div>
		                  <div class="progress"><div class="progress-bar"></div></div>
		                  <a href="javascript:;" class="bs-wizard-dot"></a>
		                </div>
		                
		                <div class="col-xs-4 bs-wizard-step complete"><!-- complete -->
		                  <div class="text-center bs-wizard-stepnum">2.填写核对订单信息</div>
		                  <div class="progress"><div class="progress-bar"></div></div>
		                  <a href="javascript:;" class="bs-wizard-dot"></a>
		                </div>
		                <div class="col-xs-4 bs-wizard-step active"><!-- active -->
		                  <div class="text-center bs-wizard-stepnum">3.成功提交订单</div>
		                  <div class="progress"><div class="progress-bar"></div></div>
		                  <a href="javascript:;" class="bs-wizard-dot"></a>
		                </div>
		            </div>
				</div>
				<div class="row well success-info-cont">
					<div class="col-md-2 col-sm-2 col-xs-2">
                                            <img class="center-block" src="<?php echo THEME_PATH; ?>img/right-icon.png" />
					</div>
					<div class="col-md-10 col-sm-10  col-xs-10" style="height: 260px;">
						<div class="col-md-12 col-sm-12  col-xs-12" style="height: 45%;border-bottom: 1px solid gainsboro;padding-left: 0;">
							<div class="col-md-6 col-sm-6 col-xs-6 paysments"  style="padding-left: 0">
								<h3 style="margin-top: 0;">订单提交成功，去付款喽~</h3>
								<p>成功付款后，7天发货</p>
								<p>请在 <span	>1小时59分</span> 内完成支付，超时将取消订单</p>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<p class="text-right">应付总额： <span class="payment ">¥<?php echo number_format($order_data['total'], 2); ?></span> 元</p>
								<div class="invo-info">订单详情&nbsp;<span class="glyphicon glyphicon-menu-down"></span></div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12  col-xs-12 paysments" style="height: 55%;padding-left: 0;padding-top: 20px;">
							<div class="col-md-12 col-sm-12  col-xs-12" style="padding-left: 0">
								<p>订 单 号  ： <span><?php echo $order_data['order_no']; ?></span></p>
								<p>收货信息：<?php echo $order_data['shipping_fullname']; ?> <?php echo $order_data['address']; ?></p>
								<p>商品名称：
                                                                                                                                                    <?php 
                                                                                                                                                    $count = count($order_data['order_product']);
                                                                                                                                                    foreach($order_data['order_product'] as $key => $product){   
                                                                                                                                                        echo $product['name'];  
                                                                                                                                                        if($key<$count-1){
                                                                                                                                                            echo '，';
                                                                                                                                                        }
                                                                                                                                                    } ?>
                                                                                                                                                </p>
								<p>配送时间：<?php echo date('Y-m-d'); ?></p>
								<p>发票信息：<?php echo $order_data['invoice'];  ?></p>
							</div>
							
						</div>
					</div>
				</div>
				<div class="row well">
					<h4 class="pay-ways">请选择一下支付方式付款</h4>
					<h4 class="pay-img">支付平台<small> （大额支付推荐使用支付宝） </small></h4>
                                                                                        <div class="payimgs" id="payment-list">
                                                                                                            <?php if($payment_methods){ ?>
                                                                                                            <?php foreach($payment_methods as $key=>$method){ ?>
                                                                                                            <label for="input-payment-<?php echo $key; ?>">
                                                                                                                <img src="<?php echo THEME_PATH; ?>img/<?php echo $key; ?>.png"/>
                                                                                                                <input id="input-payment-<?php echo $key; ?>" type="radio" style="display: none;" name="payment" value="<?php echo $method['code']; ?>">
                                                                                                            </label>
                                                                                                            <?php } ?>
                                                                                                            <?php } ?>
                                                                                                            <input name="orderid" type='hidden' value="<?php echo $order_data['order_id']; ?>" id="input-order-id" />
					</div>
				</div>
			</div>
		</div>
<div id="success-fail" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">正在支付</h4>
                  </div>
              <div class="modal-body" style="min-height: 160px;">
                      <div id="pay-solution" class="row">
                              <div class="col-md-5">
                                  <img src="<?php echo THEME_PATH; ?>img/paying_img.png" style='height: auto' />
                              </div>
                              <div class="col-md-6">
                                      <div class="col-md-12">
                                          <h3>支付成功了<br/><small><a style="color: red;" href="/account/order/info?orderid=<?php echo $order_data['order_id']; ?>">立即查看订单详情 ></a></small></h3>
                                      </div>
                                      <div class="col-md-12" style="border-top: 1px solid #BBBBBB;">
                                              <h3>如果支付失败<br/><small><a href="/press?press_id=7">查看支付常见问题 ></a></small></h3>
                                      </div>
                              </div>
                      </div>


              </div>
          </div>
        </div>
</div>
<?php echo $footer; ?> 
<script type="text/javascript"><!--
    var paywindow;
    $(document).ready(function() {
        $('#payment-list input[type="radio"]').click(function(){
                $('#payment-list .current').removeClass('current');
                $('#payment-list input[type="radio"]:checked').parent().addClass('current');
                order_pay($('#payment-list input[type="radio"]:checked').val());
        });
    });
    
    function order_pay(type){
            if(paywindow != null){
                try{
                    paywindow.close();
                }catch(e){ }
            }
            var orderid = $('#input-order-id').val();
            var iTop = (window.screen.availHeight-30-520)/2;       //获得窗口的垂直位置;
            var iLeft = (window.screen.availWidth-10-650)/2;           //获得窗口的水平位置;
            var url = "/payment/"+ type +"?orderid="+orderid;
            //location.href = "/payment/"+ type +"?orderid="+orderid;
            //paywindow = window.open("/payment/"+ type +"?orderid="+orderid, "paywindow","width=650,height=520,top="+iTop+",left="+iLeft+",channelmode=yes,resizable=yes,scrollbars=yes,status=no");
            window.open(url, '_blank');
            $('#success-fail').modal('show');
    }
    
    
    var et = "<?php echo $order_data['time_expire']; ?>";
    function MillisecondToDate(msd) {
		    var time = parseFloat(msd) / 1000;
		    console.log(time);
		    if (null != time && "" != time) {
		        if (time > 60 && time < 60 * 60) {
		            time = parseInt(time / 60.0) + "分" + parseInt((parseFloat(time / 60.0) -
		                parseInt(time / 60.0)) * 60) + "秒";
		        }
		        else if (time >= 60 * 60) {
		            time = parseInt(time / 3600.0) + "小时" + 
		            	parseInt((parseFloat(time / 3600.0) - parseInt(time / 3600.0)) * 60) + "分" +
		                parseInt((parseFloat((parseFloat(time / 3600.0) - parseInt(time / 3600.0)) * 60) -
		                parseInt((parseFloat(time / 3600.0) - parseInt(time / 3600.0)) * 60)) * 60) + "秒";
		        }
		        else {
		            time = parseInt(time) + "秒";
		        }
		    }
		    return time;
		}

		(function (et){
			var endTime = new Date(et).getTime();
			setInterval(function(){
				var nowTime = new Date().getTime();
				if(nowTime >= endTime){
                                                                                            $(".paysments>p").html("<font color='red'>您的订单已过期</font>");
                                                                                            location.href = '/checkout/cart';
				}else{
					var minus = endTime - nowTime;
					$(".paysments>p span").text(MillisecondToDate(minus));
				}
			},1000);
		})(et);

//-->
</script>