/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


    jQuery.validator.addMethod("exists_account", function(value, element) {
        var flag = false;
        $.ajax({  
            type:"POST",  
            url:'/account/register/accountchk', 
            async:false,
            data:{'mobile':value}, 
            dataType:'json',
            success: function(result){
                var btn = $('#getting');
                 if(result.code == 'ok'){
                     btn.attr('disabled',false);
                     flag = true;
                 } else{
                     btn.attr('disabled',true);
                 }
            }  
        });
        return flag;
    }, "该手机号已存在");
    
$(document).ready(function(){
         if($.cookie("captcha_user_register")){
            var count = $.cookie("captcha_user_register");
            var btn = $('#getting');
            btn.val('重新获取'+count+'(s)').attr('disabled',true).css('cursor','not-allowed');
            var resend = setInterval(function(){
                count--;
                if (count > 0){
                    btn.val('重新获取'+count+'(s)').attr('disabled',true).css('cursor','not-allowed');
                    $('#getting').css({
                      border: '#dfdfdf 1px solid',
                      background: '#b1b1b1'
                    });
                    $.cookie("captcha_user_register", count, {path: '/', expires: (1/86400)*count});
                }else {
                    clearInterval(resend);
                    btn.val("获取验证码").removeClass('disabled').removeAttr('disabled style');
                    $('#getting').css({
                      border: '#cb0901 1px solid',
                      background: '#cb0901'
                    });
                }
            }, 1000);
        }
 
        /*点击改变按钮状态，已经简略掉ajax发送短信验证的代码*/
        $('#getting').click(function(){
                if(!$.cookie("captcha_user_register")){
                    var mobile = $('#input_mobile').val();
                    if(!ismobile(mobile)){ return; }
                    $.cookie("captcha", 60, {path: '/', expires: (1/86400)*60});
                    $.ajax({
                            url: "/sms/send",
                            dataType: "json",
                            data:{type:'user_register', mobile:mobile},
                            type:'POST',
                            cache: !1,
                            timeout: 3000,
                            success: function(result){
                                    if('ok'==result.status){
                                        var btn = $('#getting');
                                        var count = 60;
                                        var resend = setInterval(function(){
                                            count--;
                                            if (count > 0){
                                                btn.val('重新获取'+count+'(s)');
                                                $.cookie("captcha_user_register", count, {path: '/', expires: (1/86400)*count});
                                            }else {
                                                clearInterval(resend);
                                                btn.val("获取验证码").removeAttr('disabled style');
                                                $('#getting').css({
                                                  border: '#cb0901 1px solid',
                                                  background: '#cb0901'
                                                })
                                            }
                                        }, 1000);
                                        btn.attr('disabled',true).css('cursor','not-allowed');
                                        $('#getting').css({
                                            border: '#dfdfdf 1px solid',
                                            background: '#b1b1b1'
                                          });
                                    }else{
                                        alert(result.data);
                                    }
                             }
                     });
                }else{
                      return;
                }
        });

        $("#form-register").validate({
                    rules: {
                      password: "required",
                      account: {
                        required: true,
                        ismobile:true,
                        exists_account:true
                      },
                      smscode: {
                        required: true,
                        minlength: 6,
                        maxlength: 6
                      },
                      password: {
                        required: true,
                        minlength: 8,
                        maxlength:16
                      },
                      confirm_password: {
                        required: true,
                        minlength: 8,
                        maxlength:16,
                        equalTo: "#password"
                      },
                    },
                    messages: {
                      account: {
                        required: "请输入用户名",
                        ismobile: "手机号码格式错误",
                        exists_account:"该手机号已经被别的用户注册使用"
                      },
                      smscode: {
                        required: "请输入验证码",
                        minlength: "验证码错误",
                        maxlength: "验证码错误"
                      },
                      password: {
                        required: "请输入密码",
                        minlength: "请输入8~16位密码",
                        maxlength: "请输入8~16位密码"
                      },
                      confirm_password: {
                        required: "请输入密码",
                        minlength: "请输入8~16位密码",
                        equalTo: "两次输入的密码不一致"
                      }
                    }
          });
          
        //提交注册
        $('#form-register').submit(function(){
             if($(this).valid()){
                    var mobile = $('#input_mobile').val();
                    var smscode = $('#validation').val();
                    var pwd = $('#password').val();
                    $.ajax({
                      type:"POST",  
                      url:'/account/register/create', 
                      async:false,//同步方法，如果用异步的话，flag永远为1  
                      data:{'account':mobile, 'smscode':smscode, 'password':pwd}, 
                      dataType:'json',
                      success: function(result){
                           if(result.code == 'ok'){ 
                               alert('注册成功!');
                           } else{
                               //alert(result.msg);
                               $('#form-signin .btn-login').parent().after('<div class="text-danger">' + result.msg + '</div>');
                           }
                      }  
                  });
              }
            return false;
        });
        
    });
    
function ismobile(no){
     var length = no.length;
     var mobile = /(^13\d{9}$)|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17[6,7,8]\d{8}$)|(^18[0,1,2,5,6,7,8,9]\d{8}$)|(^14[5,7]\d{8}$)/g;
     return (length == 11 && mobile.exec(no))? true:false;
}