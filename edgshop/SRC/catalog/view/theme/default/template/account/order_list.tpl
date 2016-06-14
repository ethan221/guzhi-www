<?php echo $header; ?>
<!--个人中心-->
<div id="person-center" class="container">
            <?php echo $account_left; ?>
            <div class="right-content" id="account-right-content">
                        <div class="top-bar">
                        &nbsp;&nbsp;<?php echo $heading_title; ?>&nbsp; <span>My Order</span>
                        </div>	
                        <div class="main-content">
                                <div class="body-div order" id="comment-list">
                                        <?php if($orders){ ?>
                                        <?php foreach ($orders as $order) { ?>
                                                        <div class=" head-div">
                                                                <div class="text-left"><?php echo $order['date_added']; ?> 订单号:<?php echo $order['order_no']; ?></div>
                                                        </div>
                                                        <table border="1" class="myList" >
                                                          <tr>
                                                            <td class="product-pic">
                                                                <?php if($order['products']){ ?>
                                                                <?php foreach($order['products'] as $product){ ?>
                                                                <table width="100%" border="0">
                                                                    <tr>
                                                                        <td valign="midden;" style="width:143px;height:128px;">
                                                                            <?php if($product['image']!=''){ ?><a style="display: block;" href="<?php echo $product['href'];?>" target="_blank"><img style="width:143px;" src="<?php echo $product['image']; ?>" /></a><?php } ?>
                                                                    </td><td valign="midden;">
                                                                        &nbsp;<a href="<?php echo $product['href'];?>" target="_blank"><?php echo $product['name']; ?>&nbsp;&nbsp;<?php echo $product['option_text']; ?></a>
                                                                    </td>
                                                                    </tr>
                                                                </table>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="product-count">x<?php echo $order['product_total']; ?></td>
                                                            <td class="product-value">
                                                                <p>总额<?php echo $order['total']; ?></p>
                                                                <p class="pay-method">在线支付</p>
                                                                </td>
                                                            <td class="product-statu">
                                                                <p class="center-block finish"><?php echo $order['status']; ?></p>
                                                                <p><a href="<?php echo $order['view']; ?>">订单详情</a></p>
                                                            </td>
                                                            <td class="product-choose">
                                                                <?php if($order['order_status_id'] == '5'){ ?><p class="center-block text-upper"><a href="account/comment?status=wait">评价晒单</a></p> <?php } ?>
                                                                <?php if(!in_array($order['order_status_id'], array('0'))){ ?>
                                                                <button class="center-block btn <?php if($order['order_status_id'] == '5'){ ?>btn-finish<?php }else{ ?>btn-ing<?php } ?> btn-buyagain" data-loading-text="正在提交"  _orderid="<?php echo $order['order_id']; ?>">再次购买</button>
                                                                <?php }else{ ?>
                                                                        <?php if($order['order_status_id'] == '0'){ ?><p class="center-block text-upper"><a target="_blank" href="/checkout/payment?orderid=<?php echo $order['order_id']; ?>">去支付</a></p><?php } ?>
                                                                        <button class="center-block btn btn-pay btn-cannel" _orderid="<?php echo $order['order_id']; ?>" data-loading-text="正在取消">取消定单</button>
                                                                <?php } ?>
                                                            </td>
                                                          </tr>
                                                        </table>
                                        <?php } ?>
                                        <?php } ?>
                                </div>
                        </div>

                        <div class="foot-page">
                               <?php echo $pagination; ?>
                        </div>

            </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
    $(document).ready(function(){
            $('.btn-buyagain').click(function(){
                var orderid = $(this).attr('_orderid');
                buyagain($(this), orderid);
            });
            $('.btn-cannel').click(function(){
                var orderid = $(this).attr('_orderid');
                cannelOrder($(this), orderid);
            });
    });
 </script>
 
<script type="text/javascript"><!--
    function buyagain(buttonObj,orderid){
        $.ajax({
                    url: '/checkout/cart/addagain',
                    type: 'post',
                    data: 'orderid=' + orderid,
                    dataType: 'json',
                    beforeSend: function() {
                            $(buttonObj).button('loading');
                    },
                    complete: function() {
                            $(buttonObj).button('reset');
                    },
                    success: function(json) {
                            $('.alert, .text-danger').remove();
                            if (json['redirect']) {
                                    location = json['redirect'];
                            }
                            if (json['success']) {
                                    //$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                    //$('html, body').animate({ scrollTop: 0 }, 'slow');
                                    location.href = "/checkout/cart?rid="+orderid;
                            }
                            if(json['error']){
                                    if (json['error']['option']) {
                                            for (i in json['error']['option']) {
                                                alert(json['error']['option'][i] );
                                                    var element = $(buttonObj).parent('.myList');
                                                    element.next().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                            }
                                    }
                                    // Highlight any found errors
                                    $('.text-danger').parent().parent().addClass('has-error');
                            }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
    }
    
    //cannel order
    function cannelOrder(buttonObj, orderid){
            $.ajax({
                    url: '/account/order/cannel',
                    type: 'post',
                    data: 'orderid=' + orderid,
                    dataType: 'json',
                    beforeSend: function() {
                            $(buttonObj).button('loading');
                    },
                    complete: function() {
                            $(buttonObj).button('reset');
                    },
                    success: function(json) {
                            $('.alert, .text-danger').remove();
                            if (json['redirect']) {
                                    location = json['redirect'];
                            }
                            if (json['success']) {
                                    window.location.reload();
                            }
                            if(json['error']){
                                alert(json['error']);
                            }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
    }
    //--></script>

