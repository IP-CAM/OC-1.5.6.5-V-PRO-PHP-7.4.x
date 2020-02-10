<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class ControllerModuleSecurity extends Controller {

    public function install() {
        $this->load->model('module/security');
        $this->model_module_security->install();

        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('security', array(
            'security_version' => '1.0',
            'security_key' => '1',

            'security_check_period' => 5,
            'security_error_threshold' => 20,
            'security_lockout_period' => 15,
            'security_blacklist_threshold' => 3,

            'security_file_change_admin_warning' => 1,
            'security_include_exclude_list' => 1,
            'security_ext_check_list' => '.jpg, .png, .jpeg, .gif',

            'security_max_login_attempts_host' => 5,
            'security_max_login_attempts_user' => 10,
            'security_login_time_period' => 5,
            'security_lockout_time_period' => 15,
            'security_blacklist_repeated_offender' => 0,
            'security_login_blacklist_threshold' => 3,

            'security_backup_interval' => 1,
            'security_backup_full_interval' => 1,
            'security_backup_full_interval_type' => 2,
            'security_backup_include_exclude_list' => 1,
            'security_keep_backups' => 5,
        ));
    }

    public function uninstall() {
        $this->load->model('module/security');
        $this->model_module_security->uninstall();
    }

    public function index() {
        $this->load->language('module/security');

        $this->document->setTitle($this->language->get('heading_title_page'));

        if (isset($this->session->data['error_warning'])) {
            $this->data['error_warning'] = $this->session->data['error_warning'];
            unset($this->session->data['error_warning']);
        } elseif (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        $this->data['version'] = $this->config->get('security_version');
        $this->data['cron_configured'] = $this->config->get('security_cron_configured');

        $this->data['heading_title'] = $this->language->get('heading_title_page');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_save_and_edit'] = $this->language->get('button_save_and_edit');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['save'] = $this->url->link('module/security', 'token=' . $this->session->data['token'] . '&edit', 'SSL');
        $this->data['action'] = $this->url->link('module/security', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['token'] = $this->session->data['token'];

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_modules'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_page'),
            'href'      => $this->url->link('module/security', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->load->model('setting/setting');

        $this->init();

        if (file_exists(DIR_SYSTEM . 'security_upgrade.php')) {
            include_once(DIR_SYSTEM . 'security_upgrade.php');
        }

        $this->data['auth'] = $this->url->link('module/security/auth', 'token=' . $this->session->data['token'], 'SSL');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->request->post['user_ids'] = empty($this->request->post['user_ids']) ? '' : serialize($this->request->post['user_ids']);

            $data = array();
            foreach ($this->request->post as $key => $value) {
                $data['security_' . $key] = $value;
            }

            if ($data['security_check_interval'] === '') {
                $data['security_check_interval'] = 1;
            }

            if ($data['security_backup_interval'] === '') {
                $data['security_backup_interval'] = 1;
            }

            if ($data['security_backup_full_interval'] === '') {
                $data['security_backup_full_interval'] = 1;
            }

            $next_change_check = $this->config->get('security_next_check');

            switch ((int)$data['security_check_interval_type']) {
                case 0:
                    $new_next_change_check = 'hour';
                    break;
                case 1:
                    $new_next_change_check = 'day';
                    break;
                case 2:
                    $new_next_change_check = 'week';
                    break;
                default:
                    $new_next_change_check = 'day';
            }
            $new_next_change_check = strtotime('+' . ((int)$data['security_check_interval'] ? (int)$data['security_check_interval'] : 1) . ' ' . $new_next_change_check);

            if ($next_change_check > $new_next_change_check) {
                $next_change_check = $new_next_change_check;
            }

            $next_email_backup = $this->config->get('security_next_email_backup');

            switch ((int)$data['security_backup_interval_type']) {
                case 0:
                    $new_next_email_backup = 'hour';
                    break;
                case 1:
                    $new_next_email_backup = 'day';
                    break;
                case 2:
                    $new_next_email_backup = 'week';
                    break;
                default:
                    $new_next_email_backup = 'day';
            }
            $new_next_email_backup = strtotime('+' . ((int)$data['security_backup_interval'] ? (int)$data['security_backup_interval'] : 1) . ' ' . $new_next_email_backup);

            if ($next_email_backup > $new_next_email_backup) {
                $next_email_backup = $new_next_email_backup;
            }

            $next_full_backup = $this->config->get('security_next_gdrive_backup');

            switch ((int)$data['security_backup_full_interval_type']) {
                case 0:
                    $new_next_full_backup = 'hour';
                    break;
                case 1:
                    $new_next_full_backup = 'day';
                    break;
                case 2:
                    $new_next_full_backup = 'week';
                    break;
                default:
                    $new_next_full_backup = 'day';
            }
            $new_next_full_backup = strtotime('+' . ((int)$data['security_backup_full_interval'] ? (int)$data['security_backup_full_interval'] : 1) . ' ' . $new_next_full_backup);

            if ($next_full_backup > $new_next_full_backup) {
                $next_full_backup = $new_next_full_backup;
            }

            $this->model_setting_setting->editSetting('security', array_merge($data, array(
                'security_key' => $this->config->get('security_key'),
                'security_cron_configured' => $this->config->get('security_cron_configured'),
                'security_client_id' => $this->config->get('security_client_id'),
                'security_client_secret' => $this->config->get('security_client_secret'),
                'security_gdrive_refresh_token' => $this->config->get('security_gdrive_refresh_token'),
                'security_next_gdrive_backup' => $next_full_backup,
                'security_next_email_backup' => $next_email_backup,
                'security_next_check' => $next_change_check
            )));

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->get['edit'])) {
                $this->redirect($this->url->link('module/security', 'token=' . $this->session->data['token'], 'SSL'));
            } else {
                $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }

        $this->data['unlink'] = false;

        if ($this->config->get('security_gdrive_refresh_token')) {
            $this->data['unlink'] = $this->url->link('module/security/unlink', 'token=' . $this->session->data['token'], 'SSL');
        }

        $this->document->addScript('view/javascript/security/jquery/dynatree/jquery.dynatree.min.js');
        $this->document->addStyle('view/javascript/security/jquery/dynatree/skin/ui.dynatree.css');

        $this->data['tab_intrusion_detection'] = $this->language->get('tab_intrusion_detection');
        $this->data['tab_login_attempts'] = $this->language->get('tab_login_attempts');
        $this->data['tab_away_schedule'] = $this->language->get('tab_away_schedule');
        $this->data['tab_backup'] = $this->language->get('tab_backup');

        $this->data['entry_enable_404_detection'] = $this->language->get('entry_enable_404_detection');
        $this->data['entry_email_404_notifications'] = $this->language->get('entry_email_404_notifications');
        $this->data['entry_email_404_address'] = $this->language->get('entry_email_404_address');
        $this->data['entry_check_period'] = $this->language->get('entry_check_period');
        $this->data['entry_error_threshold'] = $this->language->get('entry_error_threshold');
        $this->data['entry_lockout_period'] = $this->language->get('entry_lockout_period');
        $this->data['entry_blacklist_repeat_offender'] = $this->language->get('entry_blacklist_repeat_offender');
        $this->data['entry_blacklist_threshold'] = $this->language->get('entry_blacklist_threshold');
        $this->data['entry_404_white_list'] = $this->language->get('entry_404_white_list');
        $this->data['entry_enable_file_change_detection'] = $this->language->get('entry_enable_file_change_detection');
        $this->data['entry_check_interval'] = $this->language->get('entry_check_interval');
        $this->data['entry_file_change_admin_warning'] = $this->language->get('entry_file_change_admin_warning');
        $this->data['entry_email_file_change_notifications'] = $this->language->get('entry_email_file_change_notifications');
        $this->data['entry_email_file_change_address'] = $this->language->get('entry_email_file_change_address');
        $this->data['entry_include_exclude_list'] = $this->language->get('entry_include_exclude_list');
        $this->data['entry_check_list'] = $this->language->get('entry_check_list');
        $this->data['entry_enable_login_limits'] = $this->language->get('entry_enable_login_limits');
        $this->data['entry_max_login_attempts_host'] = $this->language->get('entry_max_login_attempts_host');
        $this->data['entry_max_login_attempts_user'] = $this->language->get('entry_max_login_attempts_user');
        $this->data['entry_login_time_period'] = $this->language->get('entry_login_time_period');
        $this->data['entry_lockout_time_period'] = $this->language->get('entry_lockout_time_period');
        $this->data['entry_blacklist_repeated_offender'] = $this->language->get('entry_blacklist_repeated_offender');
        $this->data['entry_login_blacklist_threshold'] = $this->language->get('entry_login_blacklist_threshold');
        $this->data['entry_email_login_notifications'] = $this->language->get('entry_email_login_notifications');
        $this->data['entry_email_login_address'] = $this->language->get('entry_email_login_address');
        $this->data['entry_enable_away_mode'] = $this->language->get('entry_enable_away_mode');
        $this->data['entry_type_of_restriction'] = $this->language->get('entry_type_of_restriction');
        $this->data['entry_date_range'] = $this->language->get('entry_date_range');
        $this->data['entry_time_range'] = $this->language->get('entry_time_range');
        $this->data['entry_apply_to_user'] = $this->language->get('entry_apply_to_user');
        $this->data['entry_enable_db_email_backup'] = $this->language->get('entry_enable_db_email_backup');
        $this->data['entry_backup_interval'] = $this->language->get('entry_backup_interval');
        $this->data['entry_email_backup_address'] = $this->language->get('entry_email_backup_address');
        $this->data['entry_enable_full_backup'] = $this->language->get('entry_enable_full_backup');
        $this->data['entry_backup_full_interval'] = $this->language->get('entry_backup_full_interval');
        $this->data['entry_backup_include_exclude_list'] = $this->language->get('entry_backup_include_exclude_list');
        $this->data['entry_backup_list'] = $this->language->get('entry_backup_list');
        $this->data['entry_backup_api'] = $this->language->get('entry_backup_api');
        $this->data['entry_client_id'] = $this->language->get('entry_client_id');
        $this->data['entry_client_secret'] = $this->language->get('entry_client_secret');
        $this->data['entry_exclude_extensions'] = $this->language->get('entry_exclude_extensions');
        $this->data['entry_folder_id'] = $this->language->get('entry_folder_id');
        $this->data['entry_keep_backups'] = $this->language->get('entry_keep_backups');

        $this->data['text_404_detection'] = $this->language->get('text_404_detection');
        $this->data['text_file_change_detection'] = $this->language->get('text_file_change_detection');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_include'] = $this->language->get('text_include');
        $this->data['text_exclude'] = $this->language->get('text_exclude');
        $this->data['text_404_white_list_help'] = $this->language->get('text_404_white_list_help');
        $this->data['text_intrusion_detection_info'] = $this->language->get('text_intrusion_detection_info');
        $this->data['text_login_attempts_info'] = $this->language->get('text_login_attempts_info');
        $this->data['text_limit_login_attempts'] = $this->language->get('text_limit_login_attempts');
        $this->data['text_away_schedule_info'] = $this->language->get('text_away_schedule_info');
        $this->data['text_away_mode_options'] = $this->language->get('text_away_mode_options');
        $this->data['text_daily'] = $this->language->get('text_daily');
        $this->data['text_one_time'] = $this->language->get('text_one_time');
        $this->data['text_from_to'] = $this->language->get('text_from_to');
        $this->data['text_backup_info'] = $this->language->get('text_backup_info');
        $this->data['text_email_backup'] = $this->language->get('text_email_backup');
        $this->data['text_hours'] = $this->language->get('text_hours');
        $this->data['text_days'] = $this->language->get('text_days');
        $this->data['text_weeks'] = $this->language->get('text_weeks');
        $this->data['text_full_backup'] = $this->language->get('text_full_backup');
        $this->data['text_google_api_old'] = $this->language->get('text_google_api_old');
        $this->data['text_google_api_new'] = $this->language->get('text_google_api_new');
        $this->data['text_backup_api_help'] = sprintf($this->language->get('text_backup_api_help'), $this->url->link('module/security/auth', '', 'SSL'));
        $this->data['text_backup_api_new_help'] = sprintf($this->language->get('text_backup_api_new_help'), $this->url->link('module/security/auth', '', 'SSL'));
        $this->data['text_cron_information'] = sprintf($this->language->get('text_cron_information'), DIR_APPLICATION . 'index.php');

        $this->data['button_link_account'] = $this->language->get('button_link_account');
        $this->data['button_unlink_account'] = $this->language->get('button_unlink_account');

        if (isset($this->request->post['enable_404_detection'])) {
            $this->data['enable_404_detection'] = $this->request->post['enable_404_detection'];
        } else {
            $this->data['enable_404_detection'] = $this->config->get('security_enable_404_detection');
        }

        if (isset($this->request->post['email_404_notifications'])) {
            $this->data['email_404_notifications'] = $this->request->post['email_404_notifications'];
        } else {
            $this->data['email_404_notifications'] = $this->config->get('security_email_404_notifications');
        }

        if (isset($this->request->post['email_404_address'])) {
            $this->data['email_404_address'] = $this->request->post['email_404_address'];
        } else {
            $this->data['email_404_address'] = $this->config->get('security_email_404_address');
        }

        if (isset($this->request->post['check_period'])) {
            $this->data['check_period'] = $this->request->post['check_period'];
        } else {
            $this->data['check_period'] = $this->config->get('security_check_period');
        }

        if (isset($this->request->post['error_threshold'])) {
            $this->data['error_threshold'] = $this->request->post['error_threshold'];
        } else {
            $this->data['error_threshold'] = $this->config->get('security_error_threshold');
        }

        if (isset($this->request->post['lockout_period'])) {
            $this->data['lockout_period'] = $this->request->post['lockout_period'];
        } else {
            $this->data['lockout_period'] = $this->config->get('security_lockout_period');
        }

        if (isset($this->request->post['blacklist_repeat_offender'])) {
            $this->data['blacklist_repeat_offender'] = $this->request->post['blacklist_repeat_offender'];
        } else {
            $this->data['blacklist_repeat_offender'] = $this->config->get('security_blacklist_repeat_offender');
        }

        if (isset($this->request->post['blacklist_threshold'])) {
            $this->data['blacklist_threshold'] = $this->request->post['blacklist_threshold'];
        } else {
            $this->data['blacklist_threshold'] = $this->config->get('security_blacklist_threshold');
        }

        if (isset($this->request->post['white_list_404'])) {
            $this->data['white_list_404'] = $this->request->post['white_list_404'];
        } else {
            $this->data['white_list_404'] = $this->config->get('security_white_list_404');
        }

        if (isset($this->request->post['enable_file_change_detection'])) {
            $this->data['enable_file_change_detection'] = $this->request->post['enable_file_change_detection'];
        } else {
            $this->data['enable_file_change_detection'] = $this->config->get('security_enable_file_change_detection');
        }

        if (isset($this->request->post['check_interval'])) {
            $this->data['check_interval'] = $this->request->post['check_interval'];
        } else {
            $this->data['check_interval'] = $this->config->get('security_check_interval') ? (int)$this->config->get('security_check_interval') : 1;
        }

        if (isset($this->request->post['check_interval_type'])) {
            $this->data['check_interval_type'] = $this->request->post['check_interval_type'];
        } else {
            $this->data['check_interval_type'] = $this->config->get('security_check_interval_type') === null ? 1 : (int)$this->config->get('security_check_interval_type');
        }

        if (isset($this->request->post['file_change_admin_warning'])) {
            $this->data['file_change_admin_warning'] = $this->request->post['file_change_admin_warning'];
        } else {
            $this->data['file_change_admin_warning'] = $this->config->get('security_file_change_admin_warning');
        }

        if (isset($this->request->post['email_file_change_notifications'])) {
            $this->data['email_file_change_notifications'] = $this->request->post['email_file_change_notifications'];
        } else {
            $this->data['email_file_change_notifications'] = $this->config->get('security_email_file_change_notifications');
        }

        if (isset($this->request->post['email_file_change_address'])) {
            $this->data['email_file_change_address'] = $this->request->post['email_file_change_address'];
        } else {
            $this->data['email_file_change_address'] = $this->config->get('security_email_file_change_address');
        }

        if (isset($this->request->post['include_exclude_list'])) {
            $this->data['include_exclude_list'] = $this->request->post['include_exclude_list'];
        } else {
            $this->data['include_exclude_list'] = $this->config->get('security_include_exclude_list');
        }

        if (isset($this->request->post['check_list'])) {
            $this->data['check_list'] = $this->request->post['check_list'];
        } else {
            $this->data['check_list'] = $this->config->get('security_check_list');
        }

        if (isset($this->request->post['enable_login_limits'])) {
            $this->data['enable_login_limits'] = $this->request->post['enable_login_limits'];
        } else {
            $this->data['enable_login_limits'] = $this->config->get('security_enable_login_limits');
        }

        if (isset($this->request->post['max_login_attempts_host'])) {
            $this->data['max_login_attempts_host'] = $this->request->post['max_login_attempts_host'];
        } else {
            $this->data['max_login_attempts_host'] = $this->config->get('security_max_login_attempts_host');
        }

        if (isset($this->request->post['max_login_attempts_user'])) {
            $this->data['max_login_attempts_user'] = $this->request->post['max_login_attempts_user'];
        } else {
            $this->data['max_login_attempts_user'] = $this->config->get('security_max_login_attempts_user');
        }

        if (isset($this->request->post['login_time_period'])) {
            $this->data['login_time_period'] = $this->request->post['login_time_period'];
        } else {
            $this->data['login_time_period'] = $this->config->get('security_login_time_period');
        }

        if (isset($this->request->post['lockout_time_period'])) {
            $this->data['lockout_time_period'] = $this->request->post['lockout_time_period'];
        } else {
            $this->data['lockout_time_period'] = $this->config->get('security_lockout_time_period');
        }

        if (isset($this->request->post['blacklist_repeated_offender'])) {
            $this->data['blacklist_repeated_offender'] = $this->request->post['blacklist_repeated_offender'];
        } else {
            $this->data['blacklist_repeated_offender'] = $this->config->get('security_blacklist_repeated_offender');
        }

        if (isset($this->request->post['login_blacklist_threshold'])) {
            $this->data['login_blacklist_threshold'] = $this->request->post['login_blacklist_threshold'];
        } else {
            $this->data['login_blacklist_threshold'] = $this->config->get('security_login_blacklist_threshold');
        }

        if (isset($this->request->post['email_login_notifications'])) {
            $this->data['email_login_notifications'] = $this->request->post['email_login_notifications'];
        } else {
            $this->data['email_login_notifications'] = $this->config->get('security_email_login_notifications');
        }

        if (isset($this->request->post['email_login_address'])) {
            $this->data['email_login_address'] = $this->request->post['email_login_address'];
        } else {
            $this->data['email_login_address'] = $this->config->get('security_email_login_address');
        }

        if (isset($this->request->post['enable_away_mode'])) {
            $this->data['enable_away_mode'] = $this->request->post['enable_away_mode'];
        } else {
            $this->data['enable_away_mode'] = $this->config->get('security_enable_away_mode');
        }

        if (isset($this->request->post['type_of_restriction'])) {
            $this->data['type_of_restriction'] = $this->request->post['type_of_restriction'];
        } else {
            $this->data['type_of_restriction'] = $this->config->get('security_type_of_restriction');
        }

        if (isset($this->request->post['date_start'])) {
            $this->data['date_start'] = $this->request->post['date_start'];
        } else {
            $this->data['date_start'] = $this->config->get('security_date_start');
        }

        if (isset($this->request->post['date_end'])) {
            $this->data['date_end'] = $this->request->post['date_end'];
        } else {
            $this->data['date_end'] = $this->config->get('security_date_end');
        }

        if (isset($this->request->post['time_start'])) {
            $this->data['time_start'] = $this->request->post['time_start'];
        } else {
            $this->data['time_start'] = $this->config->get('security_time_start');
        }

        if (isset($this->request->post['time_end'])) {
            $this->data['time_end'] = $this->request->post['time_end'];
        } else {
            $this->data['time_end'] = $this->config->get('security_time_end');
        }

        if (isset($this->request->post['user_ids'])) {
            $this->data['user_ids'] = $this->request->post['user_ids'];
        } else {
            $this->data['user_ids'] = $this->config->get('security_user_ids') ? unserialize($this->config->get('security_user_ids')) : array();
        }

        if (isset($this->request->post['enable_db_email_backup'])) {
            $this->data['enable_db_email_backup'] = $this->request->post['enable_db_email_backup'];
        } else {
            $this->data['enable_db_email_backup'] = $this->config->get('security_enable_db_email_backup');
        }

        if (isset($this->request->post['backup_interval'])) {
            $this->data['backup_interval'] = $this->request->post['backup_interval'];
        } else {
            $this->data['backup_interval'] = $this->config->get('security_backup_interval') ? (int)$this->config->get('security_backup_interval') : 1;
        }

        if (isset($this->request->post['backup_interval_type'])) {
            $this->data['backup_interval_type'] = $this->request->post['backup_interval_type'];
        } else {
            $this->data['backup_interval_type'] = $this->config->get('security_backup_interval_type') === null ? 1 : (int)$this->config->get('security_backup_interval_type');
        }

        if (isset($this->request->post['email_backup_address'])) {
            $this->data['email_backup_address'] = $this->request->post['email_backup_address'];
        } else {
            $this->data['email_backup_address'] = $this->config->get('security_email_backup_address');
        }

        if (isset($this->request->post['enable_full_backup'])) {
            $this->data['enable_full_backup'] = $this->request->post['enable_full_backup'];
        } else {
            $this->data['enable_full_backup'] = $this->config->get('security_enable_full_backup');
        }

        if (isset($this->request->post['backup_full_interval'])) {
            $this->data['backup_full_interval'] = $this->request->post['backup_full_interval'];
        } else {
            $this->data['backup_full_interval'] = $this->config->get('security_backup_full_interval') ? (int)$this->config->get('security_backup_full_interval') : 1;
        }

        if (isset($this->request->post['backup_full_interval_type'])) {
            $this->data['backup_full_interval_type'] = $this->request->post['backup_full_interval_type'];
        } else {
            $this->data['backup_full_interval_type'] = $this->config->get('security_backup_full_interval_type') === null ? 2 : (int)$this->config->get('security_backup_full_interval_type');
        }

        if (isset($this->request->post['backup_include_exclude_list'])) {
            $this->data['backup_include_exclude_list'] = $this->request->post['backup_include_exclude_list'];
        } else {
            $this->data['backup_include_exclude_list'] = (int)$this->config->get('security_backup_include_exclude_list');
        }

        if (isset($this->request->post['backup_list'])) {
            $this->data['backup_list'] = $this->request->post['backup_list'];
        } else {
            $this->data['backup_list'] = $this->config->get('security_backup_list');
        }

        if (isset($this->request->post['ext_check_list'])) {
            $this->data['ext_check_list'] = $this->request->post['ext_check_list'];
        } else {
            $this->data['ext_check_list'] = $this->config->get('security_ext_check_list');
        }

        if (isset($this->request->post['backup_folder_id'])) {
            $this->data['backup_folder_id'] = $this->request->post['backup_folder_id'];
        } else {
            $this->data['backup_folder_id'] = $this->config->get('security_backup_folder_id');
        }

        if (isset($this->request->post['keep_backups'])) {
            $this->data['keep_backups'] = $this->request->post['keep_backups'];
        } else {
            $this->data['keep_backups'] = (int)$this->config->get('security_keep_backups');
        }

        $this->load->model('user/user');

        $this->data['users'] = $this->model_user_user->getUsers();

        $this->template = 'module/security.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/security')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function ignored($path) {
        if (in_array(strtolower(basename($path)), array('thumbs.db', 'desktop.ini', '.ds_store'))) {
            return true;
        }

        return false;
    }

    public function auth() {
        $this->load->model('module/security');

        if (!isset($this->request->get['state'])) {
            $this->model_module_security->editSettingValue('security', 'security_client_id', (isset($this->request->post['client_id']) ? $this->request->post['client_id'] : ''));
            $this->model_module_security->editSettingValue('security', 'security_client_secret', (isset($this->request->post['client_secret']) ? $this->request->post['client_secret'] : ''));

            $this->redirect('https://accounts.google.com/o/oauth2/auth?' . http_build_query(array(
                'response_type' => 'code',
                'client_id' => $this->request->post['client_id'],
                'redirect_uri' => html_entity_decode($this->url->link('module/security/auth', '', 'SSL'), ENT_COMPAT, 'UTF-8'),
                'scope' => 'https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/drive.file',
                'state' => 'token',
                'access_type' => 'offline',
            )));
        } else {
            $this->load->language('module/security');
            if ($this->request->get['state'] == 'token') {
                if (isset($this->request->get['code'])) {
                    $redirect_link = html_entity_decode($this->url->link('module/security/auth', '', 'SSL'), ENT_COMPAT, 'UTF-8');

                    $ch = curl_init() ;
                    curl_setopt($ch, CURLOPT_URL, "https://accounts.google.com/o/oauth2/token");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "code={$this->request->get['code']}&client_id={$this->config->get('security_client_id')}&client_secret={$this->config->get('security_client_secret')}&redirect_uri={$redirect_link}&grant_type=authorization_code");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HEADER, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

                    $response = curl_exec($ch);
                    $response = $this->parse_response($response);

                    curl_close($ch);

                    $refresh_token = json_decode($response['body']);
                    if (json_last_error() == JSON_ERROR_NONE && isset($refresh_token->refresh_token)) {
                        $refresh_token = $refresh_token->refresh_token ;
                    } else {
                        $refresh_token = false;
                    }

                    if ($refresh_token) {
                        $this->model_module_security->editSettingValue('security', 'security_gdrive_refresh_token', $refresh_token);
                    } else {
                        $this->session->data['error_warning'] = $this->language->get('error_refresh_token');
                    }
                } else {
                    $this->session->data['error_warning'] = $this->language->get('error_auth');
                }
            } elseif ($this->request->get['state'] == 'revoke') {
                $this->revoke();
            }

            $this->redirect($this->url->link('module/security', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }

    private function revoke() {
        $ch = curl_init() ;
        curl_setopt($ch, CURLOPT_URL, "https://accounts.google.com/o/oauth2/revoke?token=" . $this->config->get('security_gdrive_refresh_token'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);

        $this->model_module_security->editSettingValue('security', 'security_gdrive_refresh_token', '');
    }

    public function unlink() {
        $this->redirect($this->url->link('module/security/auth', 'token=' . $this->session->data['token'] . '&state=revoke', 'SSL'));
    }

    public function tree() {
        $root = dirname(DIR_APPLICATION);
        $key = empty($this->request->get['key']) ? '' : urldecode($this->request->get['key']);
        $checkbox = !empty($this->request->get['checkbox']);
        $path = $root . DIRECTORY_SEPARATOR . $key . DIRECTORY_SEPARATOR;
        $out = array();

        if (empty($this->request->get['list'])) {
            $list = array();
        } elseif ($this->request->get['list'] == 'backup_list') {
            $list = $this->config->get('security_backup_list') ? explode(', ', $this->config->get('security_backup_list')) : array();
        } elseif ($this->request->get['list'] == 'check_list') {
            $list = $this->config->get('security_check_list') ? explode(', ', $this->config->get('security_check_list')) : array();
        } else {
            $list = array();
        }

        if(file_exists($path) && is_readable($path)) {
            $files = scandir($path);
            natcasesort($files);
            if(count($files) > 2) {

                foreach ($files as $file) {
                    if (file_exists($path . $file) && $file != '.' && $file != '..' && is_dir($path . $file)) {
                        if (!is_readable($path . $file) || $this->ignored($file)) {
                            continue;
                        }

                        $_key = htmlentities($key . $file, ENT_QUOTES, "UTF-8") . DIRECTORY_SEPARATOR;
                        $_select = in_array($_key, $list);
                        $_class = '';

                        if (!$_select) {
                            foreach ($list as $_path) {
                                if (strlen($_path) > strlen($_key) && strpos($_path, $_key) === 0) {
                                    $_class = 'dynatree-partsel';
                                    break;
                                }
                            }
                        }

                        $out[] = (object)array(
                            'title' => htmlentities($file, ENT_QUOTES, "UTF-8"),
                            'key' => $_key,
                            'select' => ($checkbox || $_select) ? true : false,
                            'isFolder' => true,
                            'isLazy' => true,
                            'addClass' => $_class
                        );
                    }
                }

                foreach ($files as $file) {
                    if (file_exists($path . $file) && $file != '.' && $file != '..' && !is_dir($path . $file)) {
                        if (!is_readable($path . $file) || $this->ignored($file)) {
                            continue;
                        }

                        $_key = htmlentities($key . $file, ENT_QUOTES, "UTF-8");
                        $_select = in_array($_key, $list);

                        $out[] = (object)array(
                            'title' => htmlentities($file, ENT_QUOTES, "UTF-8"),
                            'key' => $_key,
                            'select' => ($checkbox || $_select) ? true : false
                        );
                    }
                }
            }
        }

        $this->response->setOutput(json_encode($out));
    }

    private function parse_response($data) {
        $response = array(
            'code' => -1,
            'headers' => array(),
            'body' => ''
        );

        $data = explode("\r\n", $data);

        $response['code'] = explode(' ', $data[0]);
        $response['code'] = $response['code'][1];

        for ($i = 1; $i < count($data); $i++) {
            $header = trim($data[$i]);

            if ($header) {
                if (substr_count($header, ':') > 0) {
                    $header = explode(':', $header, 2);
                    $response['headers'][strtolower($header[0])] = trim($header[1]);
                }
            } else {
                if(($i+1) < count($data)) {
                    for ($j = ($i+1); $j < count($data); $j++) {
                        $response['body'] .= $data[$j] . "\n";
                    }
                }
                break ;
            }
        }

        return $response;
    }

 private function init() {

	if (!$this->config->get('security_key')) {
    if ($this->request->server['REQUEST_METHOD'] == 'POST' && !empty($this->request->post['order_id']) && !empty($this->request->post['email']) && filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL))
     {
		//тут был всякий мусор проверки и стучалки

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $key = '';
        for ($i = 0; $i < 32; $i++) {
            $key .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        $this->load->model('setting/setting');
        $current_setting = $this->model_setting_setting->getSetting('security');
        if (!$current_setting) {
            $current_setting = array();
        }

        $new = array_merge($current_setting, array('security_key' => $key));
        $this->model_setting_setting->editSetting('security', $new);

        $this->redirect($this->url->link('module/security', 'token=' . $this->session->data['token'], 'SSL'));
    }

    $this->data['text_licence'] = $this->language->get('text_licence');
    $this->data['entry_order_id'] = $this->language->get('entry_order_id');
    $this->data['entry_email'] = $this->language->get('entry_email');
    $this->data['license'] = 1;

    $this->template = 'module/security.tpl';
    $this->children = array(
        'common/header',
        'common/footer',
    );

    $this->response->setOutput($this->render());
		}
    }

}