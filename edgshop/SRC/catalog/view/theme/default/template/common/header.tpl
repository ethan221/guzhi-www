<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<meta property="wb:webmaster" content="1119a2bc45a7adcc" />
<meta property="qc:admins" content="236147231165474515636" />
<META HTTP-EQUIV="pragma" CONTENT="no-cache"> 
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, no-store, must-revalidate">
<META HTTP-EQUIV="expires" CONTENT="0"> 
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="assets/default/css/bootstrap.min.css"/>
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="assets/default/js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="assets/default/js/BaseUtil.js" type="text/javascript"></script>
<script src="assets/default/js/common.js" type="text/javascript"></script>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<script src="assets/default/js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>
<script type="text/javascript">
            $(function(){
	$("#egd-nav li>a,.navbar-header>a.hover-red").hover(function(index) {
		$(this).toggleClass("content-class");
		$(this).parent().prev().find("a").toggleClass("content-class");
		if($(this).text() == $("#egd-nav li>a").eq(0).text()){
			$(".navbar-header>a.hover-red").toggleClass("content-class");
		}
	},function (index) {
		$(this).toggleClass("content-class");
		$(this).parent().prev().find("a").toggleClass("content-class");
		if($(this).text() == $("#egd-nav li>a").eq(0).text()){
			$(".navbar-header>a.hover-red").toggleClass("content-class");
		}
	});
            });
</script>
</head>
<body>
    <!-- 搜索 登录 购物车 -->
    <div class="search-login container">
        <div id="cart"  style="float: right;margin-right: 10px; ">
            <?php echo $cart; ?>
        </div>
        <a href="/" style="margin-left: 138px"><img src="assets/default/img/edg_shop.png"/></a>
                <?php echo $search; ?>
                <div class="log-reg" style="widht:auto">
            <?php if ($logged) { ?>
            <a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>&nbsp;&nbsp;丨&nbsp;&nbsp;<a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a>
            <?php } else { ?>
                <a class="btn btn-default btn-sm" href="<?php echo $login; ?>">登录</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-sm" href="<?php echo $register; ?>">注册</a>
            <?php } ?>
            
         </div>
</div>
    
    
<?php if ($categories) { ?>

<!-- navbar -->
            <nav class="navbar navbar-inverse rd0">
              <div class="container">
                <div class="navbar-header">
                  <a class="navbar-brand hover-red content-class" href="/">首页</a>
                </div>
                <div class="collapse navbar-collapse" id="egd-nav">
                  <ul class="nav navbar-nav"> 
                        <?php foreach ($categories as $key=>$category) { ?>
                        <li style="position: relative;"><a class="content-class" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                            <?php if($key==0){ ?>
                                     <div class="tooltip top" role="tooltip" >
                                        <div class="tooltip-arrow"></div>
                                        <div class="tooltip-inner">
                                          new
                                        </div>
                                      </div>
                            <?php } ?>
                        </li>
                        <?php } ?>
                  </ul>
                </div>
              </div>
            </nav>

<?php } ?>
<div class="breadcrumb" style="display: none"></div>