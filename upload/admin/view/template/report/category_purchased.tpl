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
      <form action="" method="post" enctype="multipart/form-data" id="form">
	  <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /><br/>
		 </td>
		  <td>
			<?php echo $entry_time_start; ?>	
			<input class="timeonly" type="text" value="<?php echo $filter_time_start; ?>" name="filter_time_start" id="time_start">
		  </td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /><br/>
		  </td>
		  <td>
			<?php echo $entry_time_end; ?>
			<input class="timeonly" type="text" value="<?php echo $filter_time_end; ?>" name="filter_time_end" id="time_end">	
		  </td>
          <td style="text-align: right;">
		    <a onclick="filter();" class="button"><?php echo $button_filter; ?></a>
		  </td>
        </tr>
	  </table>
	  </form>
      <table class="list" id="tbl_cus_purch">
        <thead>
          <tr>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="center"><?php echo $column_quantity; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($categories) { ?>
          <?php foreach ($categories as $category) { ?>
          <tr>
            <td class="left"><?php echo $category['name']; ?></td>
            <td class="center"><?php echo $category['quantity']; ?></td>
            <td class="right"><?php echo $category['total']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
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
	url = 'index.php?route=report/category_purchased&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_time_start = $('input[name=\'filter_time_start\']').attr('value');
	
	if (filter_time_start) {
		url += '&filter_time_start=' + encodeURIComponent(filter_time_start);
	}

	var filter_time_end = $('input[name=\'filter_time_end\']').attr('value');
	
	if (filter_time_end) {
		url += '&filter_time_end=' + encodeURIComponent(filter_time_end);
	}

	location = url;
}
//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#time_start').timepicker({
		hourMin: 8,
		hourMax: 21,
		timeFormat: "hh:mm tt"
	});
	
	$('#time_end').timepicker({
		hourMin: 8,
		hourMax: 21,
		timeFormat: "hh:mm tt"
	});
});

//--></script> 
<?php echo $footer; ?>