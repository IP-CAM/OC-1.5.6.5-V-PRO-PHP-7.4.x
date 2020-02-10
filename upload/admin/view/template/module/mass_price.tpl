<?php echo $header; ?>

<div id="content">

<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>

<?PHP if( !empty( $success ) ) { ?>
<div class="success"><?php echo $success; ?></div>
<?php }?>


<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
   <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
    <a onclick="addMode();" class="button"><span><?php echo $button_apply; ?></span></a>
    <a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
    <a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a>
    
    </div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
       

        <tr>
          <td><?php echo $entry_discount_rate; ?></td>
          <td>
          
          <select name="mass_sign">
                <?php if ($mass_sign) { ?>
                <option value="1" selected="selected">+</option>
                <option value="0">-</option>
                <?php } else { ?>
                <option value="1">+</option>
                <option value="0" selected="selected">-</option>
                <?php } ?>
              </select>
          
          
          <input type="text" name="mass_percent" value="<?php echo $mass_percent; ?>" size="1" /> %</td>
        </tr>
         <tr>
		 <tr>
              <td><?php echo $entry_category; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($category['category_id'], $product_category)) { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
            </tr>
          <td colspan="2"><?php echo $entry_discount_note; ?></td>
         </tr>
         
          <tr>
          <td><?php echo $entry_substract_stock; ?></td>
          <td>
          
          <select name="substract_stock">
                <?php if ($substract_stock==9) { ?>
                <option value="9" selected="selected"></option>
                <option value="1"><?php echo $entry_yes;?></option>
                <option value="0"><?php echo$entry_no;?></option>
                <?php } else if ($substract_stock==1) { ?>
                <option value="9"></option>
                <option value="1" selected="selected"><?php echo $entry_yes;?></option>
                <option value="0"><?php echo $entry_no;?></option>
                <?php } else { ?>
                <option value="9"></option>
                <option value="1"><?php echo $entry_yes;?></option>
                <option value="0" selected="selected"><?php echo $entry_no;?></option>
                <?php } ?>
              </select>
         </td>
        </tr>
        
         <tr>
          <td><?php echo $entry_date_available; ?></td>
          <td><input type="text" name="mass_date_available" value="<?php echo $mass_date_available; ?>" class="date"  />
          <input type="hidden" name="mass_percent_status" value="1">          </td>
        </tr> 
        <tr>
          <td><?php echo $entry_mass_quantity; ?></td>
          <td><input type="text" name="mass_quantity" value="<?php echo $mass_quantity; ?>" /></td>
        </tr> 
         <tr>
          <td><?php echo $entry_minimal_quantity;?></td>
          <td><input type="text" name="minimal_quantity" value="<?php echo $minimal_quantity; ?>" /></td>
        </tr> 
      </table>
    </form>
  </div>
</div>
</div>

<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});

function addMode() {
		$('#form').append('<input type="hidden" name="mode" value="apply" />');
		$('#form').submit();
	};
//--></script>
<?php echo $footer; ?>