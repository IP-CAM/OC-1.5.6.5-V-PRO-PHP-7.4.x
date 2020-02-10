<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td><?php echo $entry_status; ?>
            <select name="filter_order_status_id">
              <option value="0"><?php echo $text_all_status; ?></option>
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td style="text-align: right;"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td style="min-width:30px;" class="center"><?php echo $column_orderid; ?></td>
            <td style="min-width:130px;" class="center"><?php echo $column_customer; ?></td>
			<td style="min-width:170px;" class="center"><?php echo $column_company; ?> + <?php echo $column_address; ?></td>
            <td style="min-width:120px;" class="center"><?php echo $column_email; ?></td>
            <td style="min-width:90px;" class="center"><?php echo $column_phone; ?></td>
            <td style="min-width:50px;" class="center"><?php echo $column_status; ?></td>
            <td style="min-width:220px;" class="left"><?php echo $column_pdtname; ?></td> 
            <td style="min-width:30px;" class="center"><?php echo $column_quantity; ?></td> 
            <td style="min-width:180px;" class="center"><?php echo $column_options; ?></td> 
            <td style="min-width:60px;" class="center"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($customers) { ?>
          <?php foreach ($customers as $customer) { ?>
          <tr>
            <td class="center"><?php echo $customer['order_id']; ?></td>
            <td class="center"><?php echo $customer['customer']; ?></td>
            <td class="left">
			<?php if ($customer['company']) { ?>
			<?php echo $customer['company']; ?><br />
			<?php } ?>
			<?php echo $customer['address']; ?><br/ ><?php echo $customer['postcode']; ?> <?php echo $customer['city']; ?><br /><?php echo $customer['state']; ?></td>
            <td class="center"><?php echo $customer['email']; ?></td>
            <td class="center"><?php echo $customer['telephone']; ?></td>
            <td class="center"><?php echo $customer['status']; ?></td>
            <td class="left"><?php echo $customer['pdtname']; ?></td>
            <td class="center"><?php echo $customer['quantity']; ?></td>
            <td class="center"><?php echo $customer['options']; ?></td>
            <td class="center"><a href="<?php echo $customer['href']; ?>" class="button"><span><?php echo $customer['text']; ?></span></a></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="12"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/newreport&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'dd-mm-yy'});
	
	$('#date-end').datepicker({dateFormat: 'dd-mm-yy'});
});
//--></script> 
<?php echo $footer; ?>