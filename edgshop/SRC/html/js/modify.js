/* 
* @Author: nick
* @Date:   2016-04-07 14:58:44
* @Last Modified time: 2016-04-19 15:50:48
*/

$(document).ready(function(){

    function msg(){
        var msg = document.createElement("div");
        msg.className="error_msg";
        msg.style.html="我的错误！";
        $('.signin')[0].appendChild(msg);
    }
    
 
        
                $("#modify").validate({
                                    rules: {
                                      password_old: {
                                        required: true,
                                        minlength: 8,
                                        maxlength: 16
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
                                      }
                                     
                                    },
                                    messages: {
                                      password_old: {
                                        required: "请输入当前密码",
                                        minlength: "您输入的密码有误"
                                      },
                                      password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 8 个字母"
                                      },
                                      confirm_password: {
                                        required: "请输入密码",
                                        minlength: "密码长度不能小于 8 个字母",
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