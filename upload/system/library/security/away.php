<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class SecurityAwaySchedule extends SecurityBase {

    public function away() {
        if ($this->config->get('security_enable_away_mode') && defined(HTTP_CATALOG)) {
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

            if ($this->config->get('security_type_of_restriction')) {
                $date_start = $this->config->get('security_date_start') . ' ' . $this->config->get('security_time_start');
                $date_end = $this->config->get('security_date_end') . ' ' . $this->config->get('security_time_end');
            } else {
                $date_start = date('Y-m-d') . ' ' . $this->config->get('security_time_start');
                $date_end = date('Y-m-d') . ' ' . $this->config->get('security_time_end');
            }

            $now = time();

            if (($now >= strtotime($date_start)) && ($now <= strtotime($date_end))) {
                $log = new Log('security/away.log');

                if ($this->user->isLogged()) {
                    $log->write(sprintf($this->language->get('text_security_away_kicked'), $this->user->getUserName()));
                    $this->user->logout();
                } elseif ($route == 'common/login' && ($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                    $log->write(sprintf($this->language->get('text_security_away_active'), $this->request->post['username']));
                }

                if (empty($this->session->data['success']) || $this->session->data['success'] !== $this->language->get('text_security_away')) {
                    $this->session->data['success'] = $this->language->get('text_security_away');
                    $url = new Url(HTTP_SERVER, $this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER);
                    header('Location: ' . $url->link('common/login', '', 'SSL'));
                    exit;
                }
            }
        }
    }

    protected function validate() {
        if (isset($this->request->post['username']) && isset($this->request->post['password'])) {
            $result = $this->check_auth($this->request->post['username'], $this->request->post['password']);
            $users = $this->config->get('security_user_ids') ? unserialize($this->config->get('security_user_ids')) : array();
            return $result && !in_array($this->user->getId(), $users);
        } else {
            return false;
        }
    }

    protected function check_auth($username, $password) {
        $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
        return $user_query->num_rows;
    }

}
