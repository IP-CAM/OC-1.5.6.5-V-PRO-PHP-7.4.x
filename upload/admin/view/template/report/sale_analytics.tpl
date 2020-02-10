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
         <td><?php echo $entry_date_end; ?>
                <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /><br/>
          </td>
          <td style="text-align: right;">
          <a onclick="filter();" class="button"><?php echo $button_filter; ?></a>
          </td>
        </tr>
    </table>
      </form>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_type; ?></td>
            <td class="left"><?php echo $column_value; ?></td>
		</thead>
        <tbody>
          <tr><td class="left"><?php echo $text_popular_day; ?></td>
			<td class="left">
				<?php 

        if(is_array($popularDay) && count($popularDay) > 0){
          echo date('D', strtotime($popularDay['date_placed'])).'<br/>';
          echo date($this->language->get('date_format_short'), strtotime($popularDay['date_placed'])).'('.$popularDay['order_placed'].')';
         }else{ 
          echo 'Not Available'; 
        }

        ?>
			</td>
		  </tr>
          <tr>
			<td class="left"><?php echo $text_popular_time; ?></td>
			<td class="left">
			 <?php 

       if(is_array($popularHour) && count($popularHour) > 0){
          echo $popularHour['time_placed'].' Hrs'.'('.$popularHour['order_placed'].')';
        }else{
          echo 'Not Available'; 
        }
			?> 
			
			</td>
		  </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=report/sale_analytics&token=<?php echo $token; ?>';
  
  var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
  
  if (filter_date_start) {
    url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
  }

  var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
  
  if (filter_date_end) {
    url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
  }
  
  location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
  $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
  $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php echo $footer; ?>