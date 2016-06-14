<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
        <button type="submit" form="form-product-sku" data-toggle="tooltip" title="保存" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="取消" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?> </h3>
      </div>
      <div class="panel-body">
          <?php if($sku_data){ ?>
        <form action="" method="post"  id="form-product-sku">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                    <td class="text-center">序号</td>
                    <?php if(!empty($sku_data['option_titles'])){ ?>
                        <?php foreach($sku_data['option_titles'] as $key => $val){ ?>
                        <td class="text-center"><?php echo $val; ?></td>
                        <?php } ?>
                    <?php } ?>
                    <td class="text-center">商品编码(sku)</td>
                </tr>
              </thead>
              <tbody>
                  <?php if(!empty($sku_data['sku_list'])){ ?>
                  <?php foreach($sku_data['sku_list'] as $key => $item){ ?>
                  <tr>
                    <td><?php echo $key+1; ?></td>
                    <?php if(!empty($sku_data['option_titles'])){ ?>
                        <?php foreach($sku_data['option_titles'] as $key => $val){ ?>
                        <td class="text-center">
                        <?php if(isset($item['options'][$key])){ ?>
                            <?php 
                            if(!empty($item['options'][$key]['option_value_text'])){
                                echo $item['options'][$key]['option_value_text'];
                            }else{
                                echo $item['options'][$key]['value'];
                            }
                            ?>
                        <?php } ?>
                        </td>
                        <?php } ?>
                    <?php } ?>
                    <td class="text-center"><input maxlength="32" name="sku_id[<?php echo $item['product_sku_id']; ?>]" type="text" value="<?php echo $item['sku_sn']; ?>" class="form-control" autocomplete="off" style="width:200px; display: inline-block" /></td>
                 </tr>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
          <?php } ?>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--

//--></script></div>
<?php echo $footer; ?>