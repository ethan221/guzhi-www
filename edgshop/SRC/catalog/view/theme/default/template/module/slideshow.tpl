<!--图片轮播 -->
<div id="imgcxside" class="slide_fade container">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <?php if($banners){ ?>
                    <!-- Indicators -->
                    <ol class="carousel-indicators" style="bottom: -39px;">
                        <?php for($i=0; $i<count($banners); $i++){ ?>
                        <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" <?php if($i==0){ ?>class="active" <?php } ?> ></li>
                      <?php } ?>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php foreach ($banners as $key => $banner) { ?>
                            <div class="item<?php if($key==0){ ?> active<?php } ?>">
                                  <?php if ($banner['link']) { ?>
                                      <a href="<?php echo $banner['link']; ?>">
                                          <img  alt="<?php echo $banner['title']; ?>"  src="<?php echo $banner['image']; ?>">
                                      </a>
                                  <?php }else{ ?>
                                      <img  alt="<?php echo $banner['title']; ?>"  src="<?php echo $banner['image']; ?>">
                                  <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
        </div>
</div>