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
                    <td><?php echo $entry_group; ?>
                        <select name="filter_group">
                            <?php foreach ($groups as $groups) { ?>
                                <?php if ($groups['value'] == $filter_group) { ?>
                                    <option value="<?php echo $groups['value']; ?>"
                                            selected="selected"><?php echo $groups['text']; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $groups['value']; ?>"><?php echo $groups['text']; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                    <td style="text-align: right;"><a onclick="filter();"
                                                      class="button"><span><?php echo $button_filter; ?></span></a></td>
                </tr>
            </table>
            <table class="list">
                <thead>
                    <tr>
                        <?php if (empty($filter_group) || $filter_group == 'none') { ?>
                            <td class="left"><?php echo $column_date_time; ?></td>
                        <?php } else { ?>
                            <td class="left"><?php echo $column_date_start; ?></td>
                            <td class="left"><?php echo $column_date_end; ?></td>
                        <?php } ?>
                        <td class="left"><?php echo $column_host; ?></td>
                        <td class="left"><?php echo $column_url; ?></td>
                        <td class="right"><?php echo $column_attempts; ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($not_found) { ?>
                        <?php foreach ($not_found as $entry) { ?>
                            <tr>
                                <?php if (empty($filter_group) || $filter_group == 'none') { ?>
                                    <td class="left"><?php echo $entry['timestamp']; ?></td>
                                <?php } else { ?>
                                    <td class="left"><?php echo $entry['date_start']; ?></td>
                                    <td class="left"><?php echo $entry['date_end']; ?></td>
                                <?php } ?>
                                <td class="left"><?php echo $entry['host']; ?></td>
                                <td class="left"><?php echo $entry['url']; ?></td>
                                <td class="right"><?php echo $entry['attempts']; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td class="center" colspan="<?php echo (empty($filter_group) || $filter_group == 'none') ? 4 : 5; ?>"><?php echo $text_no_results; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
        <p style="text-align:center; color:#222;">Security OpenCart Module v<?php echo $version; ?> - <a href="http://exife.com" target="_blank">exife.com</a></p>
    </div>
</div>
<script type="text/javascript"><!--
    function filter() {
        var url = 'index.php?route=report/security/detection_404&token=<?php echo $token; ?>';

        var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');

        if (filter_date_start) {
            url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
        }

        var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');

        if (filter_date_end) {
            url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
        }

        var filter_group = $('select[name=\'filter_group\']').attr('value');

        if (filter_group) {
            url += '&filter_group=' + encodeURIComponent(filter_group);
        }

        location = url;
    }
    //--></script>
<script type="text/javascript"><!--
    $(document).ready(function () {
        $('#date-start').datepicker({dateFormat: 'yy-mm-dd'});

        $('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
    });
    //--></script>
<?php echo $footer; ?>