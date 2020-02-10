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
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $save; ?>'); $('#form').submit();" class="button"><span><?php echo $button_save_and_edit; ?></span></a><a href="<?php echo $cancel; ?>" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                    <div id="tabs" class="htabs">
                        <a href="#tab-detect"><?php echo $tab_intrusion_detection; ?></a>
                        <a href="#tab-login"><?php echo $tab_login_attempts; ?></a>
                     </div>
                    <div id="tab-detect">
                        <h2><?php echo $tab_intrusion_detection; ?></h2>
                        <table class="form">
                            <tr>
                                <td colspan="2">
                                    <?php echo $text_intrusion_detection_info; ?>
                                </td>
                            </tr>
                        </table>
                        <h2><?php echo $text_404_detection; ?></h2>
                        <table class="form">
                            <tr>
                                <td><?php echo $entry_enable_404_detection; ?></td>
                                <td>
                                    <?php if($enable_404_detection) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="enable_404_detection_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="enable_404_detection_1" name="enable_404_detection" value="1" />
                                    <label for="enable_404_detection_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="enable_404_detection_0" name="enable_404_detection" value="0" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_email_404_notifications; ?></td>
                                <td>
                                    <?php if($email_404_notifications) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="email_404_notifications_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="email_404_notifications_1" name="email_404_notifications" value="1" />
                                    <label for="email_404_notifications_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="email_404_notifications_0" name="email_404_notifications" value="0" />
                                </td>
                            </tr>
                            <tbody id="404_email">
                                <tr>
                                    <td><?php echo $entry_email_404_address; ?></td>
                                    <td>
                                        <input type="text" name="email_404_address" value="<?php echo $email_404_address; ?>" size="40" />
                                    </td>
                                </tr>
                            </tbody>
                            <tr>
                                <td><?php echo $entry_check_period; ?></td>
                                <td>
                                    <input type="text" name="check_period" value="<?php echo $check_period; ?>" size="4" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_error_threshold; ?></td>
                                <td>
                                    <input type="text" name="error_threshold" value="<?php echo $error_threshold; ?>" size="4" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_lockout_period; ?></td>
                                <td>
                                    <input type="text" name="lockout_period" value="<?php echo $lockout_period; ?>" size="4" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_blacklist_repeat_offender; ?></td>
                                <td>
                                    <?php if($blacklist_repeat_offender) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="blacklist_repeat_offender_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="blacklist_repeat_offender_1" name="blacklist_repeat_offender" value="1" />
                                    <label for="blacklist_repeat_offender_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="blacklist_repeat_offender_0" name="blacklist_repeat_offender" value="0" />
                                </td>
                            </tr>
                            <tbody id="blacklist_threshold">
                                <tr>
                                    <td><?php echo $entry_blacklist_threshold; ?></td>
                                    <td>
                                        <input type="text" name="blacklist_threshold" value="<?php echo $blacklist_threshold; ?>" size="4" />
                                    </td>
                                </tr>
                            </tbody>
                            <tr>
                                <td><?php echo $entry_404_white_list; ?><br/><?php echo $text_404_white_list_help; ?></td>
                                <td>
                                    <textarea name="white_list_404" rows="30" cols="60"><?php echo $white_list_404; ?></textarea>
                                </td>
                            </tr>
                        </table>
                        <h2><?php echo $text_file_change_detection; ?></h2>
                        <table class="form">
                            <tr>
                                <td><?php echo $entry_enable_file_change_detection; ?></td>
                                <td>
                                    <?php if($enable_file_change_detection) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="enable_file_change_detection_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="enable_file_change_detection_1" name="enable_file_change_detection" value="1" />
                                    <label for="enable_file_change_detection_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="enable_file_change_detection_0" name="enable_file_change_detection" value="0" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_check_interval; ?></td>
                                <td>
                                    <input type="text" name="check_interval" value="<?php echo $check_interval; ?>" size="4" />&nbsp;
                                    <select name="check_interval_type">
                                        <?php if ($check_interval_type == '0') { ?>
                                            <option value="0" selected="selected"><?php echo $text_hours; ?></option>
                                            <option value="1"><?php echo $text_days; ?></option>
                                            <option value="2"><?php echo $text_weeks; ?></option>
                                        <?php } elseif ($check_interval_type == '1') { ?>
                                            <option value="0"><?php echo $text_hours; ?></option>
                                            <option value="1" selected="selected"><?php echo $text_days; ?></option>
                                            <option value="2"><?php echo $text_weeks; ?></option>
                                        <?php } else { ?>
                                            <option value="0"><?php echo $text_hours; ?></option>
                                            <option value="1"><?php echo $text_days; ?></option>
                                            <option value="2" selected="selected"><?php echo $text_weeks; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_file_change_admin_warning; ?></td>
                                <td>
                                    <?php if($file_change_admin_warning) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="file_change_admin_warning_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="file_change_admin_warning_1" name="file_change_admin_warning" value="1" />
                                    <label for="file_change_admin_warning_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="file_change_admin_warning_0" name="file_change_admin_warning" value="0" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_email_file_change_notifications; ?></td>
                                <td>
                                    <?php if($email_file_change_notifications) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="email_file_change_notifications_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="email_file_change_notifications_1" name="email_file_change_notifications" value="1" />
                                    <label for="email_file_change_notifications_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="email_file_change_notifications_0" name="email_file_change_notifications" value="0" />
                                </td>
                            </tr>
                            <tbody id="file_change">
                                <tr>
                                    <td><?php echo $entry_email_file_change_address; ?></td>
                                    <td>
                                        <input type="text" name="email_file_change_address" value="<?php echo $email_file_change_address; ?>" size="40" />
                                    </td>
                                </tr>
                            </tbody>
                            <tr>
                                <td><?php echo $entry_include_exclude_list; ?></td>
                                <td>
                                    <select name="include_exclude_list">
                                        <?php if ($include_exclude_list) { ?>
                                            <option value="0"><?php echo $text_include; ?></option>
                                            <option value="1" selected="selected"><?php echo $text_exclude; ?></option>
                                        <?php } else { ?>
                                            <option value="0" selected="selected"><?php echo $text_include; ?></option>
                                            <option value="1"><?php echo $text_exclude; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_check_list; ?></td>
                                <td>
                                    <div id="check_list"></div>
                                    <input name="check_list" type="hidden" value="<?php echo $check_list; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_exclude_extensions; ?></td>
                                <td>
                                    <input name="ext_check_list" type="text" value="<?php echo $ext_check_list; ?>" size="60" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="tab-login">
                        <h2><?php echo $tab_login_attempts; ?></h2>
                        <table class="form">
                            <tr>
                                <td colspan="2">
                                    <?php echo $text_login_attempts_info; ?>
                                </td>
                            </tr>
                        </table>
                        <h2><?php echo $text_limit_login_attempts; ?></h2>
                        <table class="form">
                            <tr>
                                <td><?php echo $entry_enable_login_limits; ?></td>
                                <td>
                                    <?php if($enable_login_limits) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="enable_login_limits_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="enable_login_limits_1" name="enable_login_limits" value="1" />
                                    <label for="enable_login_limits_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="enable_login_limits_0" name="enable_login_limits" value="0" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_max_login_attempts_host; ?></td>
                                <td>
                                    <input type="text" name="max_login_attempts_host" value="<?php echo $max_login_attempts_host; ?>" size="4" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_max_login_attempts_user; ?></td>
                                <td>
                                    <input type="text" name="max_login_attempts_user" value="<?php echo $max_login_attempts_user; ?>" size="4" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_login_time_period; ?></td>
                                <td>
                                    <input type="text" name="login_time_period" value="<?php echo $login_time_period; ?>" size="4" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_lockout_time_period; ?></td>
                                <td>
                                    <input type="text" name="lockout_time_period" value="<?php echo $lockout_time_period; ?>" size="4" />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $entry_blacklist_repeated_offender; ?></td>
                                <td>
                                    <?php if($blacklist_repeated_offender) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="blacklist_repeated_offender_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="blacklist_repeated_offender_1" name="blacklist_repeated_offender" value="1" />
                                    <label for="blacklist_repeated_offender_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="blacklist_repeated_offender_0" name="blacklist_repeated_offender" value="0" />
                                </td>
                            </tr>
                            <tbody id="login_blacklist_threshold">
                                <tr>
                                    <td><?php echo $entry_login_blacklist_threshold; ?></td>
                                    <td>
                                        <input type="text" name="login_blacklist_threshold" value="<?php echo $login_blacklist_threshold; ?>" size="4" />
                                    </td>
                                </tr>
                            </tbody>
                            <tr>
                                <td><?php echo $entry_email_login_notifications; ?></td>
                                <td>
                                    <?php if($email_login_notifications) {
                                        $checked1 = ' checked="checked"';
                                        $checked0 = '';
                                    } else {
                                        $checked1 = '';
                                        $checked0 = ' checked="checked"';
                                    } ?>
                                    <label for="email_login_notifications_1"><?php echo $text_yes; ?></label>
                                    <input type="radio"<?php echo $checked1; ?> id="email_login_notifications_1" name="email_login_notifications" value="1" />
                                    <label for="email_login_notifications_0"><?php echo $text_no; ?></label>
                                    <input type="radio"<?php echo $checked0; ?> id="email_login_notifications_0" name="email_login_notifications" value="0" />
                                </td>
                            </tr>
                            <tbody id="login_email">
                                <tr>
                                    <td><?php echo $entry_email_login_address; ?></td>
                                    <td>
                                        <input type="text" name="email_login_address" value="<?php echo $email_login_address; ?>" size="40" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"><!--
    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
    $('.time').timepicker({timeFormat: 'h:m', stepMinute: 10, minuteMax: 50});

    $('select[name=type_of_restriction]').bind('change', function(){
        if ($(this).val() == 0) {
            $('#date_range').hide();
        } else {
            $('#date_range').show();
        }
    }).trigger('change');

    $('input[name=\'email_404_notifications\']').bind('click', function() {
        if ($('input[name=\'email_404_notifications\']:checked').val() == 1) {
            $('#404_email').show();
        } else {
            $('#404_email').hide();
        }
    })
    $('input[name=\'email_404_notifications\']:checked').trigger('click');

    $('input[name=\'blacklist_repeat_offender\']').bind('click', function() {
        if ($('input[name=\'blacklist_repeat_offender\']:checked').val() == 1) {
            $('#blacklist_threshold').show();
        } else {
            $('#blacklist_threshold').hide();
        }
    })
    $('input[name=\'blacklist_repeat_offender\']:checked').trigger('click');

    $('input[name=\'email_file_change_notifications\']').bind('click', function() {
        if ($('input[name=\'email_file_change_notifications\']:checked').val() == 1) {
            $('#file_change').show();
        } else {
            $('#file_change').hide();
        }
    })
    $('input[name=\'email_file_change_notifications\']:checked').trigger('click');

    $('input[name=\'blacklist_repeated_offender\']').bind('click', function() {
        if ($('input[name=\'blacklist_repeated_offender\']:checked').val() == 1) {
            $('#login_blacklist_threshold').show();
        } else {
            $('#login_blacklist_threshold').hide();
        }
    })
    $('input[name=\'blacklist_repeated_offender\']:checked').trigger('click');

    $('input[name=\'email_login_notifications\']').bind('click', function() {
        if ($('input[name=\'email_login_notifications\']:checked').val() == 1) {
            $('#login_email').show();
        } else {
            $('#login_email').hide();
        }
    })
    $('input[name=\'email_login_notifications\']:checked').trigger('click');

    _canLog = false;

    $(document).ready(function() {

        $('#tabs a').tabs();
        $('#help-tabs a').tabs();

        $('.warning, .success').live('click', function() {
           $(this).remove();
        });

        $("#check_list").dynatree({
            title: 'security_module',
            autoFocus: false,
            checkbox: true,
            selectMode: 3,
            initAjax: {
                url: 'index.php?route=module/security/tree&token=<?php echo $token; ?>',
                data: {
                    list: 'check_list'
                }
            },
            onSelect: function(select, node) {
                node.data.select = select;
                var selKeys = $.map(node.tree.getSelectedNodes(), function(node) {
                    return node.data.key;
                });
                $('input[name=check_list]').val(selKeys.join(", "));
            },
            onLazyRead: function(node) {
                node.appendAjax({
                    url: 'index.php?route=module/security/tree&token=<?php echo $token; ?>',
                    data: {
                        key: encodeURIComponent(node.data.key),
                        checkbox: (node.data.select ? 1 : 0),
                        list: 'check_list'
                    }
                });
            },
            onPostInit: function(isReloading, isError) {
                this.redraw();
            },
            cookieId: "tree-check-list",
            idPrefix: "tree-check-list-",
            debugLevel: 0
        });
    });
//--></script>
<?php echo $footer; ?>