<?php echo $header; ?>
<style >
        .addressList .myList{width: 100%;text-align: center;}
        .address-name{width: 15%}
        .address-add{width: 30%;padding:0 1em;}
        .address-phone{width: 23%}
        .address-choose{width: 30%}
        .address-choose	span{margin-right: .6em;}
        td{ text-align:center; }
        label.error { color:red; }
        .address-base-addinfo label.error { padding-left: 13%; }
</style>
<script src="<?php echo THEME_PATH; ?>js/jquery/jquery.validate.min.js"></script>
<script src="<?php echo THEME_PATH; ?>js/ValidateExtend.js"></script>
	<!--个人中心-->
                <div id="person-center" class="container">
                    <?php echo $account_left; ?>
                    <div class="right-content" id="account-right-content">
                    <div class="top-bar">
                &nbsp;&nbsp;收货地址&nbsp; <span>Receipt address</span>
                                        </div>	
                                        <p class="receipt pull-left">已有<span>2</span>个地址（最多保存10个）</p>
                                        <p class="addReceipt  pull-right"  id="address-add-btn">添加收货地址</p>

                                        <div class="main-content Address" style="overflow: hidden;">
                                                <div class=" head-div">
                                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 text-left">添加收货地址</div>
                                                </div>
                                            <div class="body-div" id="addReceipt" style="margin-top:46px;margin-bottom:0; padding-bottom: 60px; height: auto;">
                                                    <form  name="form1">
                                                                <div class="infolist">
                                                                    <lable>所在地区</lable> 
                                                                    <div class="liststyle" style="overflow: hidden;margin-left: 0">
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
                                                                        <span id="Area" style="border: none; height: auto;">
                                                                            <select name="region" class="form-control">
                                                                                        <option value=''>请选择地区</option>
                                                                                      </select>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="address-base-addinfo">
                                                                        <div><span class="pull-left for-form">详细地址</span><input type="text" name="address" maxlength="32" class="form-control form-address pull-left" placeholder="请输入详细地址" autofocus /></div>
                                                                        <div><span class="pull-left for-form">收货人姓名</span><input type="text" maxlength="8" name="fullname" class="form-control form-address pull-left" placeholder="请输入收货人姓名" autofocus /></div>
                                                                        <div><span class="pull-left for-form">收货人电话</span><input type="text" maxlength="16" name="shipping_telephone" class="form-control form-address pull-left" placeholder="请输入收货人电话" autofocus /></div>
                                                                        <div><input name="default" type="checkbox" value="1" style="margin:2em 1em 0 2em;"/><span style="line-height:2em;">设为默认</span></div>
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-add" style="top:auto;" id="button-address-submit" data-loading-text="提交中..." type="button">确定</button>
                                                                    <button class="btn btn-cancel" type="reset" style="top:auto;">取消</button>
                                                                </div>
                                                                <input type="hidden" name="addressid" value="" />
                                                        </form>
                                                    </div>
                                        </div>

                                <div class="main-content">
                                        <div class=" head-div">
                                                <div class="col-md-2 col-lg-2 col-xs-2 col-sm-2 text-center">收货人</div>
                                                <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4 text-center">地址</div>
                                                <div class="col-md-2 col-lg-2 col-xs-2 col-sm-2 text-center">联系电话</div>
                                                <div class="col-md-4 col-lg-4 col-xs-4 col-sm-4 text-center">操作</div>
                                        </div>
                                        <div class="body-div" id="comment-list">
                                            <?php if ($addresses) { ?>
                                            <?php foreach ($addresses as $result) { ?>
                                            <table border="1" class="myList"  id="address-tr-<?php echo $result['address_id']; ?>">
                                                <tr>
                                                  <td class="address-name"><?php echo $result['fullname']; ?></td>
                                                  <td class="address-add"><?php echo $result['zone'].'，'.$result['city'].'，'.$result['region'].'，'.$result['address']; ?></td>
                                                  <td class="address-phone"><?php echo $result['shipping_telephone']; ?></td>
                                                  <td class="address-choose">
                                                      <button onclick="editAddress(<?php echo $result['address_id']; ?>);" class="span-center">编辑</button><span  class="span-center">|</span>
                                                      <button data-toggle="modal" onclick="addressButton.setDelValue(<?php echo $result['address_id']; ?>);" data-target=".bs-example-modal-sm"  class="span-center">删除</button>
                                                      <?php if($result['address_id'] != $address_id){ ?><button data-loading-text="提交中......" onclick="addressButton.default(this,<?php echo $result['address_id']; ?>);" class="btn btn-danger default span-center">设为默认</button><?php } ?>
                                                       <input type="hidden" name="address[<?php echo $result['address_id']; ?>]['zoneid']" value="<?php echo $result['zone_id']; ?>" />
                                                        <input type="hidden" name="address[<?php echo $result['address_id']; ?>]['cityid']" value="<?php echo $result['city_id']; ?>" />
                                                        <input type="hidden" name="address[<?php echo $result['address_id']; ?>]['regionid']" value="<?php echo $result['region_id']; ?>" />
                                                        <input type="hidden" name="address[<?php echo $result['address_id']; ?>]['address']" value="<?php echo $result['address']; ?>" />
                                                        <input type="hidden" name="address[<?php echo $result['address_id']; ?>]['default']" value="<?php echo (int)$result['address_id'] == $address_id; ?>" />
                                                  </td>
                                                </tr>
                                              </table>
                                            <?php } ?>
                                               <?php } else { ?>
                                                <p><?php echo $text_empty; ?></p>
                                            <?php } ?>
                                        </div>
                                </div>
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
     
