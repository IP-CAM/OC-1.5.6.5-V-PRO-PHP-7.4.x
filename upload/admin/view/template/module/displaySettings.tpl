<?php echo $header; ?>
<style type="text/css">
input[type="radio"] {
margin: 3px 45px 0px 5px;
}
.box > .content h2 {
color: #008aff;
border-bottom: none;
}
.span {vertical-align: top;}
table.form > tbody > tr > td:first-child {
font-weight: bold;
color:#646464;
}
table.form > tbody > tr > td:nth-child(2) {
width:280px;
}
#checkbox_cancel, #checkbox_check {
margin: 0;
border: 0;
height: 24px;
padding: 0px 12px 0px 12px;
cursor: pointer;
color: #FFFFFF;
line-height: 12px;
font-family: Arial, Helvetica, sans-serif;
font-size: 12px;
background: #008aff;
-webkit-border-radius: 7px 7px 7px 7px;
-moz-border-radius: 7px 7px 7px 7px;
-khtml-border-radius: 7px 7px 7px 7px;
border-radius: 7px 7px 7px 7px;
margin-right:10px;
}
</style>

<div id="content">
<div class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb) { ?>
<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
<?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
<div class="heading">
<h1><?php echo $heading_title; ?></h1>
<div class="buttons"><a onclick="$('#form').submit();" class="button" style="background:#008aff;"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button" style="background:#008aff;"><?php echo $button_cancel; ?></a></div>
</div>

<div class="content">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
</br>
<input type="button" id="checkbox_check" value="<?php echo $text_all; ?>" />
<input type="button" id="checkbox_cancel" value="<?php echo $text_none; ?>" />
<script type="text/javascript">
$(document).ready(function(){
	$('#checkbox_cancel').click(function(){
	$('input#checkbox').each(function(){
	$(this).attr('checked', false);
	});
	});
	$('#checkbox_check').click(function(){
	$('input#checkbox').each(function(){
	$(this).attr('checked', true);
	});
	});
});
</script>

<table class="form">
<tr>
<td><?php echo $text_ds_model; ?></td>
<td><?php if ($config_product_model) { ?>
<input type="checkbox" id="checkbox"  name="config_product_model" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_model" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_sku; ?></td>
<td><?php if ($config_product_sku) { ?>
<input type="checkbox" id="checkbox"  name="config_product_sku" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_sku" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_upc; ?></td>
<td><?php if ($config_product_upc) { ?>
<input type="checkbox" id="checkbox"  name="config_product_upc" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_upc" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_ean; ?></td>
<td><?php if ($config_product_ean) { ?>
<input type="checkbox" id="checkbox"  name="config_product_ean" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_ean" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_jan; ?></td>
<td><?php if ($config_product_jan) { ?>
<input type="checkbox" id="checkbox"  name="config_product_jan" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_jan" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_isbn; ?></td>
<td><?php if ($config_product_isbn) { ?>
<input type="checkbox" id="checkbox"  name="config_product_isbn" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_isbn" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_mpn; ?></td>
<td><?php if ($config_product_mpn) { ?>
<input type="checkbox" id="checkbox"  name="config_product_mpn" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_mpn" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>
</table>

<td><h2><?php echo $text_ds_settings3; ?></h2></td>

<table class="form">
<tr>
<td><?php echo $text_ds_sales; ?></td>
<td><?php if ($config_product_sales) { ?>
<input type="checkbox" id="checkbox"  name="config_product_sales" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_sales" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_views; ?></td>
<td><?php if ($config_product_views) { ?>
<input type="checkbox" id="checkbox"  name="config_product_views" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_views" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_rating; ?></td>
<td><?php if ($config_product_rating) { ?>
<input type="checkbox" id="checkbox"  name="config_product_rating" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_rating" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_reviews; ?></td>
<td><?php if ($config_product_reviews) { ?>
<input type="checkbox" id="checkbox"  name="config_product_reviews" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_reviews" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>
</table>

<td><h2><?php echo $text_ds_settings4; ?></h2></td>

<table class="form">
<tr>
<td><?php echo $text_ds_save; ?></td>
<td><?php if ($config_product_save) { ?>
<input type="checkbox" id="checkbox"  name="config_product_save" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_save" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_special_date; ?></td>
<td><?php if ($config_product_special_date) { ?>
<input type="checkbox" id="checkbox"  name="config_product_special_date" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_special_date" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_reward; ?></td>
<td><?php if ($config_product_reward) { ?>
<input type="checkbox" id="checkbox"  name="config_product_reward" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_reward" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_points; ?></td>
<td><?php if ($config_product_points) { ?>
<input type="checkbox" id="checkbox"  name="config_product_points" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_points" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>
 </table>

  <td><h2><?php echo $text_ds_settings5; ?></h2></td>

<table class="form">
 <tr>
<td><?php echo $text_ds_quantity; ?></td>
<td><?php if ($config_product_quantity) { ?>
<input type="checkbox" id="checkbox"  name="config_product_quantity" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_quantity" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_stockstatus; ?></td>
<td><?php if ($config_product_stockstatus) { ?>
<input type="checkbox" id="checkbox"  name="config_product_stockstatus" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_stockstatus" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_date_available; ?></td>
<td><?php if ($config_product_date_available) { ?>
<input type="checkbox" id="checkbox"  name="config_product_date_available" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_date_available" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>
</table>

<td><h2><?php echo $text_ds_settings6; ?></h2></td>

<table class="form">
 <tr>
<td><?php echo $text_ds_dimensions; ?></td>
<td><?php if ($config_product_dimensions) { ?>
<input type="checkbox" id="checkbox"  name="config_product_dimensions" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_dimensions" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>

<tr>
<td><?php echo $text_ds_weight; ?></td>
<td><?php if ($config_product_weight) { ?>
<input type="checkbox" id="checkbox"  name="config_product_weight" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_weight" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>
</table>

<td><h2><?php echo $text_ds_settings7; ?></h2></td>

<table class="form">
<tr>
<td><?php echo $text_ds_requires_shipping; ?></td>
<td><?php if ($config_product_requires_shipping) { ?>
<input type="checkbox" id="checkbox"  name="config_product_requires_shipping" value="1" checked="checked" />
<?php echo $text_ds_product; ?>
<?php } else { ?>
<input type="checkbox" id="checkbox"  name="config_product_requires_shipping" value="1" />
<?php echo $text_ds_product; ?>
<?php } ?></td>
</tr>
</table>
</div>
</div>
<?php echo $footer; ?>