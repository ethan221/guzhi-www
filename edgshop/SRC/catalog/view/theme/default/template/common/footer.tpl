<a href="#" title="回到顶部" class="scrollup text-center"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a>
		<footer class="">
			<div class="container">
				<div class="row fuwu">
					<div class="col-md-3 col-xs-3 col-lg-3 col-sm-3 mian">
						<p>满<strong>128</strong>元免运费</p>
					</div>
					<div class="col-md-3 col-xs-3 col-lg-3 col-sm-3 zhen">
						<p><strong>EDG</strong>官方正品保证</p>
					</div>
					<div class="col-md-3 col-xs-3 col-lg-3 col-sm-3 qi">
						<p><strong>7天</strong>无理由退换</p>
					</div>
					<div class="col-md-3 col-xs-3 col-lg-3 col-sm-3 shun">
						<p><strong>圆通</strong>快递服务</p>
					</div>
				</div>
				<div class="row">
                                                                                    <?php if($press_categories){ ?>
                                                                                    <?php foreach($press_categories as $item){ ?>

					<div class="btm">
						<ul class="list-unstyled">
                                                    <li style="color:#FFFFFF; font-style: bold;"><?php echo $item['name']; ?></li>
                                                                                                                              <?php if(isset($item['children'])){ ?>
                                                                                                                              <?php foreach($item['children'] as $children){ ?>
                                                                                                                              <li><a href="/press?press_id=<?php echo $children['press_id']; ?>"><?php echo $children['title']; ?></a></li>
							<?php } ?>
                                                                                                                              <?php } ?>
						</ul>
					</div>

                                                                                    <?php } ?>
                                                                                    <?php } ?>
				</div>
			</div>
			
		</footer>
<div id="iframe-wrap"></div>
</body>
        <script type="text/javascript">
            $(function(){
            	if($("body").height() < $(window).height()){   //判断有无SCROLL
		$("footer").addClass("has-scroll");
	}
                  <?php if($show_service){ ?>
                  $('#iframe-wrap').load('/kefu');
                  <?php } ?>
                  $('input,select,textarea').focus(function(){
                      //$('.text-danger').remove();
                    });
            });
            
            $(window).scroll(function () {
                if ($(this).scrollTop() > 300) {
                    $('.scrollup').fadeIn();
                } else {
                    $('.scrollup').fadeOut();
                }
            });
            $('.scrollup').click(function () {
                $("html, body").animate({
                    scrollTop: 0
                }, 600);
                return false;
            });
        </script>
</html>