<?php echo $header; ?>
<script src="<?php echo THEME_PATH; ?>js/jquery/jquery.validate.min.js"></script>
<script src="<?php echo THEME_PATH; ?>js/ValidateExtend.js"></script>
<div id="detail-top" class="container-fluid">
                    <div class="container" style="min-width: 1170px;">
                            <div class="row well">
                                    <div class="row bs-wizard" style="border-bottom:0;">
                            <div class="col-xs-4 bs-wizard-step complete">
                              <div class="text-center bs-wizard-stepnum">1.我的购物车</div>
                              <div class="progress"><div class="progress-bar"></div></div>
                              <a href="#" class="bs-wizard-dot"></a>
                            </div>

                            <div class="col-xs-4 bs-wizard-step active"><!-- complete -->
                              <div class="text-center bs-wizard-stepnum">2.填写核对订单信息</div>
                              <div class="progress"><div class="progress-bar"></div></div>
                              <a href="#" class="bs-wizard-dot"></a>
                            </div>
                            <div class="col-xs-4 bs-wizard-step disabled"><!-- active -->
                              <div class="text-center bs-wizard-stepnum">3.成功提交订单</div>
                              <div class="progress"><div class="progress-bar"></div></div>
                              <a href="#" class="bs-wizard-dot"></a>
                            </div>
                        </div>
                        </div>
                        <div id="checkout-frm">
                        <div class="row well receipts">
                                <h3>收货人信息&nbsp;&nbsp;<small>(请填写并核对您的订单信息)</small></h3>
                                <div id="receipt-info" class="receipt-info">
                                        <table border="0" class="table">
                                                <tbody>
                                                       
                                                </tbody>
                                        </table>
                                        <div class="more-add">更多地址&nbsp;<span class="glyphicon glyphicon-menu-down"></span></div>
                                </div>
                                <button id="add-address" class="pull-right btn btn-red" style="margin-top: 15px;">添加收货地址</button>
                        </div>
                        <div id="cart-content" class="row settle">
                                <table class="table table-hover"  id="cart-content-tb">
                              <thead>
                                <tr>
                                  <th width="30px"></th>
                                  <th width="110px" style="text-align: left;"></th>
                                  <th width="328px">商品</th>
                                  <th>规格</th>
                                  <th>单价(元)</th>
                                  <th width="136px">数量</th>
                                  <th>小计(元)</th>
                                  <th>操作</th>
                                </tr>
                              </thead>
                              <tbody>
                                  
                                  <?php foreach ($products as $product) { ?>
                                                      <tr id="cart-product-tr-<?php echo $product['cart_id'];?>">
                                                          <th scope="row">
                                                              <input type="hidden" name="cartid[<?php echo $product['cart_id'];?>]" value="<?php echo $product['cart_id'];?>" />
                                                              <input type="hidden" class="input_hidden_pid" value="<?php echo $product['product_id'];?>" />
                                                          </th>
                                                        <td><?php if ($product['thumb']) { ?>
                                                                              <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                                                                              <?php } ?></td>
                                                                            <td style="vertical-align: top;">
                                                              <p><a href="<?php echo $product['href']; ?>" style="color:#000000;"><?php echo $product['name']; ?></a>
                                                                                      <?php if ($product['reward']) { ?>
                                                                                          <br />
                                                                                          <small><?php echo $product['reward']; ?></small>
                                                                                      <?php } ?>
                                                                                      <?php if ($product['recurring']) { ?>
                                                                                      <br />
                                                                                      <span class="label label-info"><?php echo $text_recurring_item; ?></span><small><?php echo $product['recurring']; ?></small>
                                                                                      <?php } ?>
                                                                                    </p>
                                                                           </td>
                                                        <td class="text-center">
                                                                                              <?php if (!$product['stock']) { ?>
                                                                                               <span class="text-danger">***</span>
                                                                                              <?php } ?>
                                                                                              <?php if ($product['option']) { ?>
                                                                                                  <?php foreach ($product['option'] as $option) { ?>
                                                                                                  <?php echo $option['name']; ?> : <?php echo isset($option['option_value_text'])?$option['option_value_text']:$option['value']; ?><br />
                                                                                                  <?php } ?>
                                                                                              <?php } ?>



                                                        </td>
                                                        <td class="text-center"><?php echo $product['price']; ?></td>
                                                        <td>
                                                              <div class="input-group input-group-sm">
                                                                                <span class="input-group-addon" act="minus"><span class="glyphicon glyphicon-minus"></span></span>
                                                                                <input type="text" class="form-control text-center" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" onkeyup="if(/\D/.test(this.value)){this.value=this.value.substring(0,this.value.length-1);}" />
                                                                                <span class="input-group-addon" act="plus"><span class="glyphicon glyphicon-plus"></span></span>
                                                                      </div>
                                                        </td>
                                                        <td class="text-center" class="count-number"><?php echo $product['total']; ?></td>
                                                        <td class="text-center">
                                                            <button type="button" <?php if(count($products)==1){?>disabled="disabled"<?php } ?> data-toggle="tooltip" _cid="<?php echo $product['cart_id']; ?>" data-loading-text='正在删除' class="btn btn-default del-cart-btn">删除</button>
                                                        </td>
                                                      </tr>
                                                       <?php } ?>
                              </tbody>
                            </table>
                        </div>
                                                                                
                       <div id='shipping-content' class="row well invoice">

                        </div>
                                                                                
                        <div class="row well invoice">
                                <h4>发票信息</h4>
                                <h4>发票抬头<input type="text" name="invoice" maxlength="128" class="form-control invoice-info" placeholder="请输入抬头信息"/><br />
                                        <small class="inspec">*发票内容与您的消费记录一直</small>
                                </h4>
                        </div>
                                                                                
                        <div class="row well favorable">
                                <h4>可用优惠券</h4>
                                <?php if($coupon_data){ ?>
                                <?php foreach($coupon_data as $coupon){ ?>
                                <div class="radio">
                                  <label>
                                      <input type="radio" name="cc_couponid[]"  value="<?php echo $coupon['customer_coupon_id']; ?>" _discount="<?php echo $coupon['coupon_data']['discount']; ?>"  _pids='<?php echo json_encode($coupon["product_data"]); ?>'>
                                    <?php echo $coupon['coupon_data']['name']; ?>
                                  </label>
                                </div>
                                <?php } ?>
                                <?php }else{ ?>
                                <p>没有可使用的优惠券</p>
                                <?php } ?>
                        </div>
                                                                                
                        <div id="checkout-total-content" class="well row">
                            <p class="text-right"><span id='ctc-goods-count'>2</span>件商品，合计金额为：<span id='ctc-goods-total'>¥-</span>元</p>
                            <p class="text-right">优惠金额：-<span id="discount-show"></span>元</p>
                            <p class="text-right">运费：¥<span id="shipping-cost">0</span>元</p>
                                <p class="text-right">应付总额：<span class="payment">¥<i id='payment-total'></i>元</span></p>
                                <p class="text-right gray-add"></p>
                        </div>
                        <button class="btn btn-red btn-lg pull-right btn-sp-lg" disabled="disabled" data-loading-text="正在提交" id="order-submit-btn">提交订单</button>
                       </div>
                </div>
        </div>

