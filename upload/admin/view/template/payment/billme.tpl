<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
    <h1 style="background-image: url('view/image/payment.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $entry_order_status; ?></td>
          <td><select name="billme_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $billme_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_allowed_groups; ?></td>
          <td>
            <div class="scrollbox">
              <?php $j=1; ?>
              <?php foreach ($customer_groups as $k => $v) { ?>
              <?php $name = $v['name']; ?>
              <?php $id = $v['customer_group_id']; ?>
              <?php if($j != 1) {$j = 1;}else{$j = 0;} ?>
              <?php if($j == 0) {$class = 'even';}elseif($j == 1){$class = 'odd';} ?>
              <div class="<?php echo $class;?>">
                <input type="checkbox" name="billme_allowed_groups[]" value="<?php echo $id; ?>" <?php echo (in_array($id, $billme_allowed_groups)) ? 'checked="checked"' : '' ?> />
                <?php echo $name;?>
              </div>
              <?php } ?>
            </div>
		  </td>
        </tr>
        <tr>
          <td><?php echo $entry_stock_status; ?></td>
          <td><select name="billme_stock_status_id">
              <?php foreach ($stock_statuses as $stock_status) { ?>
              <?php if ($stock_status['stock_status_id'] == $billme_stock_status_id) { ?>
              <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="billme_status">
              <?php if ($billme_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="billme_sort_order" value="<?php echo $billme_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>