<?php echo $footer; ?>
<script type="text/javascript"><!--
$(document).ready(function(){
    commonArea.setProvince($('select[name=\'zone_id\']'), 0);

    $(document).on('change', 'select[name=\'zone_id\']', function() {
        commonArea.reset('select[name=\'city\']');
        commonArea.setCity($('select[name=\'city\']'), $(this).val());
        commonArea.reset('select[name=\'region\']');
    });

    $(document).on('change', 'select[name=\'city\']', function() {
            commonArea.setRegion($('select[name=\'region\']'), $(this).val());
    });
    
     // Shipping Address
        $(document).delegate('#button-address-submit', 'click', function() {
            if($("#addReceipt form").valid()){
                var addressid = $('#addReceipt input[name="addressid"]').val();
                if(addressid<1){
                           if($('.repeat').length>9){
                               alert('最多只能添加10个地址');
                           }
                            $.ajax({
                                url: 'index.php?route=checkout/shipping_address/save',
                                type: 'post',
                                data: $('#addReceipt input[type=\'text\'],#addReceipt input[type=\'checkbox\']:checked,  #addReceipt textarea, #addReceipt select'),
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
                                                            for (i in json['error']) {
                                                                           alert( json['error'][i]);
                                                            }
                                                            // Highlight any found errors
                                                            $('.text-danger').parent().parent().addClass('has-error');
                                            } else {
                                                            window.location.reload();
                                            }
                                     }
                                });
                      }else{
                          //edit
                          addressButton.edit();
                      }
            }
        });
});

$('#address-add-btn').click(function(){
    if($('.repeat').length<10){
        $('#addReceipt input[name="addressid"]').val('');
       $("#addReceipt .btn-cancel").trigger('click');
       $('.Address .head-div').html('添加收货地址');
    }else{
        alert('最多只能添加10个地址');
    }
});
//-->
</script>
<script type="text/javascript">
    function editAddress(addressid){
        commonArea.setProvince($('select[name=\'zone_id\']'), $('input[name="address['+addressid+'][\'zoneid\']"]').val());
        setTimeout(function(){
            commonArea.setCity($('select[name=\'city\']'), $('input[name="address['+addressid+'][\'zoneid\']"]').val(), $('input[name="address['+addressid+'][\'cityid\']"]').val());
        }, 300);
        setTimeout(function(){
            commonArea.setRegion($('select[name=\'region\']'), $('input[name="address['+addressid+'][\'cityid\']"]').val(), $('input[name="address['+addressid+'][\'regionid\']"]').val());
        }, 600);
        $('#addReceipt input[name="address"]').val($('input[name="address['+addressid+'][\'address\']"]').val());
        $('#addReceipt input[name="fullname"]').val($('#address-tr-'+addressid+' td').first().html());
        $('#addReceipt input[name="shipping_telephone"]').val($('#address-tr-'+addressid+' td').eq(2).html());
        $('#addReceipt input[name="default"]').prop('checked', $('input[name="address['+addressid+'][\'default\']"]').val()==1);
        $('#addReceipt input[name="addressid"]').val(addressid);
        $('.Address .head-div').html('编辑收货地址');
    }
</script>
<script type="text/javascript">
     $("#addReceipt form").validate({
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
                                                            }
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
                'edit': function() {
		$.ajax({
			url: '/checkout/shipping_address/edit',
			type: 'post',
			data:$('#addReceipt input[type=\'text\'], #addReceipt input[type=\'hidden\'], #addReceipt input[type=\'checkbox\']:checked, #addReceipt select'),
			dataType: 'json',
                                                      beforeSend:function(){
                                                            $('#button-address-submit').button('loading');
                                                      },
                                                      complete:function(){
                                                            $('#button-address-submit').button('reset');
                                                        },
			success: function(json) {
                                                            window.location.reload();
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
                                                                window.location.reload();
                                                            }
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
                  }
    };
</script>