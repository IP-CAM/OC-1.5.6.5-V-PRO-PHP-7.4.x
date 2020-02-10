<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class SecurityBackup extends SecurityBase {

    private $log;
    private $access_token;
    private $mime_type;

    public function __construct($registry) {
        parent::__construct($registry);

        $this->mime_type = 'application/zip';

        if (!is_dir(DIR_CACHE . 'security')) {
            mkdir(DIR_CACHE . 'security', 0755, true);
        }
    }

    public function email_backup() {
        if (file_exists(DIR_LOGS . 'security/email_backup.log')) {
            unlink(DIR_LOGS . 'security/email_backup.log');
        }

        $this->log = new Log('security/email_backup.log');

        $database = $this->backup_database();
        if ($database) {
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');

            $mail->setTo($this->config->get('security_email_backup_address'));
            $mail->setFrom($this->config->get('config_email'));

            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject(sprintf($this->language->get('text_security_backup_notify_subject'), $this->config->get('config_name')));

            $mail->setText(date('Y-m-d H:i:s'));

            $mail->addAttachment($database);
            $mail->send();
        }

        if (file_exists($database)) {
            unlink($database);
        }
    }

    public function gdrive_backup() {
        if (file_exists(DIR_LOGS . 'security/full_backup.log')) {
            unlink(DIR_LOGS . 'security/full_backup.log');
        }

        $this->log = new Log('security/full_backup.log');

        if ($this->config->get('security_enable_full_backup') && $this->config->get('security_gdrive_refresh_token')) {
            $this->access_token = $this->get_access_token();
            if ($this->access_token) {
                $file_name = $this->backup_files();
                if ($file_name) {
                    $chunk_size = 256 * 1024 * 2;

                    $location = $this->create_google_file($file_name);

                    $file_size = filesize($file_name);

                    $this->log->write(sprintf($this->language->get('text_security_backup_uploading'), basename($file_name)));
                    $this->log->write(sprintf($this->language->get('text_security_backup_file_size'), (string)round($file_size / pow(1024, 2), 2)));
                    $this->log->write(sprintf($this->language->get('text_security_backup_chunk_size'), (string)round($chunk_size / pow(1024, 2), 2)));

                    $last_response_code = false;
                    $final_output = null;
                    $last_range = false;
                    $transaction_counter = 0;
                    $average_upload_speed = 0;
                    $do_exponential_backoff = false;
                    $exponential_backoff_counter = 0;

                    while ($last_response_code === false || $last_response_code == '308') {
                        $transaction_counter++;

                        $this->log->write(sprintf($this->language->get('text_security_backup_request'), $transaction_counter));

                        if ($do_exponential_backoff) {
                            $sleep_for = pow(2, $exponential_backoff_counter);

                            $this->log->write(sprintf($this->language->get('text_security_backup_backoff'), $sleep_for));

                            sleep($sleep_for);
                            usleep(rand(0, 1000));

                            $exponential_backoff_counter++;

                            if ($exponential_backoff_counter > 5) {
                                $this->log->write($this->language->get('text_security_backup_backoff_limit'));
                                if (file_exists($file_name)) {
                                    unlink($file_name);
                                }
                                return;
                            }
                        }

                        $range_start = 0;
                        $range_end = min($chunk_size, $file_size - 1);

                        if ($last_range !== false) {
                            $last_range = explode('-', $last_range);
                            $range_start = (int)$last_range[1] + 1;
                            $range_end = min($range_start + $chunk_size, $file_size - 1);
                        }

                        $this->log->write(sprintf($this->language->get('text_security_backup_uploaded'), round(100 * $range_end / $file_size), $range_start . '-' . $range_end, $file_size));

                        $to_send = file_get_contents($file_name, false, NULL, $range_start, ($range_end - $range_start + 1));

                        $ch = curl_init() ;
                        curl_setopt($ch, CURLOPT_URL, "{$location}");
                        curl_setopt($ch, CURLOPT_PORT, 443);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $to_send);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            "Authorization: Bearer {$this->access_token}",
                            "Content-Length: " . (string)($range_end - $range_start + 1),
                            "Content-Type: {$this->mime_type}",
                            "Content-Range: bytes {$range_start}-{$range_end}/{$file_size}"
                        ));

                        $response = $this->parse_response($ch);
                        $do_exponential_backoff = false;

                        if ($response['code']) {
                            if ($response['code'] == '401') {
                                $this->log->write($this->language->get('text_security_backup_expired'));
                                $this->access_token = $this->get_access_token();
                                $last_response_code = false;
                            } elseif ($response['code'] == '308') {
                                $last_response_code = $response['code'];
                                $last_range = $response['headers']['range'];
                                $exponential_backoff_counter = 0;
                            } elseif ($response['code'] == '503') {
                                $do_exponential_backoff = true;
                                $last_response_code = false;
                            } elseif ($response['code'] == '200') {
                                $last_response_code = $response['code'];
                                $final_output = $response;
                            } else {
                                $this->log->write($this->language->get('text_security_backup_bad'));
                                $this->log->write(sprintf($this->language->get('text_security_backup_response'), print_r($response, true)));

                                if (file_exists($file_name)) {
                                    unlink($file_name);
                                }
                                return;
                            }

                            $average_upload_speed += (int)$response['info']['speed_upload'];
                        } else {
                            $do_exponential_backoff = true;
                            $last_response_code = false;
                        }
                    }

                    if ($last_response_code != '200') {
                        $this->log->write($this->language->get('text_security_backup_bad'));
                        $this->log->write(sprintf($this->language->get('text_security_backup_response'), print_r($response, true)));

                        if (file_exists($file_name)) {
                            unlink($file_name);
                        }
                        return;
                    }

                    $this->log->write($this->language->get('text_security_backup_done'));
                    $this->log->write(sprintf($this->language->get('text_security_backup_speed'), (string)round($average_upload_speed / pow(1024, 2), 2)));

                    $final_output = json_decode($final_output['body']);

                    $this->log->write($this->language->get('text_security_backup_md5'));

                    $result = md5_file($file_name);
                    if($result != $final_output->md5Checksum) {
                        $this->log->write(sprintf($this->language->get('text_security_backup_md5_bad'), $result, $final_output->md5Checksum));
                        if (file_exists($file_name)) {
                            unlink($file_name);
                        }
                        return;
                    } else {
                        $this->log->write($this->language->get('text_security_backup_md5_ok'));
                    }

                    if (file_exists($file_name)) {
                        unlink($file_name);
                    }

                    if ($this->config->get('security_keep_backups')) {
                        if (file_exists(DIR_LOGS . 'security/last_backups.log')) {
                            $last_backups = file_get_contents(DIR_LOGS . 'security/last_backups.log');
                        } else {
                            $last_backups = false;
                        }

                        $last_backups = $last_backups ? unserialize($last_backups) : array();

                        array_unshift($last_backups, $final_output->id);

                        if (count($last_backups) > (int)$this->config->get('security_keep_backups')) {
                            $to_delete = array_pop($last_backups);
                            $this->delete_google_file($to_delete);
                        }

                        file_put_contents(DIR_LOGS . 'security/last_backups.log', serialize($last_backups));
                    }
                }
            }
        }
    }

    private function backup_database() {
        $tables = array();

        $query = $this->db->query('SHOW TABLES FROM `' . DB_DATABASE . '`');

        foreach ($query->rows as $result) {
            if (isset($result['Tables_in_' . DB_DATABASE]) && utf8_substr($result['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
                $tables[] = $result['Tables_in_' . DB_DATABASE];
            }
        }

        $source = DIR_CACHE . 'security/db-backup-' . time() . '.sql';
        $handle = fopen($source, 'w+');

        foreach ($tables as $table) {
            fwrite($handle, 'DROP TABLE IF EXISTS `' . $table . '`;' . "\n\n");
            $query = $this->db->query('SHOW CREATE TABLE `' . $table . '`');
            list($row) = array_values(array_slice($query->row, 1, 1));
            fwrite($handle, $row . ";\n\n");

            $query = $this->db->query('SELECT COUNT(*) AS total FROM `' . $table . '`');
            $total_rows = $query->row['total'];

            $current_row = 0;
            while ($current_row < $total_rows) {
                $query = $this->db->query('SELECT * FROM `' . $table . '` LIMIT ' . $current_row . ', 20');

                foreach ($query->rows as $result) {
                    $fields = '';

                    foreach (array_keys($result) as $value) {
                        $fields .= '`' . $value . '`, ';
                    }

                    $values = '';

                    foreach (array_values($result) as $value) {
                        $value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
                        $value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
                        $value = str_replace('\\', '\\\\', $value);
                        $value = str_replace('\'', '\\\'', $value);
                        $value = str_replace('\\\n', '\n', $value);
                        $value = str_replace('\\\r', '\r', $value);
                        $value = str_replace('\\\t', '\t', $value);
                        $values .= '\'' . $value . '\', ';
                    }

                    fwrite($handle, 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n");
                }

                $current_row += $query->num_rows;
            }

            fwrite($handle, "\n\n");
        }

        fclose($handle);

        if (extension_loaded('zip') === true) {
            if (file_exists($source) === true) {
                $destination = $source . '.zip';

                $zip = new ZipArchive();

                if ($zip->open($destination, ZIPARCHIVE::CREATE) === true) {
                    $source = realpath($source);

                    if (is_file($source) === true) {
                        $zip->addFile($source, basename($source));
                    }
                }

                if ($zip->close()) {
                    if (file_exists($source)) {
                        unlink($source);
                    }
                    return $destination;
                } else {
                    $this->log->write($this->language->get('text_security_backup_arch_error'));
                    return $source;
                }
            } else {
                $this->log->write(sprintf($this->language->get('text_security_backup_not_exists'), $source));
                return false;
            }
        } else {
            $this->log->write($this->language->get('text_security_backup_zip_error_db'));
        }

        return $source;
    }

    private function backup_files() {
        $source = dirname(DIR_APPLICATION);
        $destination = DIR_CACHE . 'security/backup-' . time() . '.zip';

        if (extension_loaded('zip') === true) {
            if (file_exists($source) === true) {
                $zip = new ZipArchive();

                $this->log->write(sprintf($this->language->get('text_security_backup_creating'), basename($destination)));
                if ($zip->open($destination, ZIPARCHIVE::CREATE) === true) {
                    $source = realpath($source);

                    $backup_list = explode(',', $this->config->get('security_backup_list'));
                    $backup_list = array_map('trim', $backup_list);

                    if (is_dir($source) === true) {
                        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

                        $files_processed = 0;
                        foreach ($files as $file) {
                            $file = realpath($file);
                            $relative_path = str_replace($source . '/', '', $file);

                            if (!$this->check_path($relative_path, $backup_list)) {
                                continue;
                            }

                            if (is_dir($file) === true) {
                                $zip->addEmptyDir($relative_path . '/');
                            } else if (is_file($file) === true) {
                                $zip->addFile($file, $relative_path);
                            }

                            $files_processed++;

                            if ($files_processed > 200) {
                                if ($zip->close() && $zip = new ZipArchive()) {
                                    $zip->open($destination);
                                    $files_processed = 0;
                                }
                            }
                        }

                        $database = $this->backup_database();
                        $database = realpath($database);

                        $zip->addFile($database, basename($database));
                    } elseif (is_file($source) === true) {
                        $zip->addFile($source, basename($source));
                    }
                }

                if (!$zip->close()) {
                    $destination = false;
                    $this->log->write($this->language->get('text_security_backup_not_complete'));
                }

                if (file_exists($database)) {
                    unlink($database);
                }

                return $destination;
            } else {
                $this->log->write(sprintf($this->language->get('text_security_backup_not_exists'), $source));
            }
        } else {
            $this->log->write($this->language->get('text_security_backup_zip_error'));
        }

        return false;
    }

    private function check_path($path, $backup_list) {
        $result = !$this->config->get('security_backup_include_exclude_list');

        if ($this->ends_with($path, '/.') || $this->ends_with($path, '/..') || $path == '.' || $path == '..') {
            return false;
        }

        if (in_array($path, $backup_list) || in_array($path . '/', $backup_list)) {
            return $result;
        }

        foreach ($backup_list as $entry) {
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

    private function get_access_token() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://accounts.google.com/o/oauth2/token");
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id={$this->config->get('security_client_id')}&client_secret={$this->config->get('security_client_secret')}&refresh_token={$this->config->get('security_gdrive_refresh_token')}&grant_type=refresh_token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 ) ;
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

        $response = $this->parse_response($ch);

        $access_token = json_decode($response['body']);
        if (json_last_error() == JSON_ERROR_NONE) {
            $access_token = $access_token->access_token ;
        } else {
            $access_token = false;
        }

        return $access_token;
    }

    private function parse_response($ch) {
        $_response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        $response = array(
            'code' => $info['http_code'],
            'headers' => array(),
            'body' => '',
            'info' => $info
        );

        $body = substr($_response, $info['header_size']);

        $header = explode("\r\n", str_replace("\r\n\r\n", '', substr($_response, 0, $info['header_size'])));
        array_shift($header);

        foreach ($header as $line) {
            if (strpos($line, ':') !== false) {
                preg_match('#(.*?)\:\s(.*)#', $line, $found);
                $response['headers'][strtolower(trim($found[1]))] = trim($found[2]);
            }
        }

        $response['body'] = $body;

        return $response;
    }

    private function create_google_file($file_name) {
        $file_size = filesize($file_name);
        $file_name = basename($file_name);

        if($this->config->get('security_backup_folder_id')) {
            $post_fields = "{\"title\":\"{$file_name}\",
                             \"mimeType\":\"{$this->mime_type}\",
                             \"parents\": [{\"kind\":\"drive#fileLink\",\"id\":\"{$this->config->get('security_backup_folder_id')}\"}]}";
        } else {
            $post_fields = "{\"title\":\"{$file_name}\",
                             \"mimeType\":\"{$this->mime_type}\"}";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/upload/drive/v2/files?uploadType=resumable');
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer {$this->access_token}",
            "Content-Length: " . strlen($post_fields),
            "X-Upload-Content-Type: {$this->mime_type}",
            "X-Upload-Content-Length: " . $file_size,
            "Content-Type: application/json; charset=UTF-8")
        );

        $response = $this->parse_response($ch);

        if ($response['code'] == '401') {
            $this->log->write($this->language->get('text_security_backup_unauthorized'));
            $this->log->write(sprintf($this->language->get('text_security_backup_response'), print_r($response, true)));
            return false;
        }

        if ($response['code'] != '200') {
            $this->log->write($this->language->get('text_security_backup_resumable_error'));
            $this->log->write(sprintf($this->language->get('text_security_backup_response'), print_r($response, true)));
            return false;
        }

        if (!isset($response['headers']['location'])) {
            $this->log->write($this->language->get('text_security_backup_location_error'));
            $this->log->write(sprintf($this->language->get('text_security_backup_response'), print_r($response, true)));
            return false;
        }

        return $response['headers']['location'];
    }

    private function delete_google_file($file_id) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/drive/v2/files/' . $file_id);
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer {$this->access_token}"
            )
        );
        curl_exec($ch);
        curl_close($ch);
    }

}
