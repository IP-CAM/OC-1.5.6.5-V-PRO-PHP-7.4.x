<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class SecurityLogin extends SecurityBase {

    public function login() {
        if ($this->config->get('security_enable_login_limits')) {

            if (empty($this->request->server['REMOTE_ADDR'])) {
                $this->request->server['REMOTE_ADDR'] = '';
            }

            if (empty($this->request->server['HTTP_REFERER'])) {
                $this->request->server['HTTP_REFERER'] = '';
            }

            if (empty($this->request->server['HTTP_HOST'])) {
                $this->request->server['HTTP_HOST'] = '';
            }

            if (empty($this->request->server['REQUEST_URI'])) {
                $this->request->server['REQUEST_URI'] = '';
            }

            $route = '';

            if (isset($this->request->get['route'])) {
                $part = explode('/', $this->request->get['route']);

                if (isset($part[0])) {
                    $route .= $part[0];
                }

                if (isset($part[1])) {
                    $route .= '/' . $part[1];
                }
            }

            if ($route == 'common/login' && ($this->request->server['REQUEST_METHOD'] == 'POST')) {
                $username = empty($this->request->post['username']) ? '' : $this->request->post['username'];

                if ($this->check_lock($username)) {
                    $this->session->data['success'] = $this->language->get('text_security_login_lockout');
                    $url = new Url(HTTP_SERVER, $this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER);
                    header('Location: ' . $url->link('common/login', '', 'SSL'));
                    exit;
                }

                if (!$this->validate()) {
                    if (!empty($this->request->post['username'])) {
                        $this->log_event($this->request->post['username']);
                    } else {
                        $this->log_event();
                    }
                }
            }
        }
    }

    protected function validate() {
        if (isset($this->request->post['username']) && isset($this->request->post['password'])) {
            return $this->check_auth($this->request->post['username'], $this->request->post['password']);
        } else {
            return false;
        }
    }

    protected function check_auth($username, $password) {
        $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
        return $user_query->num_rows;
    }

    protected function check_lock($username = '') {
        $user_check = false;

        if ($username) {
            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE username = '" . $this->db->escape($username) . "'");

            if ($query->row) {
                $user_check = $this->db->query("SELECT `user_id` FROM `" . DB_PREFIX . "security_lockout` WHERE `expire_time` > NOW() AND `user_id` = '" . (int)$query->row['user_id'] . "'")->num_rows;
            }
        } else {
            $user_check = false;
        }

        $host_check = $this->db->query("SELECT `host` FROM `" . DB_PREFIX . "security_lockout` WHERE `expire_time` > NOW() AND `host` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'")->num_rows;

        if (!$user_check && !$host_check) {
            return false;
        } else {
            return true;
        }
    }

    protected function log_event($username = '') {
        $period = $this->config->get('security_login_time_period') * 60;

        if ($username) {
            $user = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE username = '" . $this->db->escape($username) . "'")->row;
        } else {
            $user = false;
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "security_log SET `type` = '1', `host` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `user_id` = '" . (int)($user ? $user['user_id'] : 0) . "', username = '" . $this->db->escape($username) . "'");

        if ($user) {
            $query = $this->db->query("SELECT COUNT(*) as `total` FROM `" . DB_PREFIX . "security_log` WHERE `type` = '1' AND `user_id` = '" . (int)$user['user_id'] . "' AND `timestamp` > FROM_UNIXTIME(" . (int)(time() - $period) . ")");
            $user_count = $query->row['total'];
        } else {
            $user_count = 0;
        }

        $query = $this->db->query("SELECT COUNT(*) as `total` FROM `" . DB_PREFIX . "security_log` WHERE `type` = '1' AND `host` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' AND `timestamp` > FROM_UNIXTIME(" . (int)(time() - $period) . ")");
        $host_count = $query->row['total'];

        if ($this->config->get('security_max_login_attempts_user') && $user_count >= $this->config->get('security_max_login_attempts_user')) {
            $this->lockout($user);
        } elseif ($this->config->get('security_max_login_attempts_host') && $host_count >= $this->config->get('security_max_login_attempts_host')) {
            $this->lockout();
        }
    }

    protected function lockout($user = false) {
        $now = time();
        $expire_time = $now + (60 * $this->config->get('security_lockout_time_period'));

        if ($user) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "security_lockout SET `type` = '1', `start_time` = FROM_UNIXTIME(" . (int)$now . "), `expire_time` = FROM_UNIXTIME(" . (int)$expire_time . "), `host` = '0', `user_id` = '" . (int)$user['user_id'] . "'");
        }

        if (filter_var($this->request->server['REMOTE_ADDR'], FILTER_VALIDATE_IP) && $this->config->get('security_blacklist_repeated_offender')) {
            $lock_limit = $this->config->get('security_login_blacklist_threshold');
            $lock_count = $this->db->query("SELECT COUNT(*) as `total` FROM `" . DB_PREFIX . "security_lockout` WHERE `type` = '1' AND `host` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'")->row['total'] + 1;
        } else {
            $lock_limit = false;
            $lock_count = 0;
        }

        $ban = false;

        if ($lock_limit !== false && $lock_count >= $lock_limit) {
            $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "security_ban_list SET `host` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
            $ban = true;
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "security_lockout SET `type` = '1', `start_time` = FROM_UNIXTIME(" . (int)$now . "), `expire_time` = FROM_UNIXTIME(" . (int)$expire_time . "), `host` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `user_id` = '0'");

        if ($this->config->get('security_email_login_notifications') && $this->config->get('security_email_login_address')) {
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');

            $mail->setTo($this->config->get('security_email_login_address'));
            $mail->setFrom($this->config->get('config_email'));

            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject(sprintf($this->language->get('text_security_login_notify_subject'), $this->config->get('config_name')));

            if ($user) {
                $who = sprintf($this->language->get('text_security_notify_user'), $user['username'], $this->request->server['REMOTE_ADDR']);
            } else {
                $who = sprintf($this->language->get('text_security_notify_host'), $this->request->server['REMOTE_ADDR'], $this->request->server['REMOTE_ADDR']);
            }

            if ($ban) {
                $duration = $this->language->get('text_security_notify_ban');
            } else {
                $duration = sprintf($this->language->get('text_security_notify_until'), date('Y-m-d H:i:s', $expire_time));
            }

            $mail->setText(sprintf($this->language->get('text_security_login_notify_text'), $who, $duration));
            $mail->send();
        }
    }

}