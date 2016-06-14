<?php echo $header; ?>
<!--个人中心-->
<div id="person-center" class="container">
            <?php echo $account_left; ?>
            <div class="right-content" id="account-right-content">

                <div class="top-bar">
                                &nbsp;&nbsp;未评价商品&nbsp; <span>Goods not evaluated</span>
                        </div>	
                        <div class="main-content">
                                <div class=" head-div">
                                                <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 text-center">商品名称</div>
                                                <div class="col-md-2 col-lg-2 col-xs-2 col-sm-2 text-center">购买时间</div>
                                                <div class="col-md-3 col-lg-3 col-xs-3 col-sm-3 text-center">操作</div>
                                </div> 
                                <div class="body-div" id="comment-list">
                                        <?php if(isset($comment_products)){ ?>
                                        <?php foreach($comment_products as $product){ ?>
                                        <div class="repeat">
                                                <table border="1" class="myList" width="100%">
                                                   <tbody><tr>
                                                     <td class="product-pic" style="width:45%;">
                                                                    <div>
                                                                        <?php echo $product['name']; ?>
                                                                        <?php if($product['options']){ ?>
                                                                            <?php foreach($product['options'] as $option){ ?>
                                                                                    <?php echo $option['name'].':'.$option['value']; ?>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    </div>
                                                                   <?php if($product['image']){ ?><img src="<?php echo $product['image']; ?>"/><?php } ?>
                                                     </td>
                                                     <td class="product-time"><?php echo $product['date_added']; ?></td>
                                                     <td class="product-choose"><button class="center-block btn btn-danger" _pid="<?php echo $product['product_id']; ?>" _opid="<?php echo $product['order_product_id']; ?>">马上评价</button></td>
                                                   </tr>
                                                 </tbody>
                                                </table>
                                        </div>
                                         <?php } ?>
                                         <?php } ?>
                                </div>
                        </div>

                        <div class="foot-page">
                               <?php echo $pagination; ?>
                        </div>

            </div>
</div>
     
<?php echo $footer; ?>

<script type="text/javascript"><!--
 $(document).ready(function(){
    $("#comment-list button.center-block").click(function(){
    	$("#comment-list .comment").remove();
    	var html = "",
    	$this = $(this);
                  $pid =  $(this).attr('_pid');
                  $opid = $(this).attr('_opid');
    	if($this.hasClass("btn-black")){
    		$this.removeClass("btn-black").addClass("btn-danger").text("马上评价");
    		return false;
    	}
    	$("#comment-list button.center-block").removeClass("btn-black").addClass("btn-danger").text("马上评价");
    	html += '<div class="comment" style="margin-top:-25px">';
		html += '	<p class="pingfen pull-left">评分：</p>';
		html += '	<div id="starBg" class="star_bg">';
		html += '	    <input type="radio" id="starScore1" class="score score_1" value="1" name="score">';
		html += '	    <a href="#starScore1" class="star star_1" title="差"><label for="starScore1">差</label></a>';
		html += '	    <input type="radio" id="starScore2" class="score score_2" value="2" name="score">';
		html += '	    <a href="#starScore2" class="star star_2" title="较差"><label for="starScore2">较差</label></a>';
		html += '	    <input type="radio" id="starScore3" class="score score_3" value="3" name="score">';
		html += '	    <a href="#starScore3" class="star star_3" title="普通"><label for="starScore3">普通</label></a>';
		html += '	    <input type="radio" id="starScore4" class="score score_4" value="4" name="score">';
		html += '	    <a href="#starScore4" class="star star_4" title="较好"><label for="starScore4">较好</label></a>';
		html += '	    <input type="radio" id="starScore5" class="score score_5" value="5" name="score">';
		html += '	    <a href="#5" class="star star_5" title="好"><label for="starScore5">好</label></a>';
		html += '	</div>';
		html += '	<div class="comment-text">';
		html += '		<textarea placeholder="是否喜欢我们的商品呢？赶快分享你们的购买心得吧" class="form-control comment-box"></textarea>';
		html += '		<span class="wordwrap">至少10个字符，可输入<var class="word">200</var>/200字</span>';
		html += '	</div>';
		html += '	<div id="pub-comment">';
		html += '		<button class="btn btn-danger pull-right btn-submit" onclick="addComment(this, '+ $opid +','+ $pid+');" data-loading-text="正在提交">发表评论</button>';
		html += '	</div>';
		html += '</div>';
		$this.parents(".repeat").after(html);
		$this.removeClass("btn-danger").addClass("btn-black").text("收起评价");
		//先选出 textarea 和 统计字数 dom 节点
	    var wordCount = $(".comment-text"),
	        textArea = wordCount.find("textarea"),
	        word = wordCount.find(".word");
	    //调用
	    BaseUtil.statInputNum(textArea,word);
	    $("#pub-comment button").click(function(){
	    	//$("#comment-list .comment").remove();
	    	//$this.addClass("btn-danger").removeClass("btn-black").text("马上评价");
	    });
    });

});
    //-->
    </script>
    
   <script type="text/javascript"><!-- 
        
    function addComment(btn, opid, pid){
             var buttonObj = $(btn);
             var box = $(btn).parent().parent();
             //var star = $(box).find(".star_bg input[type='radio']:checked").attr('value');
             var star = $(box).find(".star_bg input[type='radio']:checked").attr('value');
             var comment = $(box).find(".comment-box").val();
             if(star<1 || comment.length<10){
                 return false;
             }
             $.ajax({
                    url: '/account/comment/add',
                    type: 'post',
                    data: {'comment' : comment, 'star':star, 'pid' : pid, 'opid' : opid },
                    dataType: 'json',
                    beforeSend: function() {
                            $(buttonObj).button('loading');
                    },
                    complete: function() {
                            $(buttonObj).button('reset');
                    },
                    success: function(json) {
                            $('.alert, .text-danger').remove();
                            if (json['redirect']) {
                                    location = json['redirect'];
                            }
                            if (json['success']) {
                                    window.location.reload();
                            }
                            if(json['error']){
                                alert(json['error']);
                            }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
        
    }
    
        //-->
    </script>