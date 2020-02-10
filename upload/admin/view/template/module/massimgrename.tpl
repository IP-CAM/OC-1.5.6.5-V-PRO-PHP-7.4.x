<?php echo $header; 
 ?> 	
 <div id="loader" style="padding: 40px;">
<img src="view/image/loader.gif" /><br />
<div id="loader_txt">
Please wait. This may take a while...
 </div>
 </div>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if (isset($error_warning)) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  </div>

   <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
   <table class="form">
   <tr>
   <td>
         <label title= "<?php echo $entry_last_run; ?>" description="<?php echo $entry_last_run; ?>"> 
   <?php echo $entry_last_run; ?>
  </label>
   </td>
   <td>
    <input id="massimgrename_last_run" name="massimgrename_last_run" type="text" disabled="true" value="<?php echo $last_run;?>"> <input type="checkbox" value="reset" id="reset" name="reset"/> Reset
    </td>
    </tr>
   <tr>
   <tr>
   <td>
         <label title= "<?php echo $entry_massimgrename_max_product_req; ?>" description="<?php echo $entry_massimgrename_max_product_req; ?>"> 
   <?php echo $entry_massimgrename_max_product_req; ?>
  </label>
   </td>
   <td>
    <input type="text" name="massimgrename_max_product_req" value="<?php echo $massimgrename_max_product_req;?>">
    </td>
    </tr>
   <tr>
   <td>
       <label title= "<?php echo $entry_type_select_title; ?>" description="<?php echo $entry_type_select_description; ?>"> 
   <?php echo $entry_type_select; ?>
   
   </label>
   <td>
   <select name="massimgrename_mode" id="massimgrename_mode" >
        <?php if ($mode == $text_sku) { ?>
                  <option value="<?php echo $text_sku; ?>" selected="selected"><?php echo $text_sku; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $text_sku; ?>"><?php echo $text_sku; ?></option>
                  <?php } ?>
                  <?php if ($mode == $text_model) { ?>
                  <option value="<?php $text_model; ?>" selected="selected"><?php echo $text_model; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $text_model; ?>"><?php echo $text_model; ?></option>
                  <?php } ?>
        <?php if ($mode == $text_upc) { ?>
                  <option value="<?php $text_upc; ?>" selected="selected"><?php echo $text_upc; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $text_upc; ?>"><?php echo $text_upc; ?></option>
                  <?php } ?>
        <?php if ($mode == $text_ean) { ?>
                  <option value="<?php $text_ean; ?>" selected="selected"><?php echo $text_ean; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $text_ean; ?>"><?php echo $text_ean; ?></option>
                  <?php } ?>
        <?php if ($mode == $text_jan) { ?>
                  <option value="<?php $text_jan; ?>" selected="selected"><?php echo $text_jan; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $text_jan; ?>"><?php echo $text_jan; ?></option>
                  <?php } ?>
        <?php if ($mode == $text_mpn) { ?>
                  <option value="<?php $text_mpn; ?>" selected="selected"><?php echo $text_mpn; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $text_mpn; ?>"><?php echo $text_mpn; ?></option>
                  <?php } ?>
        <?php if ($mode == $text_isbn) { ?>
                  <option value="<?php $text_isbn; ?>" selected="selected"><?php echo $text_isbn; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $text_isbn; ?>"><?php echo $text_isbn; ?></option>
                  <?php } ?>
        <?php if ($mode == $text_title) { ?>
                  <option value="<?php $text_title; ?>" selected="selected"><?php echo $text_title; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $text_name; ?>"><?php echo $text_name; ?></option>
                  <?php } ?>
        </select>
   </td>
   </tr>
  </table>
     <div class="buttons" id="process_button"><a class="button" id="process" title="process" name="process"><span>Process </span></a></div>
    </form>
  </div>