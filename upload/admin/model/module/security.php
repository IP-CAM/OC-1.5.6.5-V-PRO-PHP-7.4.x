<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class ModelModuleSecurity extends Model {

    public function install() {
        $query = <<<'QUERY'
            CREATE TABLE IF NOT EXISTS `%ssecurity_ban_list` (
              `ban_list_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `host` varchar(255) NOT NULL DEFAULT '',
              `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`ban_list_id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
QUERY;

        $this->db->query(sprintf($query, DB_PREFIX));

        $query = <<<'QUERY'
            CREATE TABLE IF NOT EXISTS `%ssecurity_lockout` (
              `lockout_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `type` tinyint(1) NOT NULL,
              `user_id` int(11) NOT NULL,
              `host` varchar(255) NOT NULL DEFAULT '',
              `start_time` datetime NOT NULL,
              `expire_time` datetime NOT NULL,
              PRIMARY KEY (`lockout_id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
QUERY;

        $this->db->query(sprintf($query, DB_PREFIX));

        $query = <<<'QUERY'
            CREATE TABLE IF NOT EXISTS `%ssecurity_log` (
              `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `type` tinyint(1) NOT NULL,
              `user_id` int(11) NOT NULL,
              `username` varchar(255) NOT NULL DEFAULT '',
              `host` varchar(255) NOT NULL DEFAULT '',
              `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `referrer` varchar(500) NOT NULL DEFAULT '',
              `url` varchar(500) NOT NULL DEFAULT '',
              `data` longtext NOT NULL,
              `used_memory` bigint(11) NOT NULL,
              `added` int(11) NOT NULL DEFAULT 0,
              `deleted` int(11) NOT NULL DEFAULT 0,
              `changed` int(11) NOT NULL DEFAULT 0,
              PRIMARY KEY (`log_id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
QUERY;

        $this->db->query(sprintf($query, DB_PREFIX));
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "security_ban_list`");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "security_lockout`");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "security_log`");
    }

    public function editSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "'");
        $setting_info = $query->row;

        if (version_compare(VERSION, '1.5.1') >= 0) {
            $serialized = ", serialized = '%s'";
        } else {
            $serialized = '';
        }

        if ($setting_info) {
            if (!is_array($value)) {
                $this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "'" . ($serialized ? sprintf($serialized, 0) : '') . " WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
            } else {
                $this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(serialize($value)) . "'" . ($serialized ? sprintf($serialized, 1) : '') . " WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
            }
        } else {
            if (!is_array($value)) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "'" . ($serialized ? sprintf($serialized, 1) : '') . "");
            }
        }
    }
}