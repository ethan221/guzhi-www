<?php if ($reviews) { ?>
<div class="row comment-info">
    <?php foreach ($reviews as $review) { ?>
                <div class="col-md-10">
                        <div id="starBg" class="star_bg">
                            <?php $rating_arr = array('差', '较差', '普通', '较好', '好');  ?>
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <input type="radio" disabled="disabled"  id='starScore<?php echo $i; ?>' <?php if($review['rating'] == $i){ ?>checked="checked"<?php } ?> class="score score_<?php echo $i; ?>" value="<?php echo $i; ?>" />
                                <a href="javascript:;" class="star star_<?php echo $i; ?>" title="<?php echo $rating_arr[$i]; ?>"><label for="starScore<?php echo $i; ?>"><?php echo $rating_arr[$i]; ?></label></a>
                            <?php } ?>
                        </div>
                        <div class="comment-content"><?php $review['text']; ?></div>
                        <p class="fist-p">收货两天后评论</p>
                        <p><?php echo $review['date_added']; ?></p>
                        <p>枚红色 XL现货</p>
                </div>
                <div class="col-md-2 head-info-content">
                    <img class="center-block" src="<?php echo THEME_PATH; ?>/img/headicon.png" />
                        <span><?php echo $review['author']; ?></span>
                </div>
    <?php } ?>
        </div>
<div class="text-right"><?php echo $pagination; ?></div>
  <!-- <div class="foot-page">
                <nav class="">
                        <ul class="pagination" style="margin: 0;">
                        <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                        <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                        <li>
                                共4页，到第<input class="form-control" type="text" name="page"/>页 
                                <button class="btn btn-danger btn-sm">确认</button>
                                </li>
                     </ul>
                </nav>
        </div> -->
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
