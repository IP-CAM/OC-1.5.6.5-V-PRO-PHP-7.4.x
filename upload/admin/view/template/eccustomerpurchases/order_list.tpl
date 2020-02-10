
  <table class="list">
    <thead>
      <tr>
        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
        <td class="center"><?php if ($sort == 'o.order_id') { ?>
          <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
          <?php } else { ?>
          <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
          <?php } ?></td>
         <td class="center"><?php if ($sort == 'o.date_added') { ?>
          <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $this->language->get("column_purchases_on"); ?></a>
          <?php } else { ?>
          <a href="<?php echo $sort_date_added; ?>"><?php echo $this->language->get("column_purchases_on"); ?></a>
          <?php } ?></td>
        <td class="center"><?php if ($sort == 'op.model') { ?>
          <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $this->language->get("column_model"); ?></a>
          <?php } else { ?>
          <a href="<?php echo $sort_model; ?>"><?php echo $this->language->get("column_model"); ?></a>
          <?php } ?></td>
        <td class="center"><?php if ($sort == 'op.name') { ?>
          <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $this->language->get("column_product"); ?></a>
          <?php } else { ?>
          <a href="<?php echo $sort_name; ?>"><?php echo $this->language->get("column_product"); ?></a>
          <?php } ?></td>
        <td class="center"><?php if ($sort == 'op.quantity') { ?>
          <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $this->language->get("column_quantity"); ?></a>
          <?php } else { ?>
          <a href="<?php echo $sort_quantity; ?>"><?php echo $this->language->get("column_quantity"); ?></a>
          <?php } ?></td>
        <td class="center"><?php if ($sort == 'op.price') { ?>
          <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $this->language->get("column_price"); ?></a>
          <?php } else { ?>
          <a href="<?php echo $sort_price; ?>"><?php echo $this->language->get("column_price"); ?></a>
          <?php } ?></td>
        <td class="center"><?php if ($sort == 'op.total') { ?>
          <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $this->language->get("column_total"); ?></a>
          <?php } else { ?>
          <a href="<?php echo $sort_total; ?>"><?php echo $this->language->get("column_total"); ?></a>
          <?php } ?></td>
         <td class="center"><?php if ($sort == 'status') { ?>
          <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
          <?php } else { ?>
          <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
          <?php } ?></td>
        <td class="center"><?php echo $column_action; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr class="filter">
        <td></td>
        <td align="center"><input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" size="1" /></td>
        <td align="center"><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="6" class="date" /></td>
        <td align="center"><input type="text" name="filter_model" value="<?php echo $filter_model; ?>" size="10" /></td>
        <td align="center"><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" size="36" /></td>
        <td align="center"><input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" size="1" /></td>
        <td align="center"><input type="text" name="filter_price" value="<?php echo $filter_price; ?>" size="6" /></td>
        <td align="center"><input type="text" name="filter_total" value="<?php echo $filter_total; ?>" size="7" /></td>
        <td align="center"><select name="filter_order_status_id">
            <option value="*"></option>
            <?php if ($filter_order_status_id == '0') { ?>
            <option value="0" selected="selected"><?php echo $text_missing; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_missing; ?></option>
            <?php } ?>
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
        <td align="center"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
      </tr>
      <?php if ($orders) { ?>
      <?php foreach ($orders as $order) { ?>
      <tr>
        <td style="text-align: center;"><?php if ($order['selected']) { ?>
          <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
          <?php } ?></td>
        <td class="center"><?php echo $order['order_id']; ?></td>
        <td class="center"><?php echo $order['date_added']; ?></td>
        <td class="center"><?php echo $order['model']; ?></td>
        <td class="left"><a href="index.php?route=catalog/product/update&product_id=<?php echo isset($order['product_id'])?$order['product_id']:0; ?>&token=<?php echo $token; ?>" target="_BLANK"><?php echo $order['name']; ?></a></td>
        <td class="right"><?php echo $order['quantity']; ?></td>
        <td class="right"><?php echo $order['price']; ?></td>
        <td class="right"><?php echo $order['total']; ?></td>
        <td class="center"><?php echo $order['status']; ?></td>
        <td class="center"><?php foreach ($order['action'] as $action) { ?>
         <a class="button" href="<?php echo $action['href']; ?>" target="_BLANK"><?php echo $action['text']; ?></a> 
         <?php } ?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
<div class="pagination"><?php echo $pagination; ?></div>
<script type="text/javascript"><!--
$(document).ready(function(){
  $('#htabs a').click( function(){
    $.cookie("actived_tab", $(this).attr("href") );
  } );

  if( $.cookie("actived_tab") !="undefined" ){
    $('#htabs a').each( function(){
      if( $(this).attr("href") ==  $.cookie("actived_tab") ){
        $(this).click();
        return ;
      }
    } );
    
  }
})

//--></script>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=sale/customer/update&customer_id=<?php echo $customer_id; ?>&token=<?php echo $token; ?>';
  
  var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');
  
  if (filter_order_id) {
    url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
  }
  
  var filter_model = $('input[name=\'filter_model\']').attr('value');
  
  if (filter_model) {
    url += '&filter_model=' + encodeURIComponent(filter_model);
  }

  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var filter_price = $('input[name=\'filter_price\']').attr('value');
  
  if (filter_price) {
    url += '&filter_price=' + encodeURIComponent(filter_price);
  }

  var filter_quantity = $('input[name=\'filter_quantity\']').attr('value');
  
  if (filter_quantity) {
    url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
  }
  
  var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
  
  if (filter_order_status_id != '*') {
    url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
  } 

  var filter_total = $('input[name=\'filter_total\']').attr('value');

  if (filter_total) {
    url += '&filter_total=' + encodeURIComponent(filter_total);
  } 
  
  var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
  
  if (filter_date_added) {
    url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
  }
  
  location = url;
}
//--></script>  
<script type="text/javascript"><!--
$(document).ready(function() {
  $('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
  if (e.keyCode == 13) {
    filter();
  }
});
//--></script> 
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
  _renderMenu: function(ul, items) {
    var self = this, currentCategory = '';
    
    $.each(items, function(index, item) {
      if (item.category != currentCategory) {
        ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
        
        currentCategory = item.category;
      }
      
      self._renderItem(ul, item);
    });
  }
});

//--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {   
        response($.map(json, function(item) {
          return {
            label: item.name,
            value: item.product_id
          }
        }));
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'filter_name\']').val(ui.item.label);
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
//--></script>
<?php echo $footer; ?>