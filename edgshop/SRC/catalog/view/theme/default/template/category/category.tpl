<?php echo $header; ?>
 <div id="person-center" class="container ">
            <?php echo $column_left; ?>
             <div class="right-top-content" >
                 <?php if($content_top){ ?>
                        <?php echo $content_top; ?>
                 <?php }else{ ?>
                    <div class="selected-conditoin" id="selected-conditoin">
                    <strong>
                            已选条件：
                    </strong>
                     </div>
                  <?php } ?>
             </div>
               <div class="right-buttom-content" style="margin-bottom: 50px;">
                <?php if ($products) { ?>
                    <?php foreach ($products as $product) { ?>
                            <div class="productions">
                                   <a target="_blank" href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                                   <?php if ($product['order']=='1') { ?>
                                    <span class="label label-success">NEW</span>
                                    <?php }else if ($product['status']=='1') { ?><span class="label label-danger">SALE</span><?php } ?>
                                    <a target="_blank" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                                   <p style="height: 60px;overflow: hidden;"><?php echo $product['description']; ?></p>
                                        <?php if ($product['price']) { ?>
                                            <?php if ($product['special']) { ?>
                                                 <?php if($product['price']>0){ ?><s><?php echo trim($product['price']); ?></s><?php } ?>
                                                 <?php echo $product['special']; ?>
                                            <?php }else{ ?>
                                                 <?php echo trim($product['price']); ?>
                                            <?php } ?>
                                        <?php } ?>
                           </div>

                    <?php } ?>
                <?php }else{ ?>
                        <p><?php echo $text_empty; ?></p>
                <?php } ?>
            </div>

    </div>
<?php echo $footer; ?>
