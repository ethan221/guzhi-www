<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>商城首页</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="css/my.css"/>
		<script src="js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="jquery.cookie.js" ></script>
		<script src="js/login.js" ></script>
		<link href="css/signin.css" rel="stylesheet">
	</head>
	<body>
		<header class="bgimg">
			<img src="img/banner1.png" class="center-block mgmid"/>
		</header>
		<div class="top">
                                             <div class="search-input">
                                                    <div class="flexsearch">
                                                                <div class="flexsearch--wrapper">
                                                                        <form class="flexsearch--form" action="#" method="post">
                                                                                <div class="flexsearch--input-wrapper" style="font-size: 12px;">
                                                                                        <input class="flexsearch--input" type="search" placeholder="搜索" style="">
                                                                                </div>
                                                                                <!--<input class="flexsearch--submit" type="submit" value="➜">-->
                                                                                <button class="flexsearch--submit" >
                                                                                        <span class="glyphicon glyphicon-search" aria-hidden="true" style=""></span>
                                                                                </button>
                                                                                <button id="dropdownMenu1" class="flexsearch--drop" data-toggle="dropdown">
                                                                                        所有类别
                                                                                </button>
                                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="right:0;left: inherit;">
                                                                                    <li><a href="#">Action</a></li>
                                                                                    <li><a href="#">Another action</a></li>
                                                                                    <li><a href="#">Something else here</a></li>
                                                                                    <li><a href="#">Separated link</a></li>
                                                                                </ul>
                                                                        </form>
                                                                </div>
                                                        </div>
                                            </div>
		</div>
		<div id="login">
		    <div class="signin">
		    	<div class="signin-head"><p class="signin-title">用户登录</p></div>
		    	<form class="form-signin" id="form-signin" role="form">
		    		<input type="text" name="account" class="form-control" placeholder="请输入您的手机号码" autofocus />
		    		<input type="password" name="password" class="form-control" placeholder="请输入您的密码" />
		            <p class="find-password">忘记密码</p>
		            <button class="btn btn-login pull-left" id="go-register" type="button">注册EDG帐号</button>
		    		<button class="btn btn-login pull-right" type="submit">登录</button>
		    	</form>
		        <div class="quick-login pull-right">
		            <a class="auth-link weixin" ng-href="https://api.weibo.com/oauth2/authorize?client_id=1772937595&amp;response_type=code&amp;redirect_uri=https://account.ele.me/auth/connect/weibo?redirect_url=http://www.ele.me" target="_blank" href="https://api.weibo.com/oauth2/authorize?client_id=1772937595&response_type=code&redirect_uri=https://account.ele.me/auth/connect/weibo?redirect_url=http://www.ele.me"></a>
		            <a class="auth-link qq" href="https://graph.qq.com/oauth2.0/authorize?client_id=101204453&response_type=code&scope=get_user_info&state=e215d9bc90ea76307f7aaf830b6cb351216e716b&redirect_uri=https://account.ele.me/auth/connect/qq?redirect_url=http://www.ele.me" target="_blank"></a>
		            <a class="auth-link weibo" ng-href="https://api.weibo.com/oauth2/authorize?client_id=1772937595&amp;response_type=code&amp;redirect_uri=https://account.ele.me/auth/connect/weibo?redirect_url=http://www.ele.me" target="_blank" href="https://api.weibo.com/oauth2/authorize?client_id=1772937595&response_type=code&redirect_uri=https://account.ele.me/auth/connect/weibo?redirect_url=http://www.ele.me"></a>
