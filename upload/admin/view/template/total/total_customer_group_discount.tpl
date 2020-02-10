<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_discount; ?></td>
            <td>
            	<table class="form">
            		<?php foreach($customer_groups as $key => $group){ ?>
            		<tr>
            			<td><?php echo $group['name']; ?></td>
            			<td><input type="text" name="total_customer_group_discount_customer_group_id[<?php echo $group['customer_group_id']; ?>]" value="<?php echo $group['discount']; ?>">%</td>
            		</tr>
            		<?php } ?>
            	</table>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_special; ?></td>
            <td><select name="total_customer_group_discount_special">
                <?php if ($total_customer_group_discount_special) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_tax; ?></td>
            <td><select name="total_customer_group_discount_tax">
                <?php if ($total_customer_group_discount_tax) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_show; ?></td>
            <td><select name="total_customer_group_discount_show">
                <?php foreach ($total_customer_group_discount_show_vars as $key => $variant) { ?>
                <option value="<?php echo $key; ?>"<?php if($total_customer_group_discount_show == $key) echo "selected=\"selected\""; ?>><?php echo $variant; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="total_customer_group_discount_status">
                <?php if ($total_customer_group_discount_status) { ?>
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
            <td><input type="text" name="total_customer_group_discount_sort_order" value="<?php echo $total_customer_group_discount_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
	  <div style="margin-top:25px;border-top:1px dashed #ccc;padding-top:15px;text-align:center;"><? echo $text_help; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>