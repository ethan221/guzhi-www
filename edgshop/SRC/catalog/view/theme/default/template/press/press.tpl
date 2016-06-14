<?php echo $header; ?>
<!--个人中心-->
        <div id="person-center" class="container help-center">
                        <div class="left-menu" style="min-height: auto;">
                                <div class="top-bar">
                                        &nbsp;&nbsp;帮助中心&nbsp; <span>Help Infomation</span>
                                </div>
                                <div class="search">
                                        <form method="get" action="/press">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="keyword" value="<?php echo $keyword; ?>" placeholder="帮助信息搜索">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default btn-black" type="submit">搜索</button>
                                                </span>
                                            </div>
                                        </form>
                                </div>
                                <div class="dingdan">
                                    <?php if ($categories) { ?>
                                        <?php foreach ($categories as $category) { ?>
                                        <ul class="list-unstyled comment-style">
                                                <li><?php echo $category['name']; ?></li>
                                                <?php if ($category['children']) { ?>
                                                <?php foreach ($category['children'] as $children) { ?>
                                                <li <?php if($press_id ==  $children['press_id']){ ?>class="current"<?php } ?>><a href="/press?press_id=<?php echo $children['press_id']; ?><?php if($keyword!==''){ ?>&keyword=<?php echo $keyword; } ?>"><?php echo $children['title']; ?></a></li>
                                                <?php } ?>
                                                <?php } ?>
                                        </ul>
                                    <?php } ?>
                                <?php } ?>
                                </div>
                        </div>
                        <div class="right-content" style="min-height: 880px;">
                                <div class="main-content">
                                <?php echo $description; ?>
                                </div>
                        </div>
        </div>

<?php echo $footer; ?> 