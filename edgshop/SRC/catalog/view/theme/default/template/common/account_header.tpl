<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title><?php echo $title; ?></title>
                                   <base href="<?php echo $base; ?>" />
                                   	<meta property="wb:webmaster" content="1119a2bc45a7adcc" />
		<meta property="qc:admins" content="236147231165474515636" />
                                    <?php if ($description) { ?>
                                    <meta name="description" content="<?php echo $description; ?>" />
                                    <?php } ?>
                                    <?php if ($keywords) { ?>
                                    <meta name="keywords" content= "<?php echo $keywords; ?>" />
                                    <?php } ?>
                                    <link rel="stylesheet" type="text/css" href="<?php echo THEME_PATH; ?>css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo THEME_PATH; ?>css/my.css"/>
                                    <?php foreach ($styles as $style) { ?>
                                    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
                                    <?php } ?>
                                    <script src="<?php echo THEME_PATH; ?>js/jquery/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo THEME_PATH; ?>js/bootstrap/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo THEME_PATH; ?>js/jquery/jquery.validate.min.js"></script>
                                    <script src="<?php echo THEME_PATH; ?>js/ValidateExtend.js"></script>
		<script src="<?php echo THEME_PATH; ?>js/jquery/jquery.cookie.js" ></script>
                                    <?php foreach ($links as $link) { ?>
                                    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
                                    <?php } ?>
                                    <?php foreach ($scripts as $script) { ?>
                                    <script src="<?php echo $script; ?>" type="text/javascript"></script>
                                    <?php } ?>
                                    <?php foreach ($analytics as $analytic) { ?>
                                    <?php echo $analytic; ?>
                                    <?php } ?>
	</head>
	<body>
		<!--
        	搜索 登录 购物车
        -->
		<div class="search-login container">
                    <a href="/" style="margin-left: 138px"><img src="<?php echo THEME_PATH; ?>img/edg_shop.png"/></a>
			<div class="search-input">
                            <div class="flexsearch" style="display: none;">
					<div class="flexsearch--wrapper">
						<form class="flexsearch--form" action="/search" method="post">
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
							<!--<ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="right:0;left: inherit;">
							     <li><a href="#">Action</a></li>
							    <li><a href="#">Another action</a></li>
							    <li><a href="#">Something else here</a></li>
							    <li><a href="#">Separated link</a></li> 
							</ul>-->
						</form>
					</div>
				</div>
                                                                </div>
                                             
		</div>