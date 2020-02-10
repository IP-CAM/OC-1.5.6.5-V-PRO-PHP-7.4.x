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
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/report.png" alt=""/> <?php echo $heading_title; ?></h1>
        </div>
        <div class="content">
            <table class="form">
                <tr>
                    <td><?php echo $entry_date_start; ?>
                        <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>"
                               id="date-start" size="12"/></td>
                    <td><?php echo $entry_date_end; ?>
                        <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end"
                               size="12"/></td>
                    <td style="text-align: right;"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
                </tr>
            </table>
            <table class="list">
                <thead>
                    <tr>
                        <td class="left"><?php echo $column_date; ?></td>
                        <td class="left"><?php echo $column_files_added; ?></td>
                        <td class="left"><?php echo $column_files_deleted; ?></td>
                        <td class="left"><?php echo $column_files_changed; ?></td>
                        <td class="right"><?php echo $column_used_memory; ?></td>
                        <td class="right"><?php echo $column_action; ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($file_changes) { ?>
                        <?php foreach ($file_changes as $file_change) { ?>
                            <tr>
                                <td class="left"><?php echo $file_change['timestamp']; ?></td>
                                <td class="left">
                                    <?php if ($file_change['added']) { ?>
                                        <span style="color:red;font-weight:bold;"><?php echo $file_change['added']; ?></span>
                                    <?php } else { ?>
                                        0
                                    <?php } ?>
                                </td>
                                <td class="left">
                                    <?php if ($file_change['deleted']) { ?>
                                        <span style="color:red;font-weight:bold;"><?php echo $file_change['deleted']; ?></span>
                                    <?php } else { ?>
                                        0
                                    <?php } ?>
                                </td>
                                <td class="left">
                                    <?php if ($file_change['changed']) { ?>
                                        <span style="color:red;font-weight:bold;"><?php echo $file_change['changed']; ?></span>
                                    <?php } else { ?>
                                        0
                                    <?php } ?>
                                </td>
                                <td class="right"><?php echo $file_change['used_memory']; ?></td>
                                <td class="right">
                                    <?php if ($file_change['added'] || $file_change['deleted'] || $file_change['changed']) { ?>
                                        <?php foreach ($file_change['action'] as $action) { ?>
                                            [ <a onclick="details('<?php echo $action['href']; ?>', this); return false;"><?php echo $action['text']; ?></a> ]
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
        <p style="text-align:center; color:#222;">Security OpenCart Module v<?php echo $version; ?> - <a href="http://exife.com" target="_blank">exife.com</a></p>
        <div id="detail-dialog"></div>
    </div>
</div>
<script type="text/javascript"><!--
    function filter() {
        var url = 'index.php?route=report/security/file_changes&token=<?php echo $token; ?>';

        var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');

        if (filter_date_start) {
            url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
        }

        var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');

        if (filter_date_end) {
            url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
        }

        location = url;
    }
    //--></script>
<script type="text/javascript"><!--
    $(document).ready(function () {
        $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
        $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
    });

    function details(url, el) {
        $(".ui-dialog-content").dialog("close");

        $(el).parent().prepend('<img class="selection-wait" src="view/image/loading.gif" alt="" />');

        $('#detail-dialog').load(url, function() {
            $('.selection-wait').remove();

            $('#detail-dialog').dialog({
                title: '',
                bgiframe: false,
                width: 800,
                height: 400,
                resizable: false,
                modal: false
            });
        })
    }
    //--></script>
<?php echo $footer; ?>