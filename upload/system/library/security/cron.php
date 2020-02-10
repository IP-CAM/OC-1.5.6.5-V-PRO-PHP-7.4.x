<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class SecurityCron {
    private $registry;
    private $tasks;
    private $tasks_web;

    public function __construct($registry) {
        $this->registry = $registry;
        $this->tasks = array();

        $config = $registry->get('config');

        $registry->get('load')->model('module/security');
        $registry->get('language')->load('module/security_strings');

        $this->add_web('away');
        $this->add_web('login');

        $time = time();

        if ($config->get('security_enable_file_change_detection') &&
            $time >= $config->get('security_next_check')) {

            $this->add('change_detect');

            switch ((int)$config->get('security_check_interval_type')) {
                case 0:
                    $next_scan = 'hour';
                    break;
                case 1:
                    $next_scan = 'day';
                    break;
                case 2:
                    $next_scan = 'week';
                    break;
                default:
                    $next_scan = 'day';
            }
            $next_scan = strtotime('+' . ((int)$config->get('security_check_interval') ? (int)$config->get('security_check_interval') : 1) . ' ' . $next_scan);

            $registry->get('model_module_security')->editSettingValue('security', 'security_next_check', $next_scan);
        }

        if ($config->get('security_enable_db_email_backup') &&
            $config->get('security_email_backup_address') &&
            $time >= $config->get('security_next_email_backup')) {

            $this->add('email_backup');

            switch ((int)$config->get('security_backup_interval_type')) {
                case 0:
                    $next_backup = 'hour';
                    break;
                case 1:
                    $next_backup = 'day';
                    break;
                case 2:
                    $next_backup = 'week';
                    break;
                default:
                    $next_backup = 'day';
            }
            $next_backup = strtotime('+' . ((int)$config->get('security_backup_interval') ? (int)$config->get('security_backup_interval') : 1) . ' ' . $next_backup);

            $registry->get('model_module_security')->editSettingValue('security', 'security_next_email_backup', $next_backup);
        }

        if ($config->get('security_enable_full_backup') &&
            $config->get('security_gdrive_refresh_token') &&
            $time >= $config->get('security_next_gdrive_backup')) {

            $this->add('gdrive_backup');

            switch ((int)$config->get('security_backup_full_interval_type')) {
                case 0:
                    $next_backup = 'hour';
                    break;
                case 1:
                    $next_backup = 'day';
                    break;
                case 2:
                    $next_backup = 'week';
                    break;
                default:
                    $next_backup = 'day';
            }
            $next_backup = strtotime('+' . ((int)$config->get('security_backup_full_interval') ? (int)$config->get('security_backup_full_interval') : 1) . ' ' . $next_backup);

            $registry->get('model_module_security')->editSettingValue('security', 'security_next_gdrive_backup', $next_backup);
        }
    }

    public function run_web() {
        foreach ($this->tasks_web as $task) {
            if (is_callable(array($this, $task))) {
                call_user_func(array($this, $task));
            }
        }
    }

    public function run() {
        if (!$this->registry->get('config')->get('security_cron_configured')) {
            $this->registry->get('load')->model('module/security');
            $this->registry->get('model_module_security')->editSettingValue('security', 'security_cron_configured', 1);
        }

        foreach ($this->tasks as $task) {
            if (is_callable(array($this, $task))) {
                call_user_func(array($this, $task));
            }
        }

        exit;
    }

    private function add($task) {
        $this->tasks[] = $task;
    }

    private function add_web($task) {
        $this->tasks_web[] = $task;
    }

    private function change_detect() {
        require_once(DIR_SYSTEM . 'library/security/security.php');
        require_once(DIR_SYSTEM . 'library/security/change.php');

        $change = new SecurityChange($this->registry);
        $change->change_detect();
    }

    private function email_backup() {
        require_once(DIR_SYSTEM . 'library/security/security.php');
        require_once(DIR_SYSTEM . 'library/security/backup.php');

        $backup = new SecurityBackup($this->registry);
        $backup->email_backup();
    }

    private function gdrive_backup() {
        require_once(DIR_SYSTEM . 'library/security/security.php');
        require_once(DIR_SYSTEM . 'library/security/backup.php');

        $backup = new SecurityBackup($this->registry);
        $backup->gdrive_backup();
    }

    private function away() {
        require_once(DIR_SYSTEM . 'library/security/security.php');
        require_once(DIR_SYSTEM . 'library/security/away.php');

        $backup = new SecurityAwaySchedule($this->registry);
        $backup->away();
    }

    private function login() {
        require_once(DIR_SYSTEM . 'library/security/security.php');
        require_once(DIR_SYSTEM . 'library/security/login.php');

        $backup = new SecurityLogin($this->registry);
        $backup->login();
    }

}
