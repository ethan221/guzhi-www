 <div class="selected-conditoin" id="selected-conditoin">
        <strong>
                已选条件：
        </strong>
</div>
<div class="conditions" id='filter-panel'>
    <?php foreach ($filter_groups as $key=>$filter_group) { ?>
        <div id="filter-group-<?php echo $filter_group['filter_group_id']; ?>" style='height: 48px;margin: 0 18px;padding: 10px 0px;<?php if($key+1<sizeof($filter_groups)){ ?>border-bottom: 1px solid #CFCFCF;<?php } ?>'>
                <strong><?php echo $filter_group['name']; ?>：</strong>
                 <?php foreach ($filter_group['filter'] as $filter) { ?>
                 <label style="display: inline-block;width: auto;" id="filer-item-<?php echo $filter['filter_id']; ?>" for="input_filter_<?php echo $filter['filter_id']; ?>" _id="<?php echo $filter['filter_id']; ?>" class="cat-tag">
                        <?php echo $filter['name']; ?>
                        <input text="<?php echo $filter['name']; ?>" style='display:none;' <?php if (in_array($filter['filter_id'], $filter_category)) { ?>checked='checked'<?php } ?>  type="radio" id="input_filter_<?php echo $filter['filter_id']; ?>" name="filter[<?php echo $filter_group['filter_group_id']; ?>]" value="<?php echo $filter['filter_id']; ?>" />
                </label>
                 <?php } ?>
        </div>
    <?php } ?>
</div>

<script type="text/javascript"><!--
$('#filter-panel input[name^=\'filter\']').on('change', function() {
	filterinit(true);
});

$('#selected-conditoin').on( 'click', 'button', function() {
    var id=$(this).attr('value');
    $('#filter-panel input[id^=\'input_filter_'+id+'\']').attr('checked', false);
    $(this).remove();
    filterinit(true);
});


function filterinit(submit){
        filter = [];
        filterHtml = '';
        $('#filter-panel input[name^=\'filter\']:checked').each(function(element) {
                filter.push(this.value);
                filterHtml += '<button href="javascript:void(0);" value="'+$(this).val()+'" class="btn btn-labeled btn-black">' + $(this).attr('text') + '<span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span></button>   ';
        });
        if(filterHtml!=''){
            $('#selected-conditoin').html("<strong>已选条件：</strong>"+filterHtml);
        }
        if(submit==true){
            location = '<?php echo $action; ?>&filter=' + filter.join(',');
        }
}
filterinit(false);
//--></script> 
