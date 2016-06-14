<?php echo $header; ?>
		<div id="register">
		    <div class="register">
		    	<div class="signin-head"><p class="signin-title">注册</p></div>
                        <form action="" class="form-signin" id="form-register" role="form" method="post">
		    		<input type="text" id="input_mobile" name="account" class="form-control" placeholder="请输入您的手机号码" autofocus />
		    		<div class="captcha-box">
				        <input type="text" maxlength="6"  name="smscode" id="validation" class="form-control " maxlength="6" placeholder="请输入验证码">
                                        <input type="button" disabled="disabled" class="btn" style="border-radius: 0" id="getting" value="获取验证码">
				    </div>
                                                                        <input type="password" maxlength="16" name="password" id="password" class="form-control" placeholder="请输入8~16位密码" />
		    		<input type="password" name="confirm_password" class="form-control" placeholder="请输入8~16位密码" />
		            <!-- <button class="btn btn-login pull-left" type="submit">注册EDG帐号</button> -->
                            <div>
		    		<button class="btn btn-login btn-register" type="submit">立即注册</button>
                            </div>
		    	</form>
		    </div>
		</div>

		<div id="prompt">
		    <div class="prompt" >
		    	<img src="assets/default/img/right-icon.png" class="right-icon">
		    	<p class="prompt-content">您的第三方账号已经注册了EDG账号，登录成功<br>
正在进行跳转，倒计时 <span>3</span> 秒</p>
		    </div>
		</div>

		<div class="modal-wrap">
			<div class="hint">
				<img src="assets/default/img/shut-icon.png" class="hint-shut">
				<div class="hint-in2">您的手机还没有注册EDG账号<br>
建议您马上去注册哦</div>
				<div class="hint-in1">
					<div class="hint2">马上注册</div>
				</div>
			</div>
		</div>

		<div class="modal-wrap" id="registed">
			<div class="hint">
				<img src="assets/default/img/shut-icon.png" class="hint-shut">
				<div class="hint-in2">您的手机号码已经注册了EDG账号<br>
可以直接登录EDG商场</div>
				<div class="hint-in1">
					<div class="hint2">去登录</div>
				</div>
			</div>
		</div>

<?php echo $footer; ?>