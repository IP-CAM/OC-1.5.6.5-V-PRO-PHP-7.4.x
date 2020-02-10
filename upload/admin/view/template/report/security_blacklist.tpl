<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */
?>
<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a
                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
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
            <h1><img src="view/image/log.png" alt=""/> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="list">
                    <thead>
                        <tr>
                            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"/>
                            </td>
                            <td class="left"><?php echo $column_host; ?></td>
                            <td><?php echo $column_date_time; ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($hosts) { ?>
                            <?php foreach ($hosts as $host) { ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <?php if ($host['selected']) { ?>
                                            <input type="checkbox" name="selected[]" value="<?php echo $host['ban_list_id']; ?>" checked="checked"/>
                                        <?php } else { ?>
                                            <input type="checkbox" name="selected[]" value="<?php echo $host['ban_list_id']; ?>"/>
                                        <?php } ?>
                                    </td>
                                    <td class="left"><?php echo $host['host']; ?></td>
                                    <td><?php echo $host['timestamp']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
        <p style="text-align:center; color:#222;">Security OpenCart Module v<?php echo $version; ?> - <a href="http://exife.com" target="_blank">exife.com</a></p>
    </div>
</div>
<?php echo $footer; ?>