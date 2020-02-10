<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
	  
	  <select name="filter_count_type">

                <?php if ($filter_count_type == 'orders') { ?>
					<option value="orders" selected="selected"><?php echo $select_orders; ?></option>
				<?php } else { ?>
					<option value="orders" ><?php echo $select_orders; ?></option>
				<?php } ?>
				<?php if ($filter_count_type == 'quantity') { ?>
					<option value="quantity" selected="selected"><?php echo $select_quantity; ?></option>
				<?php } else { ?>
					<option value="quantity" ><?php echo $select_quantity; ?></option>
				<?php } ?>
				<?php if ($filter_count_type == 'total') { ?>
					<option value="total" selected="selected"><?php echo $select_total; ?></option>
				<?php } else { ?>
					<option value="total" ><?php echo $select_total; ?></option>
				<?php } ?>

      </select>

	  <select name="filter_date_aggregation">

                <?php if ($filter_date_aggregation == 'day') { ?>
					<option value="day" selected="selected"><?php echo $select_day; ?></option>
				<?php } else { ?>
					<option value="day" ><?php echo $select_day; ?></option>
				<?php } ?>
				<?php if ($filter_date_aggregation == 'week') { ?>
					<option value="week" selected="selected"><?php echo $select_week; ?></option>
				<?php } else { ?>
					<option value="week" ><?php echo $select_week; ?></option>
				<?php } ?>
				<?php if ($filter_date_aggregation == 'month') { ?>
					<option value="month" selected="selected"><?php echo $select_month; ?></option>
				<?php } else { ?>
					<option value="month" ><?php echo $select_month; ?></option>
				<?php } ?>

      </select>

	  &nbsp<?php echo $select_no_of_records; ?>&nbsp<input size="5" type="text" name="filter_no_of_records" value="<?php echo $filter_no_of_records; ?>" />
	  
	  <a onclick="filter();" class="button"><?php echo $button_apply; ?></a>
	  <a onclick="window.print()" class="button"><?php echo $button_print; ?></a>
	  </div>
	  
	  
    </div>
    <div class="content">
      <table class="list">
        <thead>
          <?php if ($columns) { ?>
          <tr>
		  <td class="left"><?php echo $column_date; ?></td>
          <?php foreach ($columns as $name) { ?>
            <td class="left"><?php echo $name; ?></td>
          <?php } ?>
		  <td class="left"><?php echo $column_quantity; ?></td>
          </tr>
          <?php } ?>
        </thead>
        <tbody>
          <?php if ($data) { ?>
          <?php foreach ($data as $date => $statuses) { ?>
          <tr>
		  <td class="left" width=100><?php echo $date; ?></td>
          <?php foreach ($statuses as $status => $noOfStatuses) { ?>
            <td class="left"><?php echo $noOfStatuses; ?></td>
          <?php } ?>
		  <td class="left"><?php echo $total[$date]; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
		  </tbody>

         <thead>
         <?php if ($columns) { ?>
          <tr>
		  <td class="left"><?php echo $column_date; ?></td>
          <?php foreach ($columns as $name) { ?>
            <td class="left"><?php echo $name; ?></td>
          <?php } ?>
		  <td class="left"><?php echo $column_quantity; ?></td>
          </tr>
          <?php } ?>
         </thead>

      </table>
    </div>
	<div><?php echo $text_description; ?></div>
  </div>
</div>


<script type="text/javascript"><!--

function filter() {

	url = 'index.php?route=report/orders_statuses&token=<?php echo $token; ?>';

	var filter_date_aggregation = $('select[name=\'filter_date_aggregation\']').attr('value');

	if (filter_date_aggregation != '*') {
		url += '&filter_date_aggregation=' + encodeURIComponent(filter_date_aggregation);
	}	

	var filter_count_type = $('select[name=\'filter_count_type\']').attr('value');

	if (filter_count_type != '*') {
		url += '&filter_count_type=' + encodeURIComponent(filter_count_type);
	}	

	var filter_no_of_records = $('input[name=\'filter_no_of_records\']').attr('value');

	if (!isNaN(parseFloat(filter_no_of_records)) && isFinite(filter_no_of_records)) {
		url += '&filter_no_of_records=' + encodeURIComponent(filter_no_of_records);
	}	

	location = url;

}

//--></script>  

<script type="text/javascript"><!--

$('#form input').keydown(function(e) {

	if (e.keyCode == 13) {

		filter();

	}

});

//--></script> 



<?php echo $footer; ?>