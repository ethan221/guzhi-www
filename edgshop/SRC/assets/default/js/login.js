/* 
* @Author: nick
* @Date:   2016-04-07 14:58:44
* @Last Modified time: 2016-04-11 11:53:21
*/
var newwin;

 jQuery.validator.addMethod("exists_mobile", function(value, element) {    //用jquery ajax的方法验证电话是不是已存在  
        var flag = false;
        $.ajax({  
            type:"POST",  
            url:'/account/register/accountchk', 
            async:false,//同步方法，如果用异步的话，flag永远为1  
            data:{'mobile':value}, 
            dataType:'json',
            success: function(result){
                 if(result.code != 'ok'){ 
                     flag = true;
                 } 
            }  
        });
        return flag;
    }, "该手机号不存在");

$(document).ready(function(){
        if($.cookie("captcha_user_findpwd")){
            var count = $.cookie("captcha_user_findpwd");
            var btn = $('#ret-getting');
            btn.val('重新获取'+count+'(s)').attr('disabled',true).css('cursor','not-allowed');
            var resend = setInterval(function(){
                count--;
                if (count > 0){
                    btn.val('重新获取'+count+'(s)').attr('disabled',true).css('cursor','not-allowed');
                    $('#ret-getting').css({
                      border: '#dfdfdf 1px solid',
                      background: '#b1b1b1'
                    });
                    $.cookie("captcha_user_findpwd", count, {path: '/', expires: (1/86400)*count});
                }else {
                    clearInterval(resend);
                    btn.val("获取验证码").removeClass('disabled').removeAttr('disabled style');
                    $('#ret-getting').css({
                      border: '#cb0901 1px solid',
                      background: '#cb0901'
                    });
                }
            }, 1000);
        }
 
        /*点击改变按钮状态，已经简略掉ajax发送短信验证的代码*/
        $('#ret-getting').click(function(){
                if(!$.cookie("captcha_user_findpwd")){
                    var mobile = $('#input-find-mobile').val();
                    if(!ismobile(mobile)) return;
                    $.cookie("captcha", 60, {path: '/', expires: (1/86400)*60});
                    $.ajax({
                            url: "/sms/send", 
                            dataType: "json",
                            data:{type:'user_findpwd', mobile:mobile},
                            type:'POST',
                            cache: !1,
                            timeout: 3000,
                            success: function(result){
                                    if('ok'==result.status){
                                        var btn = $('#ret-getting');
                                        var count = 60;
                                        var resend = setInterval(function(){
                                            count--;
                                            if (count > 0){
                                                btn.val('重新获取'+count+'(s)');
                                                $.cookie("captcha_user_findpwd", count, {path: '/', expires: (1/86400)*count});
                                            }else {
                                                clearInterval(resend);
                                                btn.val("获取验证码").removeAttr('disabled style');
                                                $('#ret-getting').css({
                                                  border: '#cb0901 1px solid',
                                                  background: '#cb0901'
                                                })
                                            }
                                        }, 1000);
                                        btn.attr('disabled',true).css('cursor','not-allowed');
                                        $('#ret-getting').css({
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

                $("#form-signin").validate({
                                    rules: {
                                      account: {
                                        required: true,
                                        ismobile:true
                                      },
                                      password: {
                                        required: true,
                                        minlength: 8,
                                        maxlength: 16
                                      }
                                     
                                    },
                                    messages: {
                                      account: {
                                        required: "请输入用户名",
                                        ismobile: "手机号码格式错误"
                                      },
                                      password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 8 个字母"
                                      }
                                    }
                  });

                
                $("#form-findpwd").validate({
                                    rules: {
                                      account: {
                                        required: true,
                                        ismobile: true,
                                        exists_mobile:true
                                      },
                                      validation: {
                                        required: true,
                                        minlength: 6,
                                        maxlength: 6
                                      },
                                      password: {
                                        required: true,
                                        minlength: 8,
                                        maxlength: 16
                                      },
                                      confirm_password: {
                                        required: true,
                                        minlength: 8,
                                        equalTo: "#new-password"
                                      },
                                     
                                    },
                                    messages: {
                                      account: {
                                        required: "请输入用户名",
                                        ismobile: '无效的手机号码',
                                        exists_mobile:'该手机号码还未注册'
                                      },
                                      validation: {
                                        required: "请输入验证码",
                                        minlength: "无效的短信验证码",
                                        maxlength: "无效的短信验证码"
                                      },
                                      password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 8 个字符",
                                        maxlength: "密码长度不能大于 16 个字符"
                                      },
                                      confirm_password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于8个字符",
                                        equalTo: "两次密码输入不一致"
                                      }
                                    },
                                    /*errorPlacement:function(error,element) {  
                                             if($(element).attr('name')=='validation'){
                                                 error.appendTo($('#ret-getting'));
                                             }else{
                                                 error.appendTo(element);
                                             }
                                    }*/
                                });
         
        $('#show_findpwd').click(function(){
            $('.signin').hide();
            $('.retrieve').show();
            $('#form-findpwd #input-find-mobile').keyup();
        });
        
        $('#form-findpwd #input-find-mobile').keyup(function(){
            if( $('#form-findpwd').validate().element($("#input-find-mobile")) ){
                $('#ret-getting').attr('disabled', false);
            }else{
                $('#ret-getting').attr('disabled', true);
            }
        });


        $('.auth-link').click(function(){
            var $type = $(this).attr('ng_href');
            var iTop = (window.screen.availHeight-30-520)/2;       //获得窗口的垂直位置;
            var iLeft = (window.screen.availWidth-10-650)/2;           //获得窗口的水平位置;
            newwin = window.open("/account/login/snsauth&type="+$type, "snswindow","width=650,height=520,top="+iTop+",left="+iLeft+",channelmode=yes,resizable=yes,scrollbars=yes,status=no");
        });
        
         //提交登录
        $('#form-signin').submit(function(){
               $('.text-danger').remove();
                try{
                 newwin.close();
               }catch(e){

               }
                if($(this).valid()){
                    var mobile = $('#input_mobile').val();
                    var pwd = $('#input_password').val();
                    $.ajax({
                          type:"POST",  
                          url:'/account/login/passport',
                          data:{'account':mobile, 'password':pwd}, 
                          dataType:'json',
                          beforeSend: function(){
                                $('#form-signin>.btn-login').button('loading');
                          },
                          complete: function(){
                              $('#form-signin>.btn-login').button('reset');
                          },
                          success: function(result){
                               if(result.code == 'ok'){ 
                                   window.location.href = result.href;
                               } else{
                                   $('#form-signin .btn-login').parent().after('<div class="text-danger">' + result.msg + '</div>');
                               }
                          }  
                  });
         }
            return false;
        });
        
         //找回密码－下一步
        $('#findpwd-wrap .btn-next').on('click', function(){
              $('#form-findpwd').valid();
              //验证
              var mobile = $('#input-find-mobile').val();
              var code = $('#ret-validation').val();
              if(mobile!='' && ismobile(mobile) && code!=''){
                    $.ajax({
                          type:"POST",  
                          url:'/account/login/findpwdctx',
                          data:{'mobile':mobile, 'smscode':code}, 
                          dataType:'json',
                          success: function(result){
                               if(result.code == 'ok'){ 
                                      $('#form-findpwd-first').hide();
                                      $('#form-findpwd-next').show();
                               } else{
                                   alert(result.msg);
                               }
                          }  
                  });
             }
        });
        
        //提交找回密码
        $('#form-findpwd').submit(function(){
              if($(this).valid()){
                var mobile = $('#input_mobile').val();
                var pwd = $('#new-password').val();
                 var smscode = $('#ret-validation').val();
                $.ajax({
                      type:"POST",  
                      url:'/account/login/findpwd',
                      data:{'account':mobile, 'password':pwd, 'smscode':smscode}, 
                      dataType:'json',
                      success: function(result){
                           if(result.code == 'ok'){ 
                               window.location.href = result.href;
                           } else{
                               if(result.code == 1001){
                                        $('#form-findpwd-next').hide();
                                        $('#form-findpwd-first').show();
                               }
                               alert(result.msg);
                           }
                      }  
              });
          }
            return false;
        });

});

//******************************** function *********************************//

function snsloginsucc(){
        var count =3;
        $('#login').hide();
        $('#prompt').show();
        var resend = setInterval(function(){
            if(count>0){
                $('#prompt .prompt-content>span').html(count);
            }
            count--;
            if (count ==2){
                window.location.href = '/account';
            }
            if (count <1){
                clearInterval(resend);
            }
    }, 1000);
}
 
 function ismobile(no){
     var length = no.length;
     var mobile = /(^13\d{9}$)|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17[6,7,8]\d{8}$)|(^18[0,1,2,5,6,7,8,9]\d{8}$)|(^14[5,7]\d{8}$)/g;
     return (length == 11 && mobile.exec(no))? true:false;
}