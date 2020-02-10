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
  <div class="box"><br/>
  
    <div class="left"></div>
    <div class="right"></div>
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	      <table class="form">
	        <tr>
	          <td><?php echo $entry_block_type; ?></td>
	          <td>
	          	<input type="hidden" id="customer_block_id" name="customer_block_id" value="<?php echo $customer_block_id;?>" />
				<select id="block_type" name="block_type">
					<option value="ip" <?php echo $block_type == 'ip'? 'selected="selected"': '';?>><?php echo $select_ip_address;?></option>
					<option value="email" <?php echo $block_type == 'email'? 'selected="selected"': '';?>><?php echo $select_email;?></option>
				</select>			          	
	          </td>
	        </tr>
	        <tr>
	          <td><?php echo $entry_block_value; ?></td>
	          <td>
				<input type="text" id="block_value" name="block_value" value="<?php echo $block_value;?>" /> &nbsp; <?php echo $text_your_ip_address; ?> <?php echo $_SERVER['REMOTE_ADDR'];?>
				<?php if ($error_block_value) { ?>
	            <span class="error"><?php echo $error_block_value; ?></span>
	            <?php } ?>          	
	          </td>
	        </tr>
	        <tr>
	          <td><?php echo $entry_note; ?></td>
	          <td>
	          	<textarea id="note" name="note" style="width:90%;height:200px;"><?php echo $note;?></textarea>
	          </td>
	        </tr>
	        <tr>
	          <td><?php echo $entry_status; ?></td>
	          <td><select name="status">
	              <?php if ($status) { ?>
	              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	              <option value="0"><?php echo $text_disabled; ?></option>
	              <?php } else { ?>
	              <option value="1"><?php echo $text_enabled; ?></option>
	              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	              <?php } ?>
	            </select></td>
	        </tr>
	        
	      </table>
	    </form>
    </div>
	<div class="box_2">
	<div class="heading_2">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  	</div>
	</div>
  </div>
</div>

<?php echo $footer; ?>