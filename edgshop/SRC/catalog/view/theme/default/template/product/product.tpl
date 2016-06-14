<?php echo $header;?>
    <!--详细页-->
    <div id="detail-top" class="container-fluid">
        <div class="container" style="min-width: 1170px;">
            <div class="row well">
                <div class="pull-left" style="width: 450px;margin-top: -30px;">
                    <div id="banner-div-thumbs">
                        <div style="width: 420px;;margin: 0 auto; padding:10px 0 0 0;">
                            <div style="width: 420px; height:512px; margin:20px auto 0 auto;">
                                <?php if($images){?>
                                <div id="allinone_thumbnailsBanner" style="display:none;">
                                    <ul class="allinone_thumbnailsBanner_list">
                                            <?php foreach($images as $image){?>
                                                <?php if(isset($image['popup'])){ ?>
                                                <li data-bottom-thumb="<?php echo $image['thumb']; ?>">
                                                    <img src="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"
                                                    alt="<?php echo $heading_title; ?>" />
                                                </li>
                                                <?php }?>
                                                <?php }?>
                                    </ul>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!--AddBaidu Share Button BEGIN-->
                    <div class="bdsharebuttonbox" style="margin-top: 100px;">
                        <a href="#" class="bds_more" data-cmd="more">
                        </a>
                        <a title="分享到QQ空间" href="javascript:;" class="bds_qzone" data-cmd="qzone">
                        </a>
                        <a title="分享到新浪微博" href="javascript:;" class="bds_tsina" data-cmd="tsina">
                        </a>
                        <a title="分享到腾讯微博" href="javascript:;" class="bds_tqq" data-cmd="tqq">
                        </a>
                        <a title="分享到人人网" href="javascript:;" class="bds_renren" data-cmd="renren">
                        </a>
                        <a title="分享到微信" href="javascript:;" class="bds_weixin" data-cmd="weixin">
                        </a>
                        <a title="分享到Facebook" href="javascript:;" class="bds_fbook" data-cmd="fbook">
                        </a>
                        <a title="分享到Twitter" href="javascript:;" class="bds_twi" data-cmd="twi">
                        </a>
                        <a title="分享到linkedin" href="javascript:;" class="bds_linkedin" data-cmd="linkedin">
                        </a>
                    </div>
                    <script>
                        window._bd_share_config = {
                            "common": {
                                "bdSnsKey": {},
                                "bdText": "",
                                "bdMini": "2",
                                "bdMiniList": false,
                                "bdPic": "",
                                "bdStyle": "0",
                                "bdSize": "24"
                            },
                            "share": {},
                            /*"image": {
                                "viewList": ["qzone", "tsina", "tqq", "renren", "weixin", "fbook", "twi", "linkedin"],
                                "viewText": "分享到：",
                                "viewSize": "16"
                            },*/
                            "selectShare": {
                                "bdContainerClass": null,
                                "bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin", "fbook", "twi", "linkedin"]
                            }
                        };
                        with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~ ( - new Date() / 36e5)];
                    </script>
                    <!--AddBaidu Share Button END-->
                </div>
                <div id='product' class="pull-left title-line">
                    <div class="col-md-12">
                        <strong>
                            <?php echo $heading_title;?>
                        </strong>
                        <div class="pull-right icons">
                            <img src="<?php echo THEME_PATH; ?>/img/mian_icon.png" />
                            <img src="<?php echo THEME_PATH; ?>/img/zhen_icon.png" />
                            <img src="<?php echo THEME_PATH; ?>/img/qi_icon.png" />
                        </div>
                    </div>
                    <?php if($manufacturer){?>
                        <div class="col-md-12">
                            <small>
                                <?php echo $manufacturer;?>
                            </small>
                        </div>
                        <?php }?>
                            <div class="col-md-12 yen">
                                <small>
                                    官方价:
                                </small>
                                <span style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;'
                                class="glyphicon glyphicon-yen " aria-hidden="true">
                                </span>
                                <strong>
                                    <?php if(!$special){?>
                                        <?php echo $price;?>
                                            <?php }else{?>
                                                <?php echo $special;?>
                                                    <?php }?>
                                </strong>
                            </div>
                            <div class="col-md-12 promot">
                                <span class="label label-primary">
                                    促销:
                                </span>
                                <span class="promot-info">
                                    至5月23号裤子满100减10不封顶
                                </span>
                            </div>
                            <?php if($options){?>
                                <?php foreach($options as $option){?>
                                    <?php if($option[ 'type']=='radio' ){?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> col-md-12 yen size-select"
                                        id="input-option<?php echo $option['product_option_id']; ?>">
                                            <small>
                                                <?php echo $option[ 'name'];?>
                                                    ：
                                            </small>
                                            <div class="pull-left">
                                                <?php foreach($option[ 'product_option_value']as $option_value){?>
                                                    <a for="input-option[<?php echo $option['product_option_id']; ?>]" class="btn btn-default<?php if($sku_info[ 'sku_code']&&in_array($option_value[ 'product_option_value_id'],$sku_info[ 'sku_code'])){?> selected<?php }?>"
                                                    style="width: auto; height: auto;" <?php if($option_value[ 'price']){?>
                                                        title="<?php echo $option_value[ 'price_prefix']; ?><?php echo $option_value[ 'price']; ?> "
                                                                <?php }else if($option_value['option_disable']){ ?> title="无货" <?php }?> 
                                                                  <?php if($option_value['option_disable']){ ?>disabled="disabled"<?php } ?>
                                                                    >
                                                                    <?php echo $option_value[ 'name'];?>
                                                                        <input type="radio" style="display:none;" <?php if($sku_info[ 'sku_code']&&in_array($option_value[ 'product_option_value_id'],$sku_info[ 'sku_code'])){?>
                                                                        checked="checked"
                                                                        <?php }?>
                                                                            name="option[<?php echo $option[ 'product_option_id']; ?>]" id="input-option[<?php echo $option[ 'product_option_id']; ?>]" value="<?php echo $option_value[ 'product_option_value_id']; ?>"/>
                                                    </a>
                                                    <?php }?>
                                            </div>
                                        </div>
                                        <?php }?>
                                            <?php if($option[ 'type']=='image' ){?>
                                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> col-md-12 yen color-select"
                                                id="input-option<?php echo $option['product_option_id']; ?>">
                                                    <small>
                                                        <?php echo $option[ 'name'];?>
                                                            ：
                                                    </small>
                                                    <div class="pull-left option-img-list">
                                                        <?php foreach($option[ 'product_option_value']as $option_value){?>
                                                            <input type="radio" style="display:none;" <?php if($sku_info[ 'sku_code']&&in_array($option_value[
                                                            'product_option_value_id'],$sku_info[ 'sku_code'])){?>
                                                            checked="checked"
                                                            <?php }?>
                                                                name="option[<?php echo $option[ 'product_option_id']; ?>]" value="<?php echo $option_value[ 'product_option_value_id']; ?>"/>
                                                                        <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['value_text'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" 
                                                                            title="<?php echo $option_value['value_text'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>"
<?php if($sku_info[ 'sku_code']&&in_array($option_value[ 'product_option_value_id'],$sku_info[ 'sku_code'])){?> class="selected"<?php }?>
                                                                        />
                                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                    <?php }?>
                                                        <?php }?>
                                                            <div class="col-md-12 yen count-select">
                                                                <small>
                                                                    选择数量：
                                                                </small>
                                                                <div class="pull-left">
                                                                    <button class="btn btn-red" disabled="disabled" act="minus">
                                                                        <span style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;'
                                                                        class="glyphicon glyphicon-minus">
                                                                        </span>
                                                                    </button>
                                                                    <input value="<?php echo $minimum; ?>" id="input-quantity" name="quantity"
                                                                    class="form-control" type="text" onkeyup="if(/\D/.test(this.value)){this.value=this.value.substring(0,this.value.length-1);}"
                                                                    />
                                                                    <button class="btn btn-red" act="plus">
                                                                        <span style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;'
                                                                        class="glyphicon glyphicon-plus">
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 yen add-buy">
                                                                <small>
                                                                </small>
                                                                <div class="pull-left">
                                                                    <button class="btn btn-red btn-lg" id="button-cart" <?php if(!$allow_buy){ ?> disabled="disabled" title="暂时无货，无法购买" <?php } ?> act="minus" data-loading-text="<?php echo $text_loading; ?>">
                                                                        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true">
                                                                        </span>
                                                                        添加到购物车
                                                                    </button>
                                                                    <button class="btn btn-buy btn-lg" <?php if(!$allow_buy){ ?> disabled="disabled" title="暂时无货，无法购买" <?php } ?>  data-loading-text=''正在提交' id="btn-buy-now">
                                                                        立即购买
                                                                    </button>
                                                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                                                                    <input type="hidden" name="sku_id" value="<?php echo $sku_id; ?>" />
                                                                </div>
                                                                <?php if($minimum>
                                                                    1){?>
                                                                    <div style='text-align: right;'>
                                                                        <i class="fa fa-info-circle">
                                                                        </i>
                                                                        <?php echo $text_minimum;?>
                                                                    </div>
                                                                    <?php }?>
                                                            </div>
                </div>
                <div class="col-md-12 production-details">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                                商品介绍
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                                售后保障
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active htmls-content" id="home">
                            <div class="row">
                                <?php if($attribute_groups){?>
                                    <?php foreach($attribute_groups as $attribute_group){?>
                                        <div class="col-md-12 pd-info">
                                            <?php foreach($attribute_group[ 'attribute']as $attribute){?>
                                                <p>
                                                    <?php echo $attribute[ 'name'];?>
                                                        ：
                                                        <span>
                                                            <?php echo $attribute[ 'text'];?>
                                                        </span>
                                                </p>
                                                <?php }?>
                                        </div>
                                        <?php }?>
                                            <?php }?>
                            </div>
                            <!--图文混排区-->
                            <div class="row" style="min-height: 700px;margin: 0 auto;width: 760px;">
                                <?php echo $description;?>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            ...
                        </div>
                    </div>
                </div>
            </div>
            <div class="row detai-comment">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <strong>
                                商品评价
                            </strong>
                        </h3>
                    </div>
                    <div id="review" class="panel-body">
                    </div>
                </div>
            </div>
            <?php if($products){?>
                <div class="row you-would-like">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <strong>
                                    猜你喜欢
                                </strong>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="box-pre">
                                <div class="picbox">
                                    <ul class="piclist mainlist">
                                        <?php $i=0;?>
                                            <?php foreach($products as $product){?>
                                                <li>
                                                    <a href="<?php echo $product['href']; ?>" target="_blank">
                                                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"
                                                        title="<?php echo $product['name']; ?>" />
                                                    </a>
                                                    <p class="text-center">
                                                        <span style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;'
                                                        class="glyphicon glyphicon-yen " aria-hidden="true">
                                                        </span>
                                                        <?php if($product[ 'price']){?>
                                                                <?php if(!$product[ 'special']){?>
                                                                    <?php echo $product[ 'price']; ?>
                                                                <?php }else{?>
                                                                                <span class="price-new">
                                                                                    <?php echo $product[ 'special'];
                                                                                ?>
                                                                                </span>
                                                                                <span class="price-old">
                                                                                    <?php echo $product[ 'price'];?>
                                                                                </span>
                                                                <?php }?>
                                                        <?php }?>
                                                    </p>
                                                </li>
                                                <?php }?>
                                    </ul>
                                </div>
                                <div class="og_prev">
                                </div>
                                <div class="og_next">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
        </div>
    </div>
    </div>
    <?php echo $content_bottom;?>
        </div>
        <?php echo $column_right;?>
            </div>
            </div>
<script type="text/javascript"><!--
sku_json = <?php echo json_encode($all_sku_data); ?>;

$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: '/product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});

$("#product .form-group a").click(function(){
    if($(this).attr('disabled') && 'disabled' == $(this).attr('disabled')){
        //return;
    }
    if(!$(this).find('input[type=\'radio\']').is(':checked')){
        $(this).find('input[type=\'radio\']').prop('checked', true);
        $(this).find('input[type=\'radio\']').trigger('change');
    }
});

$('.option-img-list img').click(function(){
    if(!$(this).prev().is(':checked')){
         $(this).prev().prop('checked', true);
         $(this).prev().trigger('change');
    }
 });

$('#product .form-group input[type="radio"]').change(function(){
                            var code = [];
                            $('#product .form-group input[type="radio"]:checked').each(function(){
                                    code.push($(this).val());
                            });
                            code.sort();
                            var key = code.join('-');
                            if(sku_json[key] && sku_json[key]*1>0){
                                window.location.href = '/'+sku_json[key]+'.html';
                                return;
                            }
                            return;
                            $.ajax({
		url: '/product/product/getProductCode',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
                    
                                    },
                                    complete: function() {
                                        
		},
		success: function(json) {
                                            $('.alert, .text-danger').remove();
                                            if (json['success']) {
                                                window.location.href = json['redirect'];
                                            }
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                                });
});
//--></script>
<script type="text/javascript"><!--
$(function(){
	$('#imgcxside').cxSlide({
	  events: 'mouseover',
	  type: 'fade',
	  speed: 300
	});
	$('#allinone_thumbnailsBanner').allinone_thumbnailsBanner({
			skin: 'simple',
			numberOfThumbsPerScreen:5,
			width: 420,
			height: 508,
			thumbsReflection:0,
			defaultEffect: 'fade',
			showNavArrows:0,
			absUrl:"../",
			autoPlay:0,
			showCircleTimer:false
		});
	$(".allinone_thumbnailsBanner").imagezoom();
	$(".stripe").hover(function(){
		$(".allinone_thumbnailsBanner").hover();
	});
        
});
//-->
</script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: '/checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
                                                      $('#btn-buy-now').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				$('.breadcrumb').after('<div class="alert alert-success levi-alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                                                        //$('#cart .tooltip-inner').html(json['total']);
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				//$('#cart > ul').load('index.php?route=common/cart/info ul li');
                                                                        $('#cart').load('index.php?route=common/cart/info');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//立即购买
$('#btn-buy-now').click(function(){
    $(this).button('loading');
    $('#button-cart').trigger('click');
    window.location.href = '/checkout/cart?sid='+$('#product input[name="sku_id"]').val();
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('/product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: '/product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

//--></script>
<?php echo $footer;?>