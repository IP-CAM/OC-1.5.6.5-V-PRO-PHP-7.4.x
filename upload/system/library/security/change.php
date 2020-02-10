<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class SecurityChange extends SecurityBase {

    protected $start_mem;
    protected $max_mem;
    protected $registry;

    public function __construct($registry) {
        parent::__construct($registry);

        $this->start_mem = @memory_get_usage();
        $this->max_mem = $this->start_mem;

        $this->registry = $registry;
    }

    public function change_detect() {
        $this->registry->get('load')->model('module/security');

        $this->language->load('module/security_strings');

        if (file_exists(DIR_LOGS . 'security/last_changes.log')) {
            $last_check = file_get_contents(DIR_LOGS . 'security/last_changes.log');
            $first_check = false;
        } else {
            $last_check = false;
            $first_check = true;
        }

        $last_check = $last_check ? unserialize($last_check) : array();

        $check = $this->check();

        $files_added = @array_diff_assoc($check, $last_check);
        $files_deleted = @array_diff_assoc($last_check, $check);

        $check_current = @array_diff_key($check, $files_added);
        $check_last = @array_diff_key($last_check, $files_deleted);

        $files_changed = array();

        foreach ($check_current as $file => $attribute) {
            if (array_key_exists($file, $check_last)) {
                if (strcmp($attribute['mod_date'], $check_last[$file]['mod_date']) != 0 || strcmp($attribute['hash'], $check_last[$file]['hash']) != 0) {
                    $files_changed[$file]['hash'] = $attribute['hash'];
                    $files_changed[$file]['mod_date'] = $attribute['mod_date'];
                }
            }
        }

        $combined = array(
            'added' => $files_added,
            'deleted' => $files_deleted,
            'changed' => $files_changed
        );

        file_put_contents(DIR_LOGS . 'security/last_changes.log', serialize($check));

        if (!$first_check) {

            if (count($files_added) || count($files_deleted) || count($files_changed)) {
                $this->db->query("INSERT INTO `" . DB_PREFIX . "security_log` SET `type` = '3', `data` = '" . $this->db->escape(serialize($combined)) . "', `added` = '" . (int)count($files_added) . "', `deleted` = '" . (int)count($files_deleted) . "', `changed` = '" . (int)count($files_changed) . "'");
                $log_id = $this->db->getLastId();
            } else {
                $log_id = false;
            }

            if ($this->config->get('security_last_change_check')) {
                if (count($combined['added']) || count($combined['deleted']) || count($combined['changed'])) {
                    $this->registry->get('model_module_security')->editSettingValue('security', 'security_change_warning', 1);
                    if ($this->config->get('security_email_file_change_notifications') && $this->config->get('security_email_file_change_address')) {
                        $mail = new Mail();
                        $mail->protocol = $this->config->get('config_mail_protocol');
                        $mail->parameter = $this->config->get('config_mail_parameter');
                        $mail->hostname = $this->config->get('config_smtp_host');
                        $mail->username = $this->config->get('config_smtp_username');
                        $mail->password = $this->config->get('config_smtp_password');
                        $mail->port = $this->config->get('config_smtp_port');
                        $mail->timeout = $this->config->get('config_smtp_timeout');

                        $mail->setTo($this->config->get('security_email_file_change_address'));
                        $mail->setFrom($this->config->get('config_email'));

                        $mail->setSender($this->config->get('config_name'));
                        $mail->setSubject(sprintf($this->language->get('text_security_change_subject'), $this->config->get('config_name')));

                        $message = $this->language->get('text_security_change_text');
                        $message .= $this->report($log_id);

                        $mail->setHtml($message);
                        $mail->send();
                    }
                }

                $max_mem = @memory_get_peak_usage();
                if ($max_mem > $this->max_mem) {
                    $this->max_mem = $max_mem;
                }

                if ($log_id !== false) {
                    $this->db->query("UPDATE `" . DB_PREFIX . "security_log` SET `used_memory` = '" . $this->db->escape($this->max_mem - $this->start_mem) . "' WHERE `log_id` = '" . (int)$log_id . "'");
                }
            }
        }

        $this->registry->get('model_module_security')->editSettingValue('security', 'security_last_change_check', time());
    }

    private function check() {
        $data = array();
        $source = dirname(DIR_APPLICATION);

        $check_list = explode(',', $this->config->get('security_check_list'));
        $check_list = array_map('trim', $check_list);

        $ext_check_list = explode(',', $this->config->get('security_ext_check_list'));
        $ext_check_list = array_map('strtolower', $ext_check_list);
        $ext_check_list = array_map('trim', $ext_check_list);

        if (is_dir($source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = realpath($file);
                $relative_path = str_replace($source . '/', '', $file);

                if (!$this->check_path($relative_path, $check_list, $ext_check_list)) {
                    continue;
                }

                if (is_file($file) === true) {
                    $data[$relative_path] = array();
                    $data[$relative_path]['mod_date'] = @filemtime($file);
                    $data[$relative_path]['hash'] = @md5_file($file);
                }
            }
        }

        return $data;
    }

    private function report($log_id) {
        $changes = $this->db->query("SELECT * FROM `" . DB_PREFIX . "security_log` WHERE `log_id` = '" . (int)$log_id . "'")->row;

        if (!$changes) {
            return false;
        }

        $max_mem = @memory_get_peak_usage();
        if ($max_mem > $this->max_mem) {
            $this->max_mem = $max_mem;
        }

        $data = unserialize($changes['data']);

        $report = '<strong>' . $this->language->get('entry_security_scan_time') . '</strong> ' . date('Y-m-d H:i:s', strtotime($changes['timestamp'])) . "<br />" . PHP_EOL;
        $report .= '<strong>' . $this->language->get('entry_security_files_added') . '</strong> ' . count($data['added']) . "<br />" . PHP_EOL;
        $report .= '<strong>' . $this->language->get('entry_security_files_deleted') . '</strong> ' . count($data['deleted']) . "<br />" . PHP_EOL;
        $report .= '<strong>' . $this->language->get('entry_security_files_changed') . '</strong> ' . count($data['changed']) . "<br />" . PHP_EOL;
        $report .= '<strong>' . $this->language->get('entry_security_memory_used') . '</strong> ' . round((($this->max_mem - $this->start_mem) / 1000000), 2) . " MB<br />" . PHP_EOL;

        $report .= '<h3>' . $this->language->get('text_security_files_added') . '</h3>';
        $report .= '<table border="1" style="width:100%;">' . PHP_EOL;
        $report .= '    <tr>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_file') . '</th>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_modified') . '</th>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_file_hash') . '</th>' . PHP_EOL;
        $report .= '    </tr>' . PHP_EOL;

        if ($data['added']) {
            foreach ($data['added'] as $file => $attribute) {
                $report .= '    <tr>' . PHP_EOL;
                $report .= '        <td>' . $file . '</td>' . PHP_EOL;
                $report .= '        <td>' . date('Y-m-d H:i:s', $attribute['mod_date']) . '</td>' . PHP_EOL;
                $report .= '        <td>' . $attribute['hash'] . '</td>' . PHP_EOL;
                $report .= '    </tr>' . PHP_EOL;
            }
        } else {
            $report .= '    <tr>' . PHP_EOL;
            $report .= '        <td colspan="3">' . $this->language->get('text_security_no_files_added') . '</td>' . PHP_EOL;
            $report .= '    </tr>' . PHP_EOL;
        }

        $report .= '</table>' . PHP_EOL;

        $report .= '<h3>' . $this->language->get('text_security_files_deleted') . '</h3>';
        $report .= '<table border="1" style="width:100%;">' . PHP_EOL;
        $report .= '    <tr>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_file') . '</th>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_modified') . '</th>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_file_hash') . '</th>' . PHP_EOL;
        $report .= '    </tr>' . PHP_EOL;

        if ($data['deleted']) {
            foreach ($data['deleted'] as $file => $attribute) {
                $report .= '    <tr>' . PHP_EOL;
                $report .= '        <td>' . $file . '</td>' . PHP_EOL;
                $report .= '        <td>' . date('Y-m-d H:i:s', $attribute['mod_date']) . '</td>' . PHP_EOL;
                $report .= '        <td>' . $attribute['hash'] . '</td>' . PHP_EOL;
                $report .= '    </tr>' . PHP_EOL;
            }
        } else {
            $report .= '    <tr>' . PHP_EOL;
            $report .= '        <td colspan="3">' . $this->language->get('text_security_no_files_deleted') . '</td>' . PHP_EOL;
            $report .= '    </tr>' . PHP_EOL;
        }

        $report .= '</table>' . PHP_EOL;

        $report .= '<h3>' . $this->language->get('text_security_files_changed') . '</h3>';
        $report .= '<table border="1" style="width:100%;">' . PHP_EOL;
        $report .= '    <tr>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_file') . '</th>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_modified') . '</th>' . PHP_EOL;
        $report .= '        <th>' . $this->language->get('text_security_file_hash') . '</th>' . PHP_EOL;
        $report .= '    </tr>' . PHP_EOL;

        if ($data['changed']) {
            foreach ($data['changed'] as $file => $attribute) {
                $report .= '    <tr>' . PHP_EOL;
                $report .= '        <td>' . $file . '</td>' . PHP_EOL;
                $report .= '        <td>' . date('Y-m-d H:i:s', $attribute['mod_date']) . '</td>' . PHP_EOL;
                $report .= '        <td>' . $attribute['hash'] . '</td>' . PHP_EOL;
                $report .= '    </tr>' . PHP_EOL;
            }
        } else {
            $report .= '    <tr>' . PHP_EOL;
            $report .= '        <td colspan="3">' . $this->language->get('text_security_no_files_changed') . '</td>' . PHP_EOL;
            $report .= '    </tr>' . PHP_EOL;
        }

        $report .= '</table>' . PHP_EOL;

        return $report;
    }

    private function check_path($path, $check_list, $ext_check_list) {
        $result = !$this->config->get('security_include_exclude_list');

        if ($this->ends_with($path, '/.') || $this->ends_with($path, '/..') || $path == '.' || $path == '..') {
            return false;
        }

        if (is_file($path)) {
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            if (in_array('.' . strtolower($ext), $ext_check_list)) {
                return false;
            }
        }

        if (in_array($path, $check_list) || in_array($path . '/', $check_list)) {
            return $result;
        }

        foreach ($check_list as $entry) {
            if (strpos($path, '/') !== false && $this->starts_with($path, $entry)) {
                return $result;
            }
        }

        return !$result;
    }

    private function starts_with($haystack, $needle) {
        return (substr($haystack, 0, strlen($needle)) === $needle);
    }

    private function ends_with($haystack, $needle) {
        return (substr($haystack, -strlen($needle)) === $needle);
    }

}


