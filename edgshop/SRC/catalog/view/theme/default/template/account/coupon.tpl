<?php echo $header; ?>
<!--个人中心-->
<div id="person-center" class="container">
            <?php echo $account_left; ?>
            <div class="right-content" id="account-right-content">
                <div class="top-bar">
						&nbsp;&nbsp;我的优惠券&nbsp; <span>My Coupon</span>
					</div>	
					

					<div class="main-content">
						<div class=" head-div">
							<div class="col-md-2 col-lg-2 col-xs-2 col-sm-2 text-center">名称</div>
							<div class="col-md-4 col-lg-4 col-xs-4 col-sm-4 text-center">优惠券号</div>
							<div class="col-md-2 col-lg-2 col-xs-2 col-sm-2 text-center">有效期</div>
							<div class="col-md-4 col-lg-4 col-xs-4 col-sm-4 text-center">使用状态</div>
						</div>
						<div class="body-div" id="comment-list">
                                                                                                    <?php foreach($coupons as $list){ ?>
							<div class="repeat">
								<div class="couponName pull-left  text-center"><p class="center-block">
                                                                                                                                            <?php echo $list['coupon_data']['name']; ?>
                                                                                                                                                </p></div>
								<div class="couponNum pull-left text-center"><p class="center-block">
                                                                                                                                                        <?php echo $list['coupon_data']['code']; ?>
                                                                                                                                                    </p>
                                                                                                                                                </div>
								<div class="couponDate pull-left  text-center"><p class="center-block"><?php echo $list['coupon_data']['date_end']; ?></p></div>
								<div class="couponStatu pull-left  text-center"><p class="center-block"><?php echo $list['status']; ?></p></div>
							</div>
						<?php } ?>
						</div>
					</div>
					<div class="foot-page">
                                            <?php echo $pagination; ?>
					</div>
                
                
                
            </div>
</div>
     
<?php echo $footer; ?>