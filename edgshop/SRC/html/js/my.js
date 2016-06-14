$(function(){
	if($("body").height() < $(window).height()){//判断有无SCROLL
		$("footer").addClass("has-scroll");
	}
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
	$(".count-select button,#cart-content span.input-group-addon").click(function(){
		var t = $(this),
			tin = t.parent().find("input"),
			act = t.attr("act"),
			$pv = t.parent().parent().prev(),
			$pn = t.parent().parent().next();
		if(act == "minus"){
			if(tin.val() == 2) {
				t.prop("disabled",true);
			}
			tin.val(tin.val()-0-1 > 0 ? tin.val()-0-1 : 1);
			
		}
		if(act == "plus"){
			$(".count-select button").eq(0).prop("disabled",false);
			tin.val(tin.val()-0+1);
		}
		//$pn.text(tin.val()*($pv.text()-0));
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
    $('#tree-cat').treed();
    $("#tree-cat li.branch").click(function(){
    	if($(this).find("ul").length == 0){
    		location.href = $(this).attr("locahref");
    	}
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

	var linum = $('.mainlist li').length;//图片数量
	var w = linum * (162+18);//ul宽度
	$('.piclist').css('width', w + 'px');//ul宽度
	$('.swaplist').html($('.mainlist').html());//复制内容
	var move_distant = (162+18)*6;

	$('.og_next').click(function(){
		if($('.swaplist,.mainlist').is(':animated')){
			$('.swaplist,.mainlist').stop(true,true);
		}
		
		if($('.mainlist li').length>6){//多于6张图片
			var ml = parseInt($('.mainlist').css('left'));//默认图片ul位置
			var sl = parseInt($('.swaplist').css('left'));//交换图片ul位置
			if(ml<=0 && ml>w*-1){//默认图片显示时
				$('.swaplist').css({left: ml+w+'px'});//交换图片放在显示区域右侧
				$('.mainlist').animate({left: ml - move_distant + 'px'},'slow');//默认图片滚动	
				$('.swaplist').animate({left: ml+w - move_distant+'px'},'slow');//交换图片滚动
				
			}else{//交换图片显示时
				$('.mainlist').css({left: sl+w+'px'})//默认图片放在显示区域右
				$('.swaplist').animate({left: sl - move_distant + 'px'},'slow');//交换图片滚动
				$('.mainlist').animate({left: sl+w - move_distant+'px'},'slow');//默认图片滚动
			}
		}
	})
	$('.og_prev').click(function(){
		if($('.swaplist,.mainlist').is(':animated')){
			$('.swaplist,.mainlist').stop(true,true);
		}
		if($('.mainlist li').length>6){
			var ml = parseInt($('.mainlist').css('left'));
			var sl = parseInt($('.swaplist').css('left'));
			if(ml<=0 && ml>w*-1){
				$('.swaplist').css({left: ml-w+ 'px'});
				$('.mainlist').animate({left: ml + move_distant + 'px'},'slow');
				$('.swaplist').animate({left: ml-w + move_distant+'px'},'slow');
			}else{
				$('.mainlist').css({left: sl-w+'px'})
				$('.swaplist').animate({left: sl + move_distant + 'px'},'slow');
				$('.mainlist').animate({left: sl-w + move_distant+'px'},'slow');
			}
		}
	});
	$('.og_prev,.og_next').hover(function(){
			$(this).fadeTo('fast',1);
		},function(){
			$(this).fadeTo('fast',0.7);
	})
	$("#allSelect").click(function(){
		if($(this).prop("checked")){
			$("#cart-content tbody input[type=checkbox]").prop("checked",true);
		}else{
			$("#cart-content tbody input[type=checkbox]").prop("checked",false);
		}
	});
	$("#add-address").click(function () {
		var count = 0;
		if(count == 0){
			$('#nomoreadd').modal('show');
		}
	});
	$('#addaddress').modal('show');
	$(".invo-info").click(function(){
		if($("#reslut-info").css("display") == "none"){
			$("#reslut-info").show();
			$(this).find("span.glyphicon").removeClass("glyphicon-menu-down").addClass("glyphicon-menu-up");
		}else{
			$("#reslut-info").hide();
			$(this).find("span.glyphicon").addClass("glyphicon-menu-down").removeClass("glyphicon-menu-up");
		}
		
	});
	$("#egd-nav li>a,.navbar-header>a.hover-red").hover(function(index) {
		$(this).toggleClass("content-class");
		$(this).parent().prev().find("a").toggleClass("content-class");
		if($(this).text() == $("#egd-nav li>a").eq(0).text()){
			$(".navbar-header>a.hover-red").toggleClass("content-class");
		}
	},function (index) {
		$(this).toggleClass("content-class");
		$(this).parent().prev().find("a").toggleClass("content-class");
		if($(this).text() == $("#egd-nav li>a").eq(0).text()){
			$(".navbar-header>a.hover-red").toggleClass("content-class");
		}
	});
});
