<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /><?php echo $heading_title; ?></h1>  
    </div>
    <div class="content">

    <div style="background: #E7EFEF; border: 1px solid #C6D7D7; padding: 3px; margin-bottom: 15px;">
    <table width="100%">
      <tr>
        <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>        
        <td>
          <?php echo $text_sort_by; ?> <select name="sort" onchange="filter();">
            <option value="device_code" <?php echo($sort == "device_code" ? 'selected="selected"' : '' ); ?> ><?php echo $text_sort_device_key; ?></option>
            <option value="orders_total" <?php echo($sort == "orders_total" ? 'selected="selected"' : '' ); ?> ><?php echo $text_sort_orders_total; ?></option>
          </select>
        </td>
        <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
      </tr>
    </table>
    </div>

        <?php
        
        $counts_100 = $mobiles_counts + $computers_counts;
        $totals_100 = $mobiles_totals + $computers_totals;
        
        if ($counts_100 > 0) {
          $mobiles_cper   = number_format(($mobiles_counts   / $counts_100)*100, 2);
          $computers_cper = number_format(($computers_counts / $counts_100)*100, 2);
        } else {
          $mobiles_cper   = 0;
          $computers_cper = 0;
        }          
        
        if ($totals_100 > 0) {
          $mobiles_tper   = number_format(($mobiles_totals   / $totals_100)*100, 2);
          $computers_tper = number_format(($computers_totals / $totals_100)*100, 2);
        } else {
          $mobiles_tper   = 0;
          $computers_tper = 0;        
        }
        
        $mobiles_color   = "99ff99";
        $computers_color = "9999ff";
        
        ?>

        <div style="text-align:center; margin-top:10px; margin-bottom:20px; border:1px #eeeeee solid;">
        <?php                 
        $colors_img = $computers_color . "," . $mobiles_color;
        $labels_img = $text_device_computer . " [" . $computers_tper . "%]" . "|" . $text_device_mobile . " [" . $mobiles_tper . "%]"; 
        $values_img = $computers_tper . "," . $mobiles_tper; 
        ?>
        <img class="chart" src="http://chart.apis.google.com/chart?cht=p3&chco=<?php echo $colors_img; ?>&chd=t:<?php echo $values_img; ?>&chs=900x200&chl=<?php echo $labels_img; ?>" alt="chart" />
        </div>
        
        <?php
        
        if ($computers_orders) {
        
        echo "<div style='background:#$computers_color; padding:10px;'><strong>" . $text_device_computer . "</strong></div>";

          echo "<table class='list'>\n";
          echo "<thead>";
          echo "<tr>";
          echo "<td width='25%'>" . $column_device_name . "</td>";
          echo "<td width='25%'>" . $column_device_key . "</td>";          
          echo "<td width='25%' align='center'>" . $column_orders_count . "</td>";
          echo "<td width='25%' align='right' style='background:#$computers_color;'>" . $column_orders_total . "</td>";
          echo "</tr>";
          
          echo "</thead>";
          echo "<tbody>";
          foreach ($computers_orders as $device) {            
            echo "<tr>\n";
            echo "<td>" . $device['device_name'] . "</td>\n";
            echo "<td>" . $device['device_key'] . "</td>\n";
            echo "<td align='left'>" . '(' . $device['orders_count'] . ')' . 
              ( $show_orders_id_computers ? ' <span style="color:#999">ID: {' . $device['orders_id'] . '}</span>' : '' ) .
              "</td>\n";
            echo "<td align='right'>" . number_format($device['orders_total'], 2, ',', '.') . "</td>\n";
            echo "</tr>\n";
          }
          echo "<tr>\n";
          echo "<td style='background:#efefef'>" . $text_total . "</td>\n";
          echo "<td style='background:#efefef'></td>\n";
          echo "<td style='background:#efefef' align='center'>" . $computers_counts . " z " . $counts_100 . " = " . $computers_cper . "%</td>\n";
          echo "<td style='background:#efefef' align='right'>" . number_format($computers_totals, 2, ',', '.') . " z " . number_format($totals_100, 2, ',', '.') . " = " . $computers_tper . "%</td>\n";
          echo "</tr>\n";
          
          echo "</tbody>";
          echo "</table>\n";
          
        } // $computers_orders          

        if ($mobiles_orders) {
                
          echo "<div style='background:#$mobiles_color; padding:10px;'><strong>" . $text_device_mobile . "</strong></div>";
         
          echo "<table class='list'>\n";
          echo "<thead>";
          echo "<tr>";
          echo "<td width='25%'>" . $column_device_name . "</td>";
          echo "<td width='25%'>" . $column_device_key . "</td>";
          echo "<td width='25%' align='center'>" . $column_orders_count . "</td>";
          echo "<td width='25%' align='right' style='background:#$mobiles_color;'>" . $column_orders_total . "</td>";
          echo "</tr>";
          
          echo "</thead>";
          echo "<tbody>";
          foreach ($mobiles_orders as $device) {            
            echo "<tr>\n";
            echo "<td>" . $device['device_name'] . "</td>\n";
            echo "<td>" . $device['device_key'] . "</td>\n";            
            echo "<td align='left'>" . '(' . $device['orders_count'] . ')' . 
              ( $show_orders_id_mobiles ? ' <span style="color:#999">ID: {' . $device['orders_id'] . '}</span>' : '' ) .
              "</td>\n";
            echo "<td align='right'>" . number_format($device['orders_total'], 2, ',', '.') . "</td>\n";
            echo "</tr>\n";
          }
          echo "<tr>\n";
          echo "<td style='background:#efefef'>" . $text_total . "</td>\n";
          echo "<td style='background:#efefef'></td>\n";
          echo "<td style='background:#efefef' align='center'>" . $mobiles_counts . " z " . $counts_100 . " = " . $mobiles_cper . "%</td>\n";
          echo "<td style='background:#efefef' align='right'>" . number_format($mobiles_totals, 2, ',', '.') . " z " . number_format($totals_100, 2, ',', '.') . " = " . $mobiles_tper . "%</td>\n";
          echo "</tr>\n";
          
          echo "</tbody>";
          echo "</table>\n"; 
          
        } // $mobiles_orders 
         
        ?>

        <?php /*
        if ($unknowns_orders) {
        
        echo "<p><strong>" . $text_device_unknown . "</strong></p>";

          echo "<table class='list'>\n";
          echo "<thead>";
          echo "<tr>";
          echo "<td width='25%'>" . $column_device_name . "</td>";
          echo "<td width='25%'>" . $column_device_key . "</td>";          
          echo "<td width='25%' align='center'>" . $column_orders_count . "</td>";
          echo "<td width='25%' align='right'>" . $column_orders_total . "</td>";
          echo "</tr>";
          
          echo "</thead>";
          echo "<tbody>";
          foreach ($unknowns_orders as $device) {            
            echo "<tr>\n";
            echo "<td>" . $device['device_name'] . "</td>\n";
            echo "<td>" . $device['device_key'] . "</td>\n";            
            echo "<td align='center'>" . $device['orders_count'] . "</td>\n";
            echo "<td align='right'>" . number_format($device['orders_total'], 2, ',', '.') . "</td>\n";
            echo "</tr>\n";
          }
          echo "<tr>\n";
          echo "<td style='background:#efefef'>" . $text_total . "</td>\n";
          echo "<td style='background:#efefef'></td>\n";
          echo "<td style='background:#efefef' align='center'>" . $unknowns_counts . "</td>\n";
          echo "<td style='background:#efefef' align='right'>" . number_format($unknowns_totals, 2, ',', '.') . "</td>\n";
          echo "</tr>\n";
          
          echo "</tbody>";
          echo "</table>\n";
          
        } */         
        ?>         

    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/devices&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

  var sort = $('select[name=\'sort\']').attr('value');
	
	if (sort) {
		url += '&sort=' + encodeURIComponent(sort);
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