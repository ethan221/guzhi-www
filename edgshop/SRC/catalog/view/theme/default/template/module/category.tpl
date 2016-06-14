<div class="left-menu caty-cent">
        <ul id="tree-cat">
              <li><a href="javascript:;">全部分类</a>
              </li>
              <?php foreach ($categories as $category) { ?>
              <li locahref="<?php echo $category['href']; ?>">
                 <a href="javascript:;" <?php if ($category['category_id'] == $child_id) { ?> class="current" <?php } ?>><?php echo $category['name']; ?></a>
                 <?php if ($category['children']) { ?>
                     <ul>
                     <?php foreach ($category['children'] as $child) { ?>
                     <li>
                             <?php if ($child['category_id'] == $child_id) { ?>
                                 <a href="<?php echo $child['href']; ?>" class="current"><?php echo $child['name']; ?></a>
                             <?php } else { ?>
                                 <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
                             <?php } ?>
                     <?php } ?>
                     </li>
                     </ul>
                <?php } ?>
             </li>
             <?php } ?>
         </ul>
</div>
<script type="text/javascript">
    $('#tree-cat').treed();
    $(function(){
        $("#tree-cat li").click(function(){
            if($(this).find("ul").length == 0){
                  if($(this).attr("locahref")!=undefined){
                        location.href = $(this).attr("locahref");
                  }
            }
        });
    });
    </script>