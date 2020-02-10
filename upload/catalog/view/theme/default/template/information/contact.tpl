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
      <h3><?php echo $text_location; ?></h3>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">

            <div class="col-sm-3"><strong><?php echo $store; ?></strong><br />
              <address><?php echo $address; ?></address>
            </div>
            <div class="col-sm-3"><strong><?php echo $text_telephone; ?></strong><br>
              <?php echo $telephone; ?><br />
              <br />
              <?php if ($fax) { ?>
              <strong><?php echo $text_fax; ?></strong><br>
              <?php echo $fax; ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <h3><?php echo $text_contact; ?></h3>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-6">
              <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-3 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-6">
              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
 
         <div class="form-group required">
            <label class="col-sm-3 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
            <div class="col-sm-6">
              <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <div class="text-danger"><?php echo $error_enquiry; ?></div>
              <?php } ?>
            </div>
          </div>

		<div class="form-group required">
		<label class="col-sm-3 control-label" for="input-captcha"><?php echo $entry_captcha; ?></label>
        <div class="col-sm-6">
		<input type="text" name="captcha" value="<?php echo $captcha; ?>" /> 
		<img src="index.php?route=information/contact/captcha" alt="" />
		</p>
		<?php if ($error_captcha) { ?>
		<label class="text-danger"<span class="error"><?php echo $error_captcha; ?></span></label>
		<?php } ?>
		</div>
		</div>

		<div class="form-group required">
		<label class="col-sm-3 control-label" for="input-cookie">Cookie Information:</label>
	     <div class="col-sm-3"><a href="/index.php?route=information/information&information_id=3"  target ="_blank">You hereby confirm, to understand + accept our Privacy + Cookie Policy: </a></div>
		 <div class="col-sm-3"><input type="checkbox" required name="terms">	&nbsp;&nbsp; <input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>" />
          </div>
		</div>

		</fieldset>
	</form>
	</div>


    <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
