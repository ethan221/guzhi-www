<?php echo $header; ?>
		<div id="login">
                                              <div class="signin">
		    	  <div class="signin-head"><p class="signin-title">用户登录</p></div>
                                                        <form class="form-signin" id="form-signin" role="form">
                                                                <input type="text" name="account" id="input_mobile" class="form-control" placeholder="请输入您的手机号码" autofocus />
                                                                <input type="password" autocomplete="off"  name="password" id="input_password"  class="form-control" placeholder="请输入您的密码" />
                                                                <p class="find-password" id="find-password"><a id="show_findpwd" href="javascript:;">忘记密码</a></p>
                                                                <div>
                                                                <a class="btn btn-login pull-left" href="<?php echo $register; ?>" type="button">注册EDG帐号</a>
                                                                <button class="btn btn-login pull-right" data-loading-text="正在登录" type="submit">登录</button>
                                                                <div style="clear: both;"></div>
                                                                </div>
                                                        </form>
                                                        <div class="quick-login pull-right">
                                                            <a class="auth-link weixin" ng_href="weixin" href="javascript:;"></a>
                                                            <a class="auth-link qq" ng_href="qq" href="javascript:;"></a>
                                                            <a class="auth-link weibo" ng_href="weibo" href="javascript:;"></a>
                                                        </div>
                                              </div>
                                              <div class="retrieve" id="findpwd-wrap" style="display: none;">
		    	<div class="signin-head"><p class="signin-title">忘记密码</p></div>
		    	<form class="form-signin" id="form-findpwd" role="form" method="post">
                                                                <div id="form-findpwd-first">
                                                                    <input type="text" name="account" id="input-find-mobile" autocomplete="off" maxlength="11"  class="form-control" placeholder="请输入需要找回密码的手机号码" autofocus />
		    		<div class="captcha-box">
				        <input type="text" autocomplete="off"  name="validation" id="ret-validation" class="form-control " maxlength="6" placeholder="请输入验证码">
                                                                                <input type="button" id="ret-getting" class="btn" disabled="disabled" style="border-radius: 0" value="获取验证码">
				    </div>
		    		<button class="btn btn-register btn-next" type="button">下一步</button>
                                                                </div>
                                                                <div id="form-findpwd-next" style="display: none;">
                                                                    <input type='password' autocomplete="off" name='password' id='new-password' maxlength="16" class='form-control' placeholder='请输入8~16位密码'/>
                                                                    <input type='password' autocomplete="off" name='confirm_password' maxlength="16"class='form-control' placeholder='请再次输入密码'/>
                                                                    <button class='btn btn-register btn-fndpwd-submit' type='submit'>提交</button>
                                                                </div>
		    	</form>
		         </div>
		</div>

           </div>
		
            <div id="prompt">
                <div class="prompt" >
                    <img src="assets/default/img/right-icon.png" class="right-icon">
                    <p class="prompt-content">您的第三方账号已经注册了EDG账号，登录成功<br>
正在进行跳转，倒计时 <span>3</span> 秒</p>
                </div>
            </div>

		<?php echo $footer; ?>
