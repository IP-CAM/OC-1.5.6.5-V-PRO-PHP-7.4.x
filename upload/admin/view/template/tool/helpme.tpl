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
    <div class="heading">
      <h1><img src="view/image/review.png" title="Send a technical OpenShop/OpenCart Help Invitation to some Person or Coder." alt="Send a technical OpenShop/OpenCart Help Invitation to some Person or Coder" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <form action="<?php echo $send_it; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <?php if (!isset($invite_link)) { ?>
          <tr>
            <td align="center"><img src="view/image/help_me.png" title="Send a technical OpenShop/OpenCart Help Invitation to some Person or Coder." alt="Send a technical OpenShop/OpenCart Help Invitation to some Person or Coder." /></td>
            <td><?php echo $intro; ?></td>
          </tr>
          <tr>
              <td><span class="required"></span> <?php echo $invite_to; ?></td>
              <td><input type="text" name="email" value="" size="50" required="true" /> &nbsp; required</td>
          </tr>
		  <tr>
              <td style="vertical-align:top"><?php echo $warning; ?></td>
			  <td><?php echo $aware; ?></td>
          </tr>

		  <tr>
              <td style="vertical-align:top"><?php echo $secure_admin; ?></td>
			  <td><?php echo $secure_admin_info; ?></td>
          </tr>

          <tr>
              <td style="vertical-align:top"><?php echo $instructions; ?></td>
			  <td><textarea name="task" value="" cols="64" rows="6" /></textarea>
                  <br/><br/>
                  <a onclick="$('#form').submit();" class="button"><?php echo $inv_send; ?></a>
              </td>
          </tr>
          <?php } else { ?>
            <tr>
				<td align="center"><img src="view/image/help_me.png" title="Send a technical OpenShop/OpenCart Help Invitation to some Person or Coder." alt="Send a technical OpenShop/OpenCart Help Invitation to some Person or Coder." /></td>
                <td><b><?php echo $active; ?></b></td>
            </tr>
            <tr>
                <td><?php echo $invite_to; ?></td>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <td><?php echo $invite_link; ?></td>
                <td><a target="_blank" href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href="<?php echo $cancel_link; ?>" class="button"><?php echo $invite_cancel; ?></a>
                </td>
            </tr>
          <?php } ?>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>