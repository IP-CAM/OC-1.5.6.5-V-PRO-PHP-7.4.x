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

  <?php if (isset($success)) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>

  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
	  <div class="htabs">
		    <a href="#tab-log"><?php echo $tab_log; ?></a>
		    <a href="#tab-settings"><?php echo $tab_settings; ?></a>
		    <a href="#tab-help"><?php echo $tab_help; ?></a>
      </div>

	  <div id="tab-log">
		  <div class="box">
				<div class="heading">
					<div class="buttons">
						<a onclick="$('.stayid').attr('value', '0'); $('#clear').submit();" class="button"><span><?php echo $button_clear_go; ?></span></a>
						<a onclick="$('.stayid').attr('value', '1'); $('#clear').submit();" class="button"><span><?php echo $button_clear_stay; ?></span></a>
			  		</div>
				</div>
			</div>
		<form action="<?php echo $action; ?>" method="post" id="clear">
		<input type="hidden" name="stay" class="stayid" value="1">
		<input type="hidden" name="clear" value="1">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $column_user; ?></td>
              <td class="left"><?php echo $column_action; ?></td>
              <td class="left"><?php echo $column_allowed; ?></td>
              <td class="left"><?php echo $column_url; ?></td>
              <td class="left"><?php echo $column_ip; ?></td>
              <td class="left"><?php echo $column_date; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($entries) { ?>
            <?php foreach ($entries as $entry) { ?>

            <tr class="<?php if(!$entry['allowed']){ ?>denied <?php } ?><?php echo $entry['action']; ?>">
              <td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $entry['log_id']; ?>" /></td>
              <td class="left"><a href="<?php echo $entry['user']; ?>" target="_blank"><?php echo $entry['user_name']; ?></a></td>
              <td class="left"><?php echo $entry['action']; ?></td>
              <td class="left"><?php echo $entry['allowed']; ?></td>
              <td class="left"><a href="<?php echo $entry['url_link']; ?>" target="_blank"><?php echo $entry['url']; ?></a></td>
              <td class="left"><?php echo $entry['ip']; ?></td>
              <td class="left"><?php echo date("d.m.Y H:i:s", strtotime($entry['date'])); ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        </form>
        <div class="pagination"><?php echo $pagination; ?></div>
	  </div>

	  <div id="tab-settings">
		  <div class="box">
		    <div class="heading">
		      <div class="buttons">
				<a onclick="$('#stayid').attr('value', '0'); $('#form').submit();" class="button"><span><?php echo $button_save_go; ?></span></a>
				<a onclick="$('#stayid').attr('value', '1'); $('#form').submit();" class="button"><span><?php echo $button_save_stay; ?></span></a>
				<a href="<?php echo $cancel; ?>" class="button"><span><?php echo $button_cancel; ?></span></a>
			  </div>
		    </div>
		    </div>
		<form action="<?php echo $action; ?>" method="post" id="form">
		<input type="hidden" name="stay" class="stayid" value="1">
        <table class="form">
          <tbody>
            <tr>
				<td><?php echo $entry_adminlog_enable; ?></td>
				<td>
					<select name="adminlog_enable">
					<?php if ($adminlog_enable) { ?>
						<option value="1" selected="selected"
						><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"
						><?php echo $text_disabled; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
            <tr>
				<td><?php echo $entry_adminlog_login; ?></td>
				<td>
					<select name="adminlog_login">
					<?php if ($adminlog_login) { ?>
						<option value="1" selected="selected"
						><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"
						><?php echo $text_disabled; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
            <tr>
				<td><?php echo $entry_adminlog_logout; ?></td>
				<td>
					<select name="adminlog_logout">
					<?php if ($adminlog_logout) { ?>
						<option value="1" selected="selected"
						><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"
						><?php echo $text_disabled; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
            <tr>
				<td><?php echo $entry_adminlog_hacklog; ?></td>
				<td>
					<select name="adminlog_hacklog">
					<?php if ($adminlog_hacklog) { ?>
						<option value="1" selected="selected"
						><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"
						><?php echo $text_disabled; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
            <tr>
				<td><?php echo $entry_adminlog_access; ?></td>
				<td>
					<select name="adminlog_access">
					<?php if ($adminlog_access) { ?>
						<option value="1" selected="selected"
						><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"
						><?php echo $text_disabled; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
            <tr>
				<td><?php echo $entry_adminlog_modify; ?></td>
				<td>
					<select name="adminlog_modify">
					<?php if ($adminlog_modify) { ?>
						<option value="1" selected="selected"
						><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"
						><?php echo $text_disabled; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
            <tr>
				<td><?php echo $entry_adminlog_allowed; ?></td>
				<td>
					<select name="adminlog_allowed">
					<?php if ($adminlog_allowed == 1) { ?>
						<option value="0"><?php echo $text_denied; ?></option>
						<option value="1" selected="selected"><?php echo $text_allowed; ?></option>
						<option value="2"><?php echo $text_all; ?></option>
					<?php } elseif ($adminlog_allowed == 2) { ?>
						<option value="0"><?php echo $text_denied; ?></option>
						<option value="1"><?php echo $text_allowed; ?></option>
						<option value="2" selected="selected"><?php echo $text_all; ?></option>
					<?php } else { ?>
						<option value="0" selected="selected"><?php echo $text_denied; ?></option>
						<option value="1"><?php echo $text_allowed; ?></option>
						<option value="2"><?php echo $text_all; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
            <tr>
				<td><?php echo $entry_adminlog_display; ?></td>
				<td><input type="text" name="adminlog_display" value="<?php echo $adminlog_display; ?>"></td>
			</tr>
		</table>
		</form>
	  </div>

	  <div id="tab-help">
		<? echo $text_description; ?>
	  </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('.htabs a').tabs();
//--></script>
<?php echo $footer; ?>