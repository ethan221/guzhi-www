<div class="left-menu" id="account-left-menu">
        <div class="top-bar">
                &nbsp;&nbsp;会员中心&nbsp; <span>Member Center</span>
        </div>
        <div class="header-img">
            <img src="<?php echo THEME_PATH; ?>img/edg_logo.png" />
                <p class="text-center"><?php echo $text_account; ?></p>
        </div>
        <div class="dingdan">
                <ul class="list-unstyled comment-style">
                        <li>我的订单</li>
                        <li><a href="/account/order">全部订单</a></li>
                        <li><a href="/account/order?status=wait_pay">待付款</a></li>
                        <li><a href="/account/order?status=complete">已收货</a></li>
                        <li><a href="/account/order?status=cannel">已取消</a></li>
                </ul>
                <ul class="list-unstyled comment-style">
                        <li>评价管理</li>
                        <li ><a href="/account/comment?status=wait">待评价商品&nbsp;&nbsp;<span class="badge"><?php echo $comment_total; ?></span></a></li>
                        <li><a href="/account/comment?status=review">我的评价</a></li>
                </ul>
                <ul class="list-unstyled comment-style">
                        <li>个人信息</li>
                        <?php if(!$account_type){ ?>
                        <li><a href="/account/password">修改密码</a></li>
                        <?php } ?>
                        <li><a href="/account/address">收货地址</a></li>
                        <li><a href="/account/coupon">优惠券</a></li>
                </ul>
        </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function(){
    //$('#account-right-content').load('/account/order?status=all');
                $('#account-left-menu li>a').each(function(){
                    if(this.href == String(document.location)){
                        $('#account-left-menu .current').removeClass('current');
                        $(this).parent().addClass('current');
                        return;
                    }
                });
/*                if($('#account-left-menu .current').length<1){
                    location.href = '/account/order';
                }*/
});
</script>