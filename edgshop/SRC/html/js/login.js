/* 
* @Author: nick
* @Date:   2016-04-07 14:58:44
* @Last Modified time: 2016-04-15 16:29:35
*/

$(document).ready(function(){

    function msg(){
        var msg = document.createElement("div");
        msg.className="error_msg";
        msg.style.html="我的错误！";
        $('.signin')[0].appendChild(msg);
    }
    msg();
    if($.cookie("captcha")){
            var count = $.cookie("captcha");
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
                    $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
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
            var btn = $(this);
            var count = 60;
            var resend = setInterval(function(){
                count--;
                if (count > 0){
                    btn.val('重新获取'+count+'(s)');
                    $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
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
        });

        if($.cookie("ret-captcha")){
            var count = $.cookie("ret-captcha");
            var btn = $('#ret-getting');
            btn.val('重新获取'+count+'(s)').attr('disabled',true).css('cursor','not-allowed');
            var resend = setInterval(function(){
                count--;
                if (count > 0){
                    btn.val('重新获取'+count+'(s)').attr('disabled',true).css('cursor','not-allowed');
                    $.cookie("ret-captcha", count, {path: '/', expires: (1/86400)*count});
                    $('#ret-getting').css({
                      border: '#dfdfdf 1px solid',
                      background: '#b1b1b1'
                    });
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
            var btn = $(this);
            var count = 120;
            var resend = setInterval(function(){
                count--;
                if (count > 0){
                    btn.val('重新获取'+count+'(s)');
                    $.cookie("ret-captcha", count, {path: '/', expires: (1/86400)*count});
                }else {
                    clearInterval(resend);
                    console.info("*****sdsd*")
                    btn.val("获取验证码").removeAttr('disabled style');
                    $('#ret-getting').css({
                      border: '#cb0901 1px solid',
                      background: '#cb0901'
                    });
                }
            }, 1000);
            btn.attr('disabled',true).css('cursor','not-allowed');
            $('#ret-getting').css({
              border: '#dfdfdf 1px solid',
              background: '#b1b1b1'
            });
        });
 
                $("#form-signin").validate({
                                    rules: {
                                      account: {
                                        required: true,
                                        minlength: 11,
                                        maxlength: 11
                                      },
                                      password: {
                                        required: true,
                                        minlength: 8,
                                        maxlength: 16
                                      },
                                      confirm_password: {
                                        required: true,
                                        minlength: 5,
                                        equalTo: "#password"
                                      },
                                     
                                    },
                                    messages: {
                                      account: {
                                        required: "请输入用户名",
                                        minlength: "您输入的帐号有误"
                                      },
                                      password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 5 个字母"
                                      },
                                      confirm_password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 5 个字母",
                                        equalTo: "两次密码输入不一致"
                                      }
                                    }
                  });

                $("#form-register").validate({
                                    rules: {
                                      password: "required",
                                      account: {
                                        required: true,
                                        minlength: 11,
                                        maxlength: 11
                                      },
                                      validation: {
                                        required: true,
                                        minlength: 4,
                                        maxlength: 4
                                      },
                                      password: {
                                        required: true,
                                        minlength: 5
                                      },
                                      confirm_password: {
                                        required: true,
                                        minlength: 5,
                                        equalTo: "#password"
                                      },
                                    },
                                    messages: {
                                      lastname: "您输入的密码有误",
                                      account: {
                                        required: "请输入用户名",
                                        minlength: "您输入的帐号有误"
                                      },
                                      validation: {
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
                $("#form-retrieve").validate({
                                    rules: {
                                      account: {
                                        required: true,
                                        minlength: 11,
                                        maxlength: 11
                                      },
                                      validation: {
                                        required: true,
                                        minlength: 4,
                                        maxlength: 4
                                      },
                                      password: {
                                        required: true,
                                        minlength: 8,
                                        maxlength: 16
                                      },
                                      confirm_password: {
                                        required: true,
                                        minlength: 8,
                                        equalTo: "#password"
                                      },
                                     
                                    },
                                    messages: {
                                      account: {
                                        required: "请输入用户名",
                                        minlength: "您输入的帐号有误"
                                      },
                                      validation: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 5 个字母"
                                      },
                                      password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 5 个字母"
                                      },
                                      confirm_password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 5 个字母",
                                        equalTo: "两次密码输入不一致"
                                      }
                                    }
                                });
    $('.find-password').on('click',function(){
        $('#login').hide();
        $('#retrieve').show();
    });
    $('#go-register').on('click',function(){
        $('#login').hide();
        $('#register').show();
    });
    $('#register .btn-register').on('click',function(){
        $('#registed').show();
        $('#registed .hint2').click(function() {
           $('#registed').hide();
           $('#register').hide();
           $('#login').show();
        });
        $('#registed .hint-shut').click(function() {
           $('#registed').hide();
        });
        
    });
    // <div id="retrieve">
    //     <div class="retrieve">
    //       <div class="signin-head"><p class="signin-title">忘记密码</p></div>
    //       <form class="form-signin" id="form-register" role="form">
    //         <input type="password" name="password" id="password" class="form-control" placeholder="请输入8~16位密码" />
    //         <input type="password" name="confirm_password" class="form-control" placeholder="请输入8~16位密码" />
    //         <button class="btn btn-login btn-register" type="submit">提交</button>
    //       </form>
    //     </div>
    // </div> 
    // 加入验证码通过执行下面，现在只是先做效果
    $('#retrieve .btn-register').on('click',function(){
        if(true){
            $('.retrieve').children().remove();
            $('.retrieve').html("<div class='signin-head'><p class='signin-title'>忘记密码</p></div><form class='form-signin' id='form-register' role='form'><input type='password' name='password' id='password' class='form-control' placeholder='请输入8~16位密码'/><input type='password' name='confirm_password' id='password' class='form-control' placeholder='请输入8~16位密码'/><bttton class='btn btn-login btn-register' type='button'>提交</bttton></form>");
        }
    })
    
});