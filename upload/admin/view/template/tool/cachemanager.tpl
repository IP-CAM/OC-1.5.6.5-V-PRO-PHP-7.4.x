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
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
	<h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
	 <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
  </div>
  <div class="content">
   <div id="tabs" class="htabs">
   <a href="#tab-settings"><?php echo $tab_settings; ?></a>
   <a href="#tab-clean"><?php echo $tab_clean; ?></a>
   <a href="#tab-filelist"><?php echo $tab_filelist; ?></a>
   </div>
    <div id="tab-settings">
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

		<div style="float:left;">
		<span>
		 <?php echo $entry_gzip; ?>
		</span>
		<span>
		<select name="gzip">
         		<?php 	for ($i = 0; $i <= 9; $i++) { ?>
				     <?php if ($gzip == $i) { ?>
						<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
					  <?php } else { ?>	
					    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					  <?php } ?>
				<?php	} ?>
	    </select>
		</span>	  
		</div>
		<div style="float:right;" class="buttons"><a href="<?php echo $clearsystemcache; ?>" class="button"><?php echo $button_clearsystemcache; ?></a></div>
	<br /><br /><br />
        <table class="list">
	<thead>		
	<tr>
	 <td class="left"><?php echo $text_type; ?></td>
	 <td class="left"><?php echo $text_status; ?></td>
	 <td class="left"><?php echo $text_lifetime; ?></td>
	 <td class="left"><?php echo $text_flush; ?></td>
	 <td class="left"><?php echo $text_size; ?></td>
	</tr>
	</thead>		
	<tbody>	
	 <tr>
	 <td class="left"><?php echo $entry_menu; ?></td>
	 <td class="left"><select name="cache[menu][status]">
                <?php if ($cache['menu']['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
	</td>
	<td class="left"><input size="2" name="cache[menu][lifetime]" value="<?php echo $cache['menu']['lifetime']; ?>"></td>
	 <td class="left"><a href="<?php echo $clear_menu; ?>" class="button"><?php echo $button_clear; ?></a></td>
	 <td class="left"><?php echo $cache['menu']['size']; ?></td>
	</tr>
	<tr>
	 <td class="left"><?php echo $entry_category; ?></td>
	 <td class="left"><select name="cache[categorymodule][status]">
	                <?php if ($cache['categorymodule']['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
	</td>
	<td class="left"><input size="2" name="cache[categorymodule][lifetime]" value="<?php echo $cache['categorymodule']['lifetime']; ?>"></td>
	 <td class="left"><a href="<?php echo $clear_categorymodule; ?>" class="button"><?php echo $button_clear; ?></a></td>
	 <td class="left"><?php echo $cache['categorymodule']['size']; ?></td>
	</tr>
	
	<tr>
	 <td class="left"><?php echo $entry_featured; ?></td>
	 <td class="left"><select name="cache[featuredmodule][status]" disabled>
                <option value="0"><?php echo $text_disabled; ?></option>
              </select>
	</td>
	<td class="left"><input size="2" name="cache[featuredmodule][lifetime]" value="3600" disabled></td>
	 <td class="left"><a href="<?php echo $clear_featuredmodule; ?>" style="background: #999999;" class="button"><?php echo $button_clear; ?></a></td>
	 <td class="left"><?php echo $cache['featuredmodule']['size']; ?></td>
	</tr>
	
	<tr>
	 <td class="left"><?php echo $entry_bestseller; ?></td>
	 <td class="left"><select name="cache[bestsellermodule][status]" disabled>
                <option value="0"><?php echo $text_disabled; ?></option>
              </select>
	</td>
	<td class="left"><input size="2" name="cache[bestsellermodule][lifetime]" value="3600" disabled></td>
	 <td class="left"><a href="<?php echo $clear_bestsellermodule; ?>" style="background: #999999;" class="button"><?php echo $button_clear; ?></a></td>
	 <td class="left"><?php echo $cache['bestsellermodule']['size']; ?></td>
	</tr>
	
	<tr>
	 <td class="left"><?php echo $entry_latest; ?></td>
	 <td class="left"><select name="cache[latestmodule][status]" disabled>
                <option value="0"><?php echo $text_disabled; ?></option>
              </select>
	</td>
	<td class="left"><input size="2" name="cache[latestmodule][lifetime]" value="3600" disabled></td>
	 <td class="left"><a href="<?php echo $clear_latestmodule; ?>" style="background: #999999;" class="button"><?php echo $button_clear; ?></a></td>
	 <td class="left"><?php echo $cache['latestmodule']['size']; ?></td>
	</tr>	
	
	<tr>
	 <td class="left"><?php echo $entry_special; ?></td>
	 <td class="left"><select name="cache[specialmodule][status]" disabled>
                <option value="0"><?php echo $text_disabled; ?></option>
              </select>
	</td>
	<td class="left"><input size="2" name="cache[specialmodule][lifetime]" value="3600" disabled></td>
	  <td class="left"><a href="<?php echo $clear_specialmodule; ?>" style="background: #999999;" class="button"><?php echo $button_clear; ?></a></td>
	 <td class="left"><?php echo $cache['specialmodule']['size']; ?></td>
	</tr>
	
	<tr>
	 <td class="left"><?php echo $entry_productcategory; ?></td>
	 <td class="left"><select name="cache[productcategory][status]" disabled>
                <option value="0"><?php echo $text_disabled; ?></option>
              </select>
	</td>
	<td class="left"><input size="2" name="cache[productcategory][lifetime]" value="3600" disabled></td>
	  <td class="left"><a href="<?php echo $clear_productcategory; ?>" style="background: #999999;" class="button"><?php echo $button_clear; ?></a></td>
	 <td class="left"><?php echo $cache['productcategory']['size']; ?></td>
	</tr>	
	
	<tr>
	 <td class="left"><?php echo $entry_productmanufacturer; ?></td>
	 <td class="left"><select name="cache[productmanufacturer][status]" disabled>
                <option value="0"><?php echo $text_disabled; ?></option>
              </select>
	</td>
	<td class="left"><input size="2" name="cache[productmanufacturer][lifetime]" value="3600" disabled> </td>
	  <td class="left"><a href="<?php echo $clear_productmanufacturer; ?>" style="background: #999999;" class="button"><?php echo $button_clear; ?></a></td>
	 <td class="left"><?php echo $cache['productmanufacturer']['size']; ?></td>
	</tr>
	
	</tbody>
	</table>
   </form>
	 
    </div><!--End tab settings -->
   <div id="tab-clean">
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_description; ?></td>
			<td class="left"><?php echo $column_action;?></td>
   		</tr>
        </thead>
        <tbody>
          <tr>
            <td class="left"><?php echo $image_description; ?></td>
			<td class="left"><div class="buttons"><a href="<?php echo $clearcache; ?>" class="button"><?php echo $button_clearcache; ?></a></div></td>
   		</tr>
		<tr>
            <td class="left"><?php echo $system_description; ?></td>
			<td class="left"><div class="buttons"><a href="<?php echo $clearsystemcache; ?>" class="button"><?php echo $button_clearsystemcache; ?></a></div></td>
   		</tr>
		<tr>
            <td class="left"><?php echo $vqmod_description; ?></td>
			<td class="left"><div class="buttons"><a href="<?php echo $clearvqmodcache; ?>" class="button"><?php echo $button_clearvqmodcache; ?></a></div></td>
   		</tr>
        </tbody>
      </table>
	   </div><!--End tab clean -->
	   
	  <div id="tab-filelist"> 
	  <table class="list">
	  <thead>
			<td class="left"> <?php echo $text_filename; ?></td> 
			<td class="left"> <?php echo $text_size; ?></td> 
	  </thead>
	  <tbody>
	 	  <?php foreach ($files as $file) { ?>
		 <tr>
		<td class="left"> <?php echo $file['filename']; ?></td> 
		<td class="left"> <?php echo $file['size']; ?></td> 
		 </tr>  
		  <?php } ?>
		</tbody>
		
		<tfoot>
			<td class="left"> <?php echo $text_total; ?></td> 
			<td class="left"> <?php echo $total; ?></td> 
		</tfoot>
				
	  </table>
	  </div><!--End tab filelist -->
  </div>
</div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php echo $footer; ?>