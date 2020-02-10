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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
       
    </div>
    <div class="content">
    	<h1><a href="index.php?route=module/csvcreator/file_csv&token=<?php echo $this->session->data['token']?>">Download</a></h1>
    </div>
  </div>
</div>

<?php echo $footer; ?>