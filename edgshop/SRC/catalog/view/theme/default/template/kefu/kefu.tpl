<script>
    window.easemobim = window.easemobim || {};
    easemobim.config = {
        <?php if(isset($redirect)){ ?>
        onready: function () { 
               // window.location.href = '<?php echo $redirect; ?>';
               //alert('ffff');
        },
        <?php }else{ ?>
          visitor: {         //访客信息，以下参数支持变量
            companyName: 'EDG商城',
            trueName:'<?php echo $member_id; ?>',
            userNickname: '<?php echo $fullname; ?>',
            phone: '<?php echo $telephone; ?>'
        },
                <?php } ?>
            path:"//"+ location.host +"/assets/default/js/kefu-webim",
            autoConnect:false,
            /* dialogPosition: {
                x: 136,
                y: 300
            } */
    };
    function ifame_resize(){
            if($('iframe:last').width() < 150){
                $('iframe:last').width(150).height(136);
                $('iframe:last').css('bottom', 300);
            }else if($('iframe:last').width() > 300){
                <?php if(isset($redirect)){ ?>
                    window.location.href = '<?php echo $redirect; ?>';
                <?php } ?>
            }
    }
</script>
<script src='//kefu.easemob.com/webim/easemob.js?tenantId=19876&hide=false&sat=false' async='async'></script>
