$(function(){
	$('#imgcxside').cxSlide({
	  events: 'mouseover',
	  type: 'fade',
	  speed: 300
	});
	$('#allinone_thumbnailsBanner').allinone_thumbnailsBanner({
			skin: 'simple',
			numberOfThumbsPerScreen:5,
			width: 420,
			height: 508,
			thumbsReflection:0,
			defaultEffect: 'fade',
			showNavArrows:0,
			absUrl:"../",
			autoPlay:0,
			showCircleTimer:false
		});
	$(".allinone_thumbnailsBanner").imagezoom();
	$(".stripe").hover(function(){
		$(".allinone_thumbnailsBanner").hover();
	});
	/*
	 * 购物数量加减
	 */
	$(".count-select button").click(function(){
		var t = $(this),
			tin = $(".count-select input"),
			act = t.attr("act");
		if(act == "minus"){
			if(tin.val() == 2) {
				t.prop("disabled",true);
			}
			tin.val(tin.val()-0-1);
		}
		if(act == "plus"){
			$(".count-select button").eq(0).prop("disabled",false);
			tin.val(tin.val()-0+1);
		}
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
    
    /*
    * 剩余字数统计
    * 注意 最大字数只需要在放数字的节点哪里直接写好即可 如：<var class="word">200</var>
    */
    function statInputNum(textArea,numItem) {
        var max = numItem.text(),
            curLength;
        textArea[0].setAttribute("maxlength", max);
        curLength = textArea.val().length;
        numItem.text(max - curLength);
        textArea.on('input propertychange', function () {
            numItem.text(max - $(this).val().length);
        });
    }
    
    $("#comment-list button.center-block").click(function(){
    	$("#comment-list .comment").remove();
    	var html = "",
    		$this = $(this);
    	if($this.hasClass("btn-black")){
    		$this.removeClass("btn-black").addClass("btn-danger").text("马上评价");
    		return false;
    	}
    	$("#comment-list button.center-block").removeClass("btn-black").addClass("btn-danger").text("马上评价");
    	html += '<div class="comment">';
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
		html += '		<textarea placeholder="是否喜欢我们的商品呢？赶快分享你们的购买心得吧" class="form-control"></textarea>';
		html += '		<span class="wordwrap">可输入<var class="word">200</var>/200字</span>';
		html += '	</div>';
		html += '	<div id="pub-comment">';
		html += '		<button class="btn btn-danger pull-right">发表评论</button>';
		html += '	</div>';
		html += '</div>';
		$this.parents(".repeat").after(html);
		$this.removeClass("btn-danger").addClass("btn-black").text("收起评价");
		//先选出 textarea 和 统计字数 dom 节点
	    var wordCount = $(".comment-text"),
	        textArea = wordCount.find("textarea"),
	        word = wordCount.find(".word");
	    //调用
	    statInputNum(textArea,word);
	    $("#pub-comment button").click(function(){
	    	$("#comment-list .comment").remove();
	    	$this.addClass("btn-danger").removeClass("btn-black").text("马上评价");
	    });
    });

	$('#tree-cat').treed();

    $('.addReceipt').click(function(){
        // $('.Address').show();
        alert('ninaa ');

    });

    $('.Address .btn-add').click(function(){
        $('.Address').hide();
        var address_list = document.createElement("div");
        address_list.className="repeat";
        address_list.innerHTML="<div class='receiptP pull-left  text-center'><p class='center-block'>陈先生</p></div><div class='receiptAdd pull-left text-center'><p class='center-block'>广东省广州市海珠区赤岗北路瑞福大厦613-615房</p></div><div class='im-discuss pull-left  text-center'><p class='center-block'>15820202020</p></div><div class='receiptOperate pull-left  text-center'><span class='span-center'>编辑</span><span  class='span-center'>|</span><span  class='span-center'>删除</span><span class='btn btn-danger default span-center'>设为默认</span></div> ";
        $('#comment-list')[0].appendChild(address_list);
    });


// <div class="repeat">
//     <div class="receiptP pull-left  text-center"><p class="center-block">陈先生</p></div>
//     <div class="receiptAdd pull-left text-center"><p class="center-block">广东省广州市海珠区赤岗北路瑞福大厦613-615房</p></div>
//     <div class="im-discuss pull-left  text-center"><p class="center-block">15820202020</p></div>
//     <div class="receiptOperate pull-left  text-center"><span class="span-center">编辑</span><span  class="span-center">|</span><span  class="span-center">删除</span><span class="btn btn-danger default span-center">设为默认</span></div>
// </div>

});
