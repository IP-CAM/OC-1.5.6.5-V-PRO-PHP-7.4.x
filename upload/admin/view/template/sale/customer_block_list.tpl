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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a> <a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
	      <table class="list">
	        <thead>
	          <tr>
	            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
	            <td class="center" width="3%"><?php if ($sort == 'cb.customer_block_id') { ?>              
                <a href="<?php echo $sort_customer_block_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_block_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_customer_block_id; ?>"><?php echo $column_customer_block_id; ?></a>
                <?php } ?>                
                
	            </td>
				<td class="left" width="10%"><?php if ($sort == 'cb.block_type') { ?>                
                <a href="<?php echo $sort_block_type; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_block_type; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_block_type; ?>"><?php echo $column_block_type; ?></a>
                <?php } ?>                                
	            </td>
				      <td class="left" width="10%"><?php if ($sort == 'cb.block_value') { ?>                
                <a href="<?php echo $sort_block_value; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_block_value; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_block_value; ?>"><?php echo $column_block_value; ?></a>
                <?php } ?>                
	            </td>
				<td class="left"><?php if ($sort == 'cb.note') { ?>
                <a href="<?php echo $sort_note; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_note; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_note; ?>"><?php echo $column_note; ?></a>
                <?php } ?>                
	            </td>
				<td class="center" width="8%"><?php if ($sort == 'cb.date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?>                
	            </td>
				<td class="center" width="8%"><?php if ($sort == 'cb.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?>                
	            </td>
	            <td class="center" width="10%"><?php echo $column_action; ?></td>
	          </tr>
	        </thead>
	        <tbody>
	          <?php if ($customer_blocks) { ?>
	          <?php foreach ($customer_blocks as $customer_block) { ?>
	          <tr >
	            <td style="text-align: center;"><?php if ($customer_block['selected']) { ?>
	              <input type="checkbox" name="selected[]" value="<?php echo $customer_block['customer_block_id']; ?>" checked="checked" />
	              <?php } else { ?>
	              <input type="checkbox" name="selected[]" value="<?php echo $customer_block['customer_block_id']; ?>" />
	              <?php } ?>
				 </td>
				<td class="right"><?php echo $customer_block['customer_block_id']; ?></td>
				<td class="left">
					<?php
						switch($customer_block['block_type'])
						{
							case 'ip':
								echo 'IP Address';
								break;
							case 'email':
								echo 'Email';
								break;
						} // switch
					?>
				</td>
				<td class="left"><?php echo $customer_block['block_value']; ?></td>
				<td class="left"><?php echo $customer_block['note']; ?></td>
	            <td class="center"><?php echo $customer_block['date_added']; ?></td>
	            <td class="left"><?php echo $customer_block['status'] == 1 ? $text_enabled:$text_disabled; ?></td>
	            <td class="right"><?php foreach ($customer_block['action'] as $action) { ?>
	              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
	              <?php } ?></td>
	          </tr>
	          <?php } ?>
	          <?php } else { ?>
	          <tr>
	            <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
	          </tr>
	          <?php } ?>
	        </tbody>
	      </table>
	    </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
	<div class="box_2">
	<div class="heading_2">
       <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a> <a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
 	</div>
	</div>
  </div>
</div>

<?php echo $footer; ?> 