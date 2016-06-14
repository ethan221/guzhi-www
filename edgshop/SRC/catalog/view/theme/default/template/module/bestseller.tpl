
<!--热卖商品 -->
<!--         <div id="newest" class="container">
                <div class="row">
                        <button class="btn btn-default center-block" style="width: 30%;">热卖商品</button>
                </div>
                <div class="new1">
                    <?php foreach ($products as $key=>$product) { ?>
                        <?php if($key==0 || $key==count($products)-1){ ?>
                        <div class="prodimg3 pull-left">
                                <a href="<?php echo $product['href']; ?>">
                                    <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                                </a>
                        </div>
                        <?php }else if($key%2!=0){ ?>
                                <div class="prodimg1 pull-left">
                                    <a class="img_1" href="<?php echo $product['href']; ?>">
                                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                                    </a>
                        <?php }else{ ?>
                                    <a class="img_1" href="<?php echo $product['href']; ?>">
                                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                                    </a>
                                </div>
                        <?php } ?>
                    <?php } ?>
                </div>
        </div>
-->

<div id="newest" class="container">
        <div class="">
                <img style="width: 100%;" src="<?php echo THEME_PATH; ?>img/newest/newarrive.jpg"/>
        </div>
        <div class="new1">
                <div class="prodimg3" style="float: left;">
                        <div class="prodimg1 pull-left">
                            <a class="img_2" target="_blank" href="javascript:;"><img src="<?php echo THEME_PATH; ?>img/newest/20160606/2/2_02.jpg" /></a>
                        </div>
                        <div class="prodimg1 pull-left">
                                <a class="img_2" target="_blank" href="/165.html"><img src="<?php echo THEME_PATH; ?>img/newest/20160606/2/2_04.jpg" /></a>
                        </div>
                </div>
                <div class="prodimg3" style="float: left;">
                        <div class="prodimg1 pull-left">
                                <a class="img_2" target="_blank" href="/223.html"><img src="<?php echo THEME_PATH; ?>img/newest/20160606/2/2_03.jpg" /></a>
                        </div>
                        <div class="prodimg1" style="float: left;">
                                <a class="img_3 pull-left" target="_blank" href="javascript:;"><img src="<?php echo THEME_PATH; ?>img/newest/20160606/2/2_05.jpg" /></a>
                                <a class="img_3 pull-left" target="_blank" href="/208.html"><img src="<?php echo THEME_PATH; ?>img/newest/20160606/2/2_06.jpg"  /></a>
                        </div>	
                </div>
        </div>
</div>
