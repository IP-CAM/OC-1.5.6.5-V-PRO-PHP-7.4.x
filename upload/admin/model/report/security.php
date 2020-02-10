<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class ModelReportSecurity extends Model {
    public function getAttempts($data = array()) {
        $sql = "SELECT MIN(`timestamp`) AS date_start, MAX(`timestamp`) AS date_end, `username`, `host`, COUNT(log_id) AS `attempts`, `timestamp` FROM `" . DB_PREFIX . "security_log` WHERE `type` = '1'";

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(`timestamp`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(`timestamp`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }

        if (!empty($data['filter_group'])) {
            $group = $data['filter_group'];
        } else {
            $group = 'none';
        }

        switch($group) {
            case 'username':
                $sql .= " GROUP BY `username`";
                break;
            case 'host':
                $sql .= " GROUP BY `host`";
                break;
            default:
                $sql .= " GROUP BY `log_id`";
                break;
        }

        $sql .= " ORDER BY `timestamp` DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalAttempts($data = array()) {
        if (!empty($data['filter_group'])) {
            $group = $data['filter_group'];
        } else {
            $group = 'none';
        }

        switch($group) {
            case 'username':
                $sql = "SELECT COUNT(DISTINCT `username`) AS total FROM `" . DB_PREFIX . "security_log` WHERE `type` = '1'";
                break;
            case 'host':
                $sql = "SELECT COUNT(DISTINCT `host`) AS total FROM `" . DB_PREFIX . "security_log` WHERE `type` = '1'";
                break;
            default:
                $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "security_log` WHERE `type` = '1'";
                break;
        }

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(`timestamp`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(`timestamp`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function get404($data = array()) {
        $sql = "SELECT MIN(`timestamp`) AS date_start, MAX(`timestamp`) AS date_end, `url`, `host`, COUNT(log_id) AS `attempts`, `timestamp` FROM `" . DB_PREFIX . "security_log` WHERE `type` = '2'";

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(`timestamp`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(`timestamp`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }

        if (!empty($data['filter_group'])) {
            $group = $data['filter_group'];
        } else {
            $group = 'none';
        }

        switch($group) {
            case 'url_host':
                $sql .= " GROUP BY `url`, `host`";
                break;
            default:
                $sql .= " GROUP BY `log_id`";
                break;
        }

        $sql .= " ORDER BY `timestamp` DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotal404($data = array()) {
        if (!empty($data['filter_group'])) {
            $group = $data['filter_group'];
        } else {
            $group = 'none';
        }

        switch($group) {
            case 'url_host':
                $sql = "SELECT COUNT(DISTINCT `url`, `host`) AS total FROM `" . DB_PREFIX . "security_log` WHERE `type` = '2'";
                break;
            default:
                $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "security_log` WHERE `type` = '2'";
                break;
        }

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(`timestamp`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(`timestamp`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getFileChange($log_id) {
        $result = $this->db->query("SELECT `data` FROM `" . DB_PREFIX . "security_log` WHERE `log_id` = '" . (int)$log_id . "'")->row;

        return $result ? unserialize($result['data']) : array();
    }

    public function getFileChanges($data = array()) {
        $sql = "SELECT `log_id`, `timestamp`, `added`, `deleted`, `changed`, `used_memory` FROM `" . DB_PREFIX . "security_log` WHERE `type` = '3'";

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(`timestamp`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(`timestamp`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }

        $sql .= " ORDER BY `timestamp` DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalFileChanges($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "security_log` WHERE `type` = '3'";

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(`timestamp`) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(`timestamp`) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function deleteHost($ban_list_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "security_ban_list WHERE ban_list_id = '" . (int)$ban_list_id . "'");

        if ($query->row) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "security_ban_list WHERE ban_list_id = '" . (int)$ban_list_id . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "security_lockout WHERE host = '" . (int)$query->row['host'] . "'");
        }
    }

    public function getHosts($data) {
        $sql = "SELECT * FROM " . DB_PREFIX . "security_ban_list GROUP BY ban_list_id ORDER BY ban_list_id DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalHosts() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "security_ban_list");

        return $query->row['total'];
    }

    public function deleteLockouts($lockout_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "security_lockout WHERE lockout_id = '" . (int)$lockout_id . "'");
    }

    public function getLockouts($data) {
        $sql = "SELECT * FROM " . DB_PREFIX . "security_lockout GROUP BY lockout_id ORDER BY lockout_id DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalLockouts() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "security_lockout");

        return $query->row['total'];
    }

}