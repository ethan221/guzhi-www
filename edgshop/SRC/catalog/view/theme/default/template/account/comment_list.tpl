<?php echo $header; ?>
<!--个人中心-->
<div id="person-center" class="container">
            <?php echo $account_left; ?>
            <div class="right-content" id="account-right-content">
                       <div class="top-bar">
                                &nbsp;&nbsp;已评价商品&nbsp; <span>Goods evaluated</span>
                        </div>	
                        <div class="main-content">
                                <div class=" head-div">
                                        <div class="col-md-5 col-lg-5 col-xs-5 col-sm-5 text-center">商品名称</div>
                                        <div class="col-md-2 col-lg-2 col-xs-2 col-sm-2 text-center">购买时间</div>
                                        <div class="col-md-3 col-lg-3 col-xs-3 col-sm-3 text-center">评论内容</div>
                                        <div class="col-md-2 col-lg-2 col-xs-2 col-sm-2 text-center">操作</div>
                                </div>
                                <div class="body-div evaluate" id="comment-list">
                                                <?php if(isset($comment_products)){ ?>
                                                <?php foreach($comment_products as $product){ ?>
                                                <table border="1" class="myList" style="overflow: auto;width:100%;">
                                                        <tbody><tr>
                                                                <td class="product-pic" style="width:40%">
                                                                <p>
                                                                    <div>
                                                                        <?php echo $product['name']; ?>
                                                                        <?php if($product['options']){ ?>
                                                                            <?php foreach($product['options'] as $option){ ?>
                                                                                    <?php echo $option['name'].':'.$option['value']; ?>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </div>
                                                                   <?php if($product['image']){ ?><img src="<?php echo $product['image']; ?>"/><?php } ?>
                                                                </p>
                                                          </td>
                                                          <td class="product-time" style="width:8%"><?php echo str_replace(' ','<br />', $product['date_added']); ?></td>
                                                          <td class="product-evaluat" valign='top'>
                                                                  <div class="evaluation pull-left text-center" style="overflow: hidden;">
                                                                              <div class="grade">
                                                                                <div class="grade-bd">
                                                                                      <?php for($i =1;$i<6; $i++){ ?>
                                                                                      <i tip="a<?php echo $i; ?>" <?php if($i-1<$product['comment']['rating']){ ?> class="curr" <?php } ?>></i>
                                                                                      <?php } ?>
                                                                                      <span></span> 
                                                                                </div>
                                                                              </div>
                                                                      <p class="center-block"><?php echo $product['comment']['text']; ?></p>
                                                                      </div>
                                                              </td>
                                                              <td class="product-choose" style="width:15%"><button class="center-block btn btn-danger btn-buyagain" _sid="<?php echo $product['sku_id']; ?>"  _opid="<?php echo $product['order_product_id']; ?>">再次购买</button></td>
                                                        </tr>
                                                      </tbody></table>
                                                 <?php } ?>
                                                 <?php } ?>
                                        </div>
                                </div>
                        </div>

                        <div class="foot-page">
                                <?php echo $pagination; ?>
                        </div>

                
                
            </div>
</div>
     
<?php echo $footer; ?>
<script type="text/javascript"><!--
    $(function(){
            $('.btn-buyagain').on('click', function(){
                var opid = $(this).attr('_opid');
                var sid = $(this).attr('_sid');
                buyagain($(this), opid, sid);
            });

    });
 </script>
 
<script type="text/javascript"><!--
    function buyagain(buttonObj, opid, sid){
        $.ajax({
                    url: '/checkout/cart/addfromopid',
                    type: 'post',
                    data: 'opid='+opid,
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
                                    location.href = "/checkout/cart?sid="+sid;
                            }
                            if(json['error']){
                                    for (i in json['error']) {
                                                    $('#account-right-content').prepend('<div class="text-danger">' + json['error'][i] + '</div>');
                                    }
                            }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
    }
    //-->
     </script>