<!--- show model -->
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-body" style="min-height: 160px;">
		        <p class="text-center center-block" style="margin-top: 60px;">确定删除这个收货地址？</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		        <button type="button" class="btn btn-primary btn-black" id="btn-del-address" onclick="addressButton.del();" data-loading-text="提交中......">确定</button>
                                            <input name="del_address_id" id="input-del-address-id" type="hidden" value=""  />
		      </div>
		    </div>
		  </div>
		</div>
		<div id="addaddress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		    	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="gridSystemModalLabel">添加收货地址</h4>
			      </div>
		      <div class="modal-body" style="min-height: 160px;">
		        <div class="main-content Address">
                                    <div class="body-div" id="comment-list" style="min-height: 160px;">
                                            <form id="addReceipt" name="form1" style="height: 260px;border: 0;margin: 0;">
                                                    <div class="infolist" style="margin-left: 8px;padding-left: 4em;">
	                            <lable>所在地区   </lable>
	                            <div class="liststyle">
                                                  <span id="Province" style="border: none">
                                                    <select name="zone_id" class="form-control">
                                                        <option value=''>请选择省份</option>
                                                    </select>
	                                </span>
	                                <span id="City" style="border: none">
	                                    <select name="city" class="form-control">
                                                        <option value=''>请选择城市</option>
                                                      </select>
	                                </span>
	                                <span id="Area" style="border: none">
	                                    <select name="region" class="form-control">
                                                        <option value=''>请选择地区</option>
                                                      </select>
	                                </span>
	                            </div>
	                        </div>
                                            <div><span class="pull-left for-form">详细地址</span><input type="text" name="address" maxlength="32" class="form-control form-address pull-left" placeholder="请输入详细地址" autofocus /></div>
                                           <div><span class="pull-left for-form">收货人姓名</span><input type="text" maxlength="8" name="fullname" class="form-control form-address pull-left" placeholder="请输入收货人姓名" autofocus /></div>
                                           <div><span class="pull-left for-form">收货人电话</span><input type="text" maxlength="16" name="shipping_telephone" class="form-control form-address pull-left" placeholder="请输入收货人电话" autofocus /></div>
                                             <label style="line-height:2em;float: left;"><input name="default" id="input-address-isdefault" type="checkbox"  value="1" style="float: left;margin-top: 8px;"/>设为默认</label>
                                             </form>
                                         </div>
                                        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" id="button-address-submit" class="btn btn-primary btn-black" data-loading-text="加载中......">确定</button>
		      </div>
		    </div>
		  </div>
		</div>
