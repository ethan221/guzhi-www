<?php echo $header; ?>
	<!--个人中心-->
                <div id="person-center" class="container">
                    <?php echo $account_left; ?>
                    <div class="right-content" id="account-right-content">
                    <div class="top-bar">
                                &nbsp;&nbsp;修改密码&nbsp; <span>Modify password</span>
                        </div>	


                        <div class="main-content" id='modify'>
                                <form class="form-modify" id="modify-frm" role="form">
                                    <p><input type="password" name="password_old" style="margin-bottom: auto;" id="password-old" class="form-control" maxlength="16" placeholder="输入现有密码" /></p>
                                    <p><input type="password" name="password" id="password" class="form-control" maxlength="16" placeholder="请输入新密码" /></p>
                                    <p><input type="password" name="confirm_password" class="form-control" maxlength="16" placeholder="请再次输入新密码" /></p>
                                <button class="btn btn-login btn-modify" data-loading-text='提交中...' id='button-modify-pwd' type="button">提交</button>
                        </form>
                                </div>
                        </div>
                    </div>
		  </div>
		</div>
     
<?php echo $footer; ?>
<script type="text/javascript"><!--
$(document).ready(function(){
        $('#button-modify-pwd').click(function(){
                    if($('#modify-frm').valid()){
                             $.ajax({
                                    url: '/account/password/modify',
                                    type: 'post',
                                    data:$('#modify-frm input[type=\'password\']'),
                                    dataType: 'json',
                                    beforeSend:function(){
                                          $('#button-modify-pwd').button('loading');
                                    },
                                    complete:function(){
                                          $('#button-modify-pwd').button('reset');
                                      },
                                    success: function(json) {
                                             $('.alert, .text-danger').remove();
                                             if(json['success']){
                                                    $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                             }else if(json['error']){
                                                    $('.breadcrumb').after('<div class="alert alert-warning">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                                             }
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                            });
                    }

        });
 });
//-->
</script>
<script type="text/javascript">
     $("#modify-frm").validate({
                                    rules: {
                                      password_old:{
                                          required:true,
                                          rangelength:[8,16]
                                    },
                                      password: {
                                        required: true,
                                        rangelength:[8,16]
                                      },
                                     confirm_password: {
                                        required: true,
                                        equalTo:'#password'
                                      }
                                    },
                                    messages: {
                                      password_old: {
                                        required: "请输入密码",
                                        rangelength: "密码无效",
                                      },
                                      password: {
                                        required: "请输入新密码",
                                        rangelength: "新密码无效"
                                      },
                                      confirm_password:{
                                          required: "请输入确认密码",
                                          equalTo: '两次密码输入不一致'
                                      }
                          }
                  });
                  </script>
