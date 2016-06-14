<?php echo $header; ?>
<!--购物车-->
		<div id="cart-content" class="container cart-content-nomarl">
			<div class="top-bar">
				&nbsp;&nbsp;购物车&nbsp; <span>Shopping Cars</span>
			</div>
                    <form id='checkout_frm' action="<?php echo $checkout; ?>" method="post">
                        <table id="cart-content-tb" class="table table-hover" >
		      <thead>
		        <tr>
                            <th width="30px"><input type="checkbox" id="allSelect"  class="checkbox-inline"/></th>
		          <th width="110px" style="text-align: left;">全选</th>
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
                                                      <tr>
                                                          <th scope="row" class="cartid_chk">
                                                              <input type="checkbox" name="cartid[<?php echo $product['cart_id'];?>]"  <?php if($product['selected'] == '1'){ ?>checked='checked'<?php }?>   value="<?php echo $product['cart_id'];?>" class="checkbox-inline"/>
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
                                                            <button type="button" data-toggle="tooltip" onclick="cart.removeIncart(this, '<?php echo $product['cart_id']; ?>');" data-loading-text="删除中..." class="btn btn-default">删除</button>
                                                        </td>
                                                      </tr>
                                                       <?php } ?>
		      </tbody>
		    </table>
                                                    <div id="checkout-total-content" class="well">
                                                        <p class="text-right"><span id='ctc-goods-count'>2</span>件商品，合计金额为：<span id='ctc-goods-total'>¥-元</span></p>
                                                            <p class="text-right">优惠金额：-无</p>
                                                            <p class="text-right">运费：¥0元</p>
                                                            <p class="text-right">应付总额：<span class="payment">¥-</span></p>
                                                            <p class="text-right gray-add"></p>
                                                    </div>
                                                        <button class="btn btn-red btn-lg pull-right btn-sp-lg" style="margin-right: 20px;"><?php echo $button_checkout; ?></button>                 
                                                      
                                                  </form>
                                                  </div>
<?php echo $footer; ?> 
<script type="text/javascript"><!--
    $(document).ready(function() {
        $('#checkout_frm').submit(function(){
            $('.alert-success, .alert-danger').remove();
            if($(".cartid_chk input[type='checkbox']:checked").length>0){
                return true;
            }
            alert('请选择要支付的商品');
            return false;
        });
        $(".cartid_chk input[type='checkbox'], #allSelect").change(function(){
            checkoutTotalInfoInit();
        });
    });
//-->
</script>
<script type="text/javascript"><!--
    function checkoutTotalInfoInit(){
            var goods_count = 0;
            var total = 0;
            $('#cart-content-tb tbody tr').each(function(){
                if($(this).find(".cartid_chk input[type='checkbox']").is(':checked')){
                    var price = $(this).find('td').eq(3).html().replace(',','');
                    var qua = $(this).find('td').eq(4).find('input[type="text"]').val();
                    goods_count += qua*1;
                    total += (parseFloat(price))*qua;
                }
            });
            total = '¥'+total.toFixed(2,10)+'元';
            $('#ctc-goods-count').html(goods_count);
            $('#ctc-goods-total').html(total);
            $('#checkout-total-content .payment').html(total);
      }
      
      checkoutTotalInfoInit();
//-->
</script>