<!-- https://graph.qq.com/oauth/show?which=Login&display=pc&client_id=222222&response_type=token&scope=get_user_info&redirect_uri=http://qzonestyle.gtimg.cn/qzone/openapi/redirect.html -->
		        </div>
		    </div>
		</div>
		<div id="register">
		    <div class="register">
		    	<div class="signin-head"><p class="signin-title">注册</p></div>
		    	<form class="form-signin" id="form-register" role="form" method = "post">
		    		<input type="text" name="account" class="form-control" placeholder="请输入您的手机号码" autofocus />
		    		<div class="captcha-box">
				        <input type="text" name="validation" id="validation" class="form-control " maxlength="11" placeholder="请输入验证码">
				        <input type="button" id="getting" value="获取验证码">
				    </div>
		    		<input type="password" name="password" id="password" class="form-control" placeholder="请输入8~16位密码" />
		    		<input type="password" name="confirm_password" class="form-control" placeholder="请输入8~16位密码" />
		            <!-- <button class="btn btn-login pull-left" type="submit">注册EDG帐号</button> -->
		    		<button class="btn btn-login btn-register" type="submit">立即注册</button>
		    	</form>
		    </div>
		</div>
		<div id="retrieve">
		    <div class="retrieve">
		    	<div class="signin-head"><p class="signin-title">忘记密码</p></div>
		    	<form class="form-signin" id="form-register" role="form" method = "post">
		    		<input type="text" name="account" class="form-control" placeholder="请输入需要找回密码的手机号码" autofocus />
		    		<div class="captcha-box">
				        <input type="text" name="validation" id="ret-validation" class="form-control " maxlength="11" placeholder="请输入验证码">
				        <input type="button" id="ret-getting" value="获取验证码">
				    </div>
		    		<button class="btn btn-login btn-register" type="submit">下一步</button>
		    	</form>
		    </div>
		</div>
		<!-- <div id="retrieve">
		    <div class="retrieve">
		    	<div class="signin-head"><p class="signin-title">忘记密码</p></div>
		    	<form class="form-signin" id="form-register" role="form">
		    		<input type="password" name="password" id="password" class="form-control" placeholder="请输入8~16位密码" />
		    		<input type="password" name="confirm_password" class="form-control" placeholder="请输入8~16位密码" />
		    		<button class="btn btn-login btn-register" type="submit">提交</button>
		    	</form>
		    </div>
		</div> -->

		<div id="prompt">
		    <div class="prompt" >
		    	<img src="img/right-icon.png" class="right-icon">
		    	<p class="prompt-content">您的第三方账号已经注册了EDG账号，登录成功<br>
正在进行跳转，倒计时 <span>3</span> 秒</p>
		    </div>
		</div>

		<footer class="">
			<div class="container">
				<div class="row fuwu">
					<div class="col-md-3 mian">
						<p>满<strong>128</strong>元免运费</p>
					</div>
					<div class="col-md-3 zhen">
						<p><strong>EDG</strong>官方正品保证</p>
					</div>
					<div class="col-md-3 qi">
						<p><strong>7天</strong>无理由退换</p>
					</div>
					<div class="col-md-3 shun">
						<p><strong>顺丰</strong>快递服务</p>
					</div>
				</div>
				<div class="row">
					<div class="btm">
						<ul class="list-unstyled">
							<li><a href="#">购物指南</a></li>
							<li><a href="#">常见问题</a></li>
							<li><a href="#">注册登录</a></li>
							<li><a href="#">购买</a></li>
						</ul>
					</div>
					<div class="btm">
						<ul class="list-unstyled">
							<li><a href="#">配送与支持</a></li>
							<li><a href="#">配送方式</a></li>
							<li><a href="#">在线支付</a></li>
							<li><a href="#">快递信息</a></li>
						</ul>
					</div>
					<div class="btm">
						<ul class="list-unstyled">
							<li><a href="#">售后服务</a></li>
							<li><a href="#">售后政策</a></li>
							<li><a href="#">退款说明</a></li>
							<li><a href="#">返修/退换</a></li>
						</ul>
					</div>
					<div class="btm">
						<ul class="list-unstyled">
							<li><a href="#">会员中心</a></li>
							<li><a href="#">我的订单</a></li>
							<li><a href="#">我的服务</a></li>
							<li><a href="#">会员服务</a></li>
						</ul>
					</div>
					<div class="btm">
						<ul class="list-unstyled">
							<li><a href="#">联系我们</a></li>
							<li><a href="#">服务邮箱</a></li>
							<li><a href="#">热线电话</a></li>
							<li><a href="#">联系地址</a></li>
						</ul>
					</div>
				</div>
			</div>
			
		</footer>

		<div class="modal-wrap">
			<div class="hint">
				<img src="img/shut-icon.png" class="hint-shut">
				<div class="hint-in2">您的手机还没有注册EDG账号<br>
建议您马上去注册哦</div>
				<div class="hint-in1">
					<div class="hint2">马上注册</div>
				</div>
			</div>
		</div>

		<div class="modal-wrap" id="registed">
			<div class="hint">
				<img src="img/shut-icon.png" class="hint-shut">
				<div class="hint-in2">您的手机号码已经注册了EDG账号<br>
可以直接登录EDG商场</div>
				<div class="hint-in1">
					<div class="hint2">去登录</div>
				</div>
			</div>
		</div>
		
	</body>
</html>