</div>
</div>
</div>
<script type="text/javascript"><!--
    $('#order-submit-btn').click(function(){
       $.ajax({
                    url: '/checkout/confirm',
                    type: 'post',
                    data: $('#checkout-frm input[type=\'text\'], #checkout-frm input[type=\'hidden\'],  #checkout-frm input[type=\'checkbox\']:checked, #checkout-frm input[type=\'radio\']:checked, #checkout-frm textarea, #checkout-frm select'),
                    dataType: 'json',
                    beforeSend: function() {
                                $('#order-submit-btn').button('loading');
                        },
                    complete:function(){
                                $('#order-submit-btn').button('reset');
                    },
                    success:function(json){
                        redirectCheck(json);
                        if(json['order_id']){
                                window.location.href = '/checkout/payment?orderid='+json['order_id'];
                        }else if(json['error']){
                                alert(json['error']);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
          });
    });
//--></script>
<script type="text/javascript"><!--
$(function(){
    //address
    $("#add-address").click(function () {
        $('#addaddress').modal('show');
    });

    commonArea.setProvince($('select[name=\'zone_id\']'), 0);

    $(document).on('change', 'select[name=\'zone_id\']', function() {
        commonArea.reset('select[name=\'city\']');
        commonArea.setCity($('select[name=\'city\']'), $(this).val());
        commonArea.reset('select[name=\'region\']');
    });

    $(document).on('change', 'select[name=\'city\']', function() {
            commonArea.setRegion($('select[name=\'region\']'), $(this).val());
    });
    
    
    $('#receipt-info table tbody').load('/checkout/shipping_address');
    //$('#shipping-content').load('/checkout/shipping_method');

    $('#receipt-info .more-add').click(function(){
        $('#receipt-info table tbody').load('/checkout/shipping_address?type=all');
        $(this).hide();
    });
    
    //cart
    $('#cart-content-tb .del-cart-btn').click(function(){
        if($('#cart-content-tb tbody').find('tr').length>1){
            cart.removeIncart($(this), $(this).attr('_cid'));
            getShipping();
            var discountTotal = 0;
            //coupon input_hidden_pid
            $("input[name='cc_couponid[]']").each(function(){
                    var pids = jQuery.parseJSON($(this).attr('_pids'));
                    var discount = $(this).attr('_discount');
                    var flag = false;
                    $('#cart-content-tb tbody').find('.input_hidden_pid').each(function(){
                            if(pids.contains($(this).val())){
                                flag = true;
                            }
                    });
                    if(!flag){
                        $(this).prop("disabled", true);
                    }else{
                        discountTotal += discount * 1;
                    }
                    $('#discount-show').html(discountTotal);
            });

            if($('#cart-content-tb tbody').find('tr').length==1){
                $('#cart-content-tb .del-cart-btn').prop("disabled", true);
            }
        }
    });
    
    $('input[name="cc_couponid[]"]').change(function(){
        var discount = $(this).attr('_discount');
        var discountTotal = $('#discount-show').html()=='-' ? 0 : $('#discount-show').html() * 1;
        var paytotal = $('#checkout-total-content #payment-total').html()*1;
        if($(this).is(':checked')){
            discountTotal += discount * 1;
        }else if(!discountTotal<discount){
            discountTotal -= discount * 1;
        }
        paytotal -= discountTotal*1;
        $('#discount-show').html(discountTotal);
        $('#checkout-total-content #payment-total').html(paytotal.toFixed(2,10));
    });

        // Shipping Address
        $(document).delegate('#button-address-submit', 'click', function() {
            if($("#addReceipt").valid()){
                $.ajax({
                    url: '/checkout/shipping_address/save',
                    type: 'post',
                    data: $('#addReceipt input[type=\'text\'], #addReceipt input[type=\'date\'], #addReceipt input[type=\'datetime-local\'], #addReceipt input[type=\'time\'], #addReceipt input[type=\'password\'], #addReceipt input[type=\'checkbox\']:checked, #addReceipt input[type=\'radio\']:checked, #addReceipt textarea, #addReceipt select'),
                    dataType: 'json',
                    beforeSend: function() {
                                    $('#button-address-submit').button('loading');
                        },
                    success: function(json) {
                                $('.alert, .text-danger').remove();
                                if (json['redirect']) {
                                    location = json['redirect'];
                                } else if (json['error']) {
                                                $('#button-address-submit').button('reset');
                                                if (json['error']['warning']) {
                                                    $('#addReceipt .modal-footer').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                                }
                                                for (i in json['error']) {
                                                               alert( json['error'][i]);
                                                               $('#addReceipt .modal-footer').after('<div class="text-danger">' + json['error'][i] + '</div>');
                                                }
                                                // Highlight any found errors
                                                $('.text-danger').parent().parent().addClass('has-error');
                                } else {
                                                $('#receipt-info table tbody').load('/checkout/shipping_address');
                                                $('#addaddress').modal('hide');
                                                $('#button-address-submit').button('reset');
                                                setTimeout(function(){ totalshippingAddressInit(); }, 2000);
                                }
                         }
                    });
            }
        });
        
        //shipping
        $('#shipping-content').delegate('input:radio[name="shipping_method"]', 'change', function(e){
                e.preventDefault();
                var cost = $('input:radio[name="shipping_method"]:checked').attr('_cost');
                if(cost>0){
                    cost = parseFloat(cost);
                }
                var total = $('#ctc-goods-total').text();
                var amount = total*1+cost*1;
                $('#shipping-cost').html(cost>0?cost.toFixed(2, 10):'0');
                $('#payment-total').html(amount.toFixed(2, 10));
         });

        cart.checkoutTotalInfoInit();
        getShipping();
});

//--></script>
<script type="text/javascript"><!--
var pageinit = false;
setTimeout(function(){
 totalshippingAddressInit();    
 }, 1000);
 
setTimeout(function(){
 totalshippingAddressInit();
 }, 3000);

function totalshippingAddressInit(){
    if(!pageinit){
        var tr = $('#receipt-info tbody tr').eq(0);
        if(0<tr.find('td').eq(3).find('input[name="shipping_address"]').length){
               var address = '寄送地址：' + tr.find('td').eq(0).html() +'    ' +  tr.find('td').eq(1).html() +'    '+ tr.find('td').eq(2).html();
               $('.gray-add').html(address);
               $('#order-submit-btn').prop("disabled", false);
               getShipping();
               pageinit = true;
        }else{
            $('#order-submit-btn').prop("disabled", true);
        }
    }
}

function getShipping(){
        if($('#checkout-frm input[name=\'address_id\']').length > 0){
                $.ajax({
                            url: '/checkout/shipping_method/get_shippings',
                            type: 'post',
                            data: $('#checkout-frm input[type=\'hidden\'],#checkout-frm input[type=\'text\']'),
                            dataType: 'json',
                            beforeSend: function() {

                                },
                            success: function(json) {
                                    $('.alert, .text-danger').remove();
                                    if (json['redirect']) {
                                        location = json['redirect'];
                                    } else if(json['html']) {
                                        $('#shipping-content').html(json['html']);
                                        $('#shipping-content input[name="shipping_method"]:checked').trigger('change');
                                    }
                             }
                 });
         }
}

 var addressButton = {
	'del': function() {
                                    var addressid = $('input[id="input-del-address-id"]').val();
		$.ajax({
			url: '/checkout/shipping_address/delete',
			type: 'post',
			data: 'addressid='+addressid,
			dataType: 'json',
                                                      beforeSend:function(){
                                                          $('#btn-del-address').button('loading');
                                                    },
			success: function(json) {
                                                            $('#btn-del-address').button('reset');
                                                            if(json['success']){
                                                                $('#address-tr-'+addressid).remove();
                                                                $('.bs-example-modal-sm').modal('hide');
                                                                setTimeout(function(){ totalshippingAddressInit(); }, 2000);
                                                            }
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
                'setDelValue':function(addressid){
                    $('input[id="input-del-address-id"]').val(addressid);
                },
                'default': function(obj, addressid){
                                    $.ajax({
			url: '/checkout/shipping_address/setdefault',
			type: 'post',
			data: 'addressid='+addressid,
			dataType: 'json',
                                                       beforeSend:function(){
                                                          $(obj).button('loading');
                                                       },
			success: function(json) {
                                                            if(json['success']){
                                                                $('#receipt-info table tbody').load('/checkout/shipping_address');
                                                                setTimeout(function(){ totalshippingAddressInit(); }, 2000);
                                                                $('.add-more').show();
                                                            }
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
                  }
    };
    
//--></script>
<script type="text/javascript">
     $("#addReceipt").validate({
                                    rules: {
                                      region: {
                                        required: true
                                      },
                                      address:{
                                          required:true,
                                          minlength:8,
                                          maxlength:128
                                    },
                                      fullname: {
                                        required: true,
                                        minlength: 2,
                                        maxlength: 32
                                      },
                                     shipping_telephone: {
                                        required: true,
                                        isphone:true
                                      }
                                    },
                                    messages: {
                                      region: {
                                        required: "请选择所在地区"
                                      },
                                      address: {
                                        required: "请输入地址",
                                        minlength: "地址无效",
                                        maxlength: "地址无效"
                                      },
                                      fullname: {
                                        required: "请输入收货人改名",
                                        minlength: "收货人姓名无效",
                                        maxlength: "收货人姓名无效"
                                      },
                                      shipping_telephone:{
                                          required: "请输入联系电话",
                                          isphone: '联系电话无效'
                                      }
                          }
                  });

    
</script>
<?php echo $footer; ?>
