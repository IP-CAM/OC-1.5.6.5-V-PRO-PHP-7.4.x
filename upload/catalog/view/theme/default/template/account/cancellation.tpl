<?php echo $header; ?>
<div class="container">
<ul class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb) { ?>
<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
<?php } ?>
</ul>
 <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
<h1><?php echo $heading_title; ?></h1>
<div style="font-size:15px;margin:10px 10px 10px 0;">
<?php echo $text_account_cancellation_message; ?>
</div>
<div class="buttons">
 <table width="100%" style="text-align:center;" id="jtimod">
   <tr>
    <td width="50%" style="text-align:left;"><input class="btn btn-primary" type="button" VALUE="Return to Account" ONCLICK="history.go(-1);"></td>
    <td width="50%" style="text-align:right;" ><a href="<?php echo $continue; ?>" class="btn btn-primary" />Delete Account</a></td>
  </tr>
</table>
</div>

<?php echo $content_bottom; ?>
</div>
<?php echo $column_right; ?></div></div>
<?php echo $footer; ?>