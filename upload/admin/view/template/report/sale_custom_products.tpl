<?php echo $header; ?>
<style>select { width: 70%; clear: both; float: left; }</style>
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
      <table class="filter" width="100%" border=0>
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td valign="top"><span style="margin-top:30px;float:left;"><?php echo $entry_group; ?></span>
            <select name="filter_group">
              <?php foreach ($groups as $groups) { ?>
              <?php if ($groups['value'] == $filter_group) { ?>
              <option value="<?php echo $groups['value']; ?>" selected="selected"><?php echo $groups['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $groups['value']; ?>"><?php echo $groups['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td valign="top"><span style="margin-top:30px;float:left;"><?php echo $entry_status; ?></span>
            <select multiple name="filter_order_status_id">
              <option value="0"><?php echo $text_all_status; ?></option>
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ( in_array($order_status['order_status_id'],$filter_order_status_id) ) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td>&nbsp;
          </td>
          </tr><tr>
          <td><?php echo $entry_shipping_country_id; ?><br>
            <select multiple name="filter_shipping_country_id">
              <?php foreach ($delivery_countries as $delivery_country) { ?>
              <?php if (in_array($delivery_country['value'],$filter_shipping_country_id)) { ?>
              <option value="<?php echo $delivery_country['value']; ?>" selected="selected"><?php echo $delivery_country['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $delivery_country['value']; ?>"><?php echo $delivery_country['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td><?php echo $entry_payment_country_id; ?><br>
            <select multiple name="filter_payment_country_id">
              <?php foreach ($countries as $country) { ?>
              <?php if (in_array($country['value'],$filter_payment_country_id)) { ?>
              <option value="<?php echo $country['value']; ?>" selected="selected"><?php echo $country['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['value']; ?>"><?php echo $country['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td><?php echo $entry_shipping_zone_id; ?><br>
            <select multiple name="filter_shipping_zone_id">
              <?php foreach ($delivery_zones as $delivery_zone) { ?>
              <?php if (in_array($delivery_zone['value'],$filter_shipping_zone_id)) { ?>
              <option value="<?php echo $delivery_zone['value']; ?>" selected="selected"><?php echo $delivery_zone['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $delivery_zone['value']; ?>"><?php echo $delivery_zone['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td><?php echo $entry_payment_zone_id; ?><br>
            <select multiple name="filter_payment_zone_id">
              <?php foreach ($zones as $zone) { ?>
              <?php if (in_array($zone['value'],$filter_payment_zone_id)) { ?>
              <option value="<?php echo $zone['value']; ?>" selected="selected"><?php echo $zone['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $zone['value']; ?>"><?php echo $zone['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
       </tr>
       <tr>
          <td><?php echo $entry_customer_group_id; ?><br>
            <select multiple name="filter_customer_group_id">
              <?php foreach ($customer_groups as $customer_group) { ?>
              <?php if (in_array($customer_group['value'],$filter_customer_group_id)) { ?>
              <option value="<?php echo $customer_group['value']; ?>" selected="selected"><?php echo $customer_group['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $customer_group['value']; ?>"><?php echo $customer_group['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td><?php echo $entry_product_id; ?><br>
            <select multiple name="filter_product_id">
              <?php foreach ($products as $product) { ?>
              <?php if (in_array($product['value'],$filter_product_id)) { ?>
              <option value="<?php echo $product['value']; ?>" selected="selected"><?php echo $product['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $product['value']; ?>"><?php echo $product['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td><?php echo $entry_category_id; ?><br>
            <select multiple name="filter_category_id">
              <?php foreach ($categories as $category) { ?>
              <?php if (in_array($category['value'],$filter_category_id)) { ?>
              <option value="<?php echo $category['value']; ?>" selected="selected"><?php echo $category['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['value']; ?>"><?php echo $category['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </td>
          <td>&nbsp;
          </td>
          <td><a onclick="filter('export');" class="button"><span><?php echo $button_export; ?></span></a> </td>
          </tr>
          <tr>
          <td><?php echo $entry_total_min; ?>
            <input type="text" name="filter_total_min" value="<?php echo $filter_total_min; ?>" size="5" />
          </td>
          <td><?php echo $entry_total_max; ?>
            <input type="text" name="filter_total_max" value="<?php echo $filter_total_max; ?>" size="5" />
          </td>
          <td><?php echo $entry_reward_min; ?>
            <input type="text" name="filter_reward_min" value="<?php echo $filter_reward_min; ?>" size="5" />
          </td>
          <td><?php echo $entry_reward_max; ?>
            <input type="text" name="filter_reward_max" value="<?php echo $filter_reward_max; ?>" size="5" />
          </td>
          <td><?php echo $entry_debug_sql; ?><input type="checkbox" name="filter_debug_sql" value=1 <?php echo ($filter_debug_sql ? 'checked' : '' ); ?>></td>
        </tr>
      </table>
     <?php if ( !empty($debug_sql) ) print '<div><hr><pre>'.$debug_sql.'</pre></div>'; ?>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_date_start; ?></td>
            <td class="left"><?php echo $column_date_end; ?></td>
            <td class="right"><?php echo $column_products; ?></td>
            <td class="right"><?php echo $column_orders; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
            <td class="right"><?php echo $column_tax; ?></td>
            <td class="right"><?php echo $column_reward; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($orders) { ?>
          <?php foreach ($orders as $order) { ?>
          <tr>
            <td class="left"><?php echo $order['date_start']; ?></td>
            <td class="left"><?php echo $order['date_end']; ?></td>
            <td class="right"
            <?php if ( $filter_group != 'week' && 0 ) { # Yeah, fix this for extra feature but tell to nobody ?>
                    style="cursor:crosshair" onMouseover="showDetails('<?php echo $order['ds']; ?>','<?php echo $order['de']; ?>');"
             <?php } ?> >
            <?php echo $order['products']; ?>
            </td>
            <td class="right"><?php echo $order['orders']; ?></td>
            <td class="right"><?php echo $order['total']; ?></td>
            <td class="right"><?php echo $order['tax']; ?></td>
            <td class="right"><?php echo $order['reward']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
      <div id="products_details" style="margin-top:10px;"></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter(do_export) {

	url = 'index.php?route=report/sale_custom_products&token=<?php echo $token; ?>';
	
    ['date_start','date_end'].map( function(my_filter) {
        var my_val = $('input[name=\'filter_' + my_filter + '\']').val();
        if ( my_val ) { url += '&filter_' + my_filter + '=' + encodeURIComponent(my_val); }
    });
	
    ['total_min','total_max','reward_min','reward_max'].map( function(my_filter) {
        var my_val = $('input[name=\'filter_' + my_filter + '\']').val();
        if ( !isNaN(parseFloat(my_val)) && isFinite(my_val) ) { url += '&filter_' + my_filter + '=' + encodeURIComponent(my_val); }
    });

    ['group','order_status_id','shipping_country_id','payment_country_id','shipping_zone_id','payment_zone_id','customer_group_id','product_id','category_id'].map( function(my_filter) {
        var my_val = $('select[name=\'filter_' + my_filter + '\']').val();
        if (my_val) { url += '&filter_' + my_filter + '=' + encodeURIComponent(my_val); }
    });

    ['debug_sql'].map( function(my_filter) {
        if ( $('input[name="filter_' + my_filter + '"]').attr('checked')) { url += '&filter_' + my_filter + '=1'; }
    });

    if ( do_export ) { window.open(url+'&filter_export=1'); }
        
    location = url;
}

function showDetails(ds, de) {

    $.ajax({
        url: 'index.php' + location.search.replace(/sale_custom_products/i, 'sale_custom_products/details'),
        type: 'get',
        data: '&filter_ds=' + ds + '&filter_de='+de,
        dataType: 'json',
        success: function(json) {
            if (json['output']) { $('#products_details').html('<div id="products_details_data">'+json['output']+'</div>'); }
        }
    });
}

$("#products_details_data_close").click( function() { alert("#products_details_data"); } )

$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>
