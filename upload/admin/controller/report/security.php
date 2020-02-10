<?php
/**
 * Created by @exife
 * Website: exife.com
 * Email: support@exife.com
 * Name: OpenCart Security
 */

class ControllerReportSecurity extends Controller {
    private $error = array();

    public function backup() {
        $this->language->load('report/security');

        $this->document->setTitle($this->language->get('heading_title_backup'));

        $this->data['heading_title'] = $this->language->get('heading_title_backup');

        $this->data['button_clear'] = $this->language->get('button_clear');

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_backup'),
            'href'      => $this->url->link('report/security/backup', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['clear'] = $this->url->link('report/security/clear_backup', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['version'] = $this->config->get('security_version');

        $file = DIR_LOGS . 'security/full_backup.log';

        if (file_exists($file)) {
            $this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
        } else {
            $this->data['log'] = '';
        }

        $this->template = 'report/security_backup_log.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function away_schedule() {
        $this->language->load('report/security');

        $this->document->setTitle($this->language->get('heading_title_away_schedule'));

        $this->data['heading_title'] = $this->language->get('heading_title_away_schedule');

        $this->data['button_clear'] = $this->language->get('button_clear');

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_away_schedule'),
            'href'      => $this->url->link('report/security/away_schedule', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['clear'] = $this->url->link('report/security/clear_away_schedule', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['version'] = $this->config->get('security_version');

        $file = DIR_LOGS . 'security/away.log';

        if (file_exists($file)) {
            $this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
        } else {
            $this->data['log'] = '';
        }

        $this->template = 'report/security_away_schedule_log.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function clear_backup() {
        $this->language->load('report/security');

        $file = DIR_LOGS . 'security/full_backup.log';

        $handle = fopen($file, 'w+');

        fclose($handle);

        $this->session->data['success'] = $this->language->get('text_success_backup');

        $this->redirect($this->url->link('report/security/backup', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function clear_away_schedule() {
        $this->language->load('report/security');

        $file = DIR_LOGS . 'security/away.log';

        $handle = fopen($file, 'w+');

        fclose($handle);

        $this->session->data['success'] = $this->language->get('text_success_away_schedule');

        $this->redirect($this->url->link('report/security/away_schedule', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function login_attempts() {
        $this->language->load('report/security');

        $this->document->setTitle($this->language->get('heading_title_login_attempts'));

        $this->data['heading_title'] = $this->language->get('heading_title_login_attempts');

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = date('Y-m-d');
        }

        if (isset($this->request->get['filter_group'])) {
            $filter_group = $this->request->get['filter_group'];
        } else {
            $filter_group = 'none';
        }

        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_group'])) {
            $url .= '&filter_group=' . $this->request->get['filter_group'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_login_attempts'),
            'href'      => $this->url->link('report/security/login_attempts', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->load->model('report/security');

        $this->data['attempts'] = array();

        $data = array(
            'filter_date_start'      => $filter_date_start,
            'filter_date_end'        => $filter_date_end,
            'filter_group'           => $filter_group,
            'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit'                  => $this->config->get('config_admin_limit')
        );

        $attempts_total = $this->model_report_security->getTotalAttempts($data);

        $results = $this->model_report_security->getAttempts($data);

        foreach ($results as $result) {
            $this->data['attempts'][] = array(
                'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
                'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
                'username'   => $result['username'],
                'host'       => $result['host'],
                'attempts'   => $result['attempts'],
                'timestamp'   => $result['timestamp']
            );
        }

        $this->data['version'] = $this->config->get('security_version');

        $this->data['heading_title_login_attempts'] = $this->language->get('heading_title_login_attempts');

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_date_start'] = $this->language->get('column_date_start');
        $this->data['column_date_end'] = $this->language->get('column_date_end');
        $this->data['column_date_time'] = $this->language->get('column_date_time');
        $this->data['column_username'] = $this->language->get('column_username');
        $this->data['column_host'] = $this->language->get('column_host');
        $this->data['column_attempts'] = $this->language->get('column_attempts');

        $this->data['entry_date_start'] = $this->language->get('entry_date_start');
        $this->data['entry_date_end'] = $this->language->get('entry_date_end');
        $this->data['entry_group'] = $this->language->get('entry_group');

        $this->data['button_filter'] = $this->language->get('button_filter');

        $this->data['token'] = $this->session->data['token'];

        $this->data['groups'] = array();

        $this->data['groups'][] = array(
            'text'  => $this->language->get('text_none'),
            'value' => 'none',
        );

        $this->data['groups'][] = array(
            'text'  => $this->language->get('text_username'),
            'value' => 'username',
        );

        $this->data['groups'][] = array(
            'text'  => $this->language->get('text_host'),
            'value' => 'host',
        );

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_group'])) {
            $url .= '&filter_group=' . $this->request->get['filter_group'];
        }

        $pagination = new Pagination();
        $pagination->total = $attempts_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('report/security/login_attempts', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_date_start'] = $filter_date_start;
        $this->data['filter_date_end'] = $filter_date_end;
        $this->data['filter_group'] = $filter_group;

        $this->template = 'report/security_login_attempts.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function detection_404() {
        $this->language->load('report/security');

        $this->document->setTitle($this->language->get('heading_title_404_detection'));

        $this->data['heading_title'] = $this->language->get('heading_title_404_detection');

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = date('Y-m-d');
        }

        if (isset($this->request->get['filter_group'])) {
            $filter_group = $this->request->get['filter_group'];
        } else {
            $filter_group = 'none';
        }

        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_group'])) {
            $url .= '&filter_group=' . $this->request->get['filter_group'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_404_detection'),
            'href'      => $this->url->link('report/security/404_detection', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->load->model('report/security');

        $this->data['not_found'] = array();

        $data = array(
            'filter_date_start'      => $filter_date_start,
            'filter_date_end'        => $filter_date_end,
            'filter_group'           => $filter_group,
            'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit'                  => $this->config->get('config_admin_limit')
        );

        $not_found_total = $this->model_report_security->getTotal404($data);

        $results = $this->model_report_security->get404($data);

        foreach ($results as $result) {
            $this->data['not_found'][] = array(
                'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
                'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
                'host'       => $result['host'],
                'url'        => $result['url'],
                'attempts'   => $result['attempts'],
                'timestamp'   => $result['timestamp']
            );
        }

        $this->data['version'] = $this->config->get('security_version');

        $this->data['heading_title_404_detection'] = $this->language->get('heading_title_404_detection');

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_date_start'] = $this->language->get('column_date_start');
        $this->data['column_date_end'] = $this->language->get('column_date_end');
        $this->data['column_date_time'] = $this->language->get('column_date_time');
        $this->data['column_url'] = $this->language->get('column_url');
        $this->data['column_host'] = $this->language->get('column_host');
        $this->data['column_attempts'] = $this->language->get('column_attempts');

        $this->data['entry_date_start'] = $this->language->get('entry_date_start');
        $this->data['entry_date_end'] = $this->language->get('entry_date_end');
        $this->data['entry_group'] = $this->language->get('entry_group');

        $this->data['button_filter'] = $this->language->get('button_filter');

        $this->data['token'] = $this->session->data['token'];

        $this->data['groups'] = array();

        $this->data['groups'][] = array(
            'text'  => $this->language->get('text_none'),
            'value' => 'none',
        );

        $this->data['groups'][] = array(
            'text'  => $this->language->get('text_url_host'),
            'value' => 'url_host',
        );

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_group'])) {
            $url .= '&filter_group=' . $this->request->get['filter_group'];
        }

        $pagination = new Pagination();
        $pagination->total = $not_found_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('report/security/detection_404', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_date_start'] = $filter_date_start;
        $this->data['filter_date_end'] = $filter_date_end;
        $this->data['filter_group'] = $filter_group;

        $this->template = 'report/security_404_detection.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function file_changes() {
        $this->language->load('module/security_strings');
        $this->language->load('report/security');

        $this->document->setTitle($this->language->get('heading_title_file_changes'));

        $this->data['heading_title'] = $this->language->get('heading_title_file_changes');

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = date('Y-m-d');
        }

        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_file_changes'),
            'href'      => $this->url->link('report/security/file_changes', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->load->model('module/security');
        $this->model_module_security->editSettingValue('security', 'security_change_warning', 0);

        $this->load->model('report/security');

        $this->data['file_changes'] = array();

        $data = array(
            'filter_date_start'      => $filter_date_start,
            'filter_date_end'        => $filter_date_end,
            'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit'                  => $this->config->get('config_admin_limit')
        );

        $file_changes_total = $this->model_report_security->getTotalFileChanges($data);

        $results = $this->model_report_security->getFileChanges($data);

        foreach ($results as $result) {
            if (!empty($result['data'])) {
                $result['data'] = unserialize($result['data']);
            }

            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_details'),
                'href' => $this->url->link('report/security/file_changes_detail', 'token=' . $this->session->data['token'] . '&id=' . (int)$result['log_id'], 'SSL')
            );

            $this->data['file_changes'][] = array(
                'id'           => $result['log_id'],
                'added'        => $result['added'],
                'deleted'      => $result['deleted'],
                'changed'      => $result['changed'],
                'timestamp'    => $result['timestamp'],
                'used_memory'  => round((($result['used_memory']) / 1000000), 2) . 'MB',
                'action'       => $action
            );
        }

        $this->data['version'] = $this->config->get('security_version');

        $this->data['heading_title_login_attempts'] = $this->language->get('heading_title_file_changes');

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_files_added'] = $this->language->get('column_files_added');
        $this->data['column_files_deleted'] = $this->language->get('column_files_deleted');
        $this->data['column_files_changed'] = $this->language->get('column_files_changed');
        $this->data['column_date'] = $this->language->get('column_date_check');
        $this->data['column_used_memory'] = $this->language->get('column_used_memory');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['entry_date_start'] = $this->language->get('entry_date_start');
        $this->data['entry_date_end'] = $this->language->get('entry_date_end');

        $this->data['button_filter'] = $this->language->get('button_filter');

        $this->data['token'] = $this->session->data['token'];

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        $pagination = new Pagination();
        $pagination->total = $file_changes_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('report/security/file_changes', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_date_start'] = $filter_date_start;
        $this->data['filter_date_end'] = $filter_date_end;

        $this->template = 'report/security_file_changes.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function file_changes_detail() {
        $this->language->load('report/security');

        $this->load->model('report/security');

        $this->data['data'] = $this->model_report_security->getFileChange((int)$this->request->get['id']);

        $this->data['text_security_files_added'] = $this->language->get('text_security_files_added');
        $this->data['text_security_file'] = $this->language->get('text_security_file');
        $this->data['text_security_modified'] = $this->language->get('text_security_modified');
        $this->data['text_security_file_hash'] = $this->language->get('text_security_file_hash');
        $this->data['text_security_files_deleted'] = $this->language->get('text_security_files_deleted');
        $this->data['text_security_files_changed'] = $this->language->get('text_security_files_changed');

        $this->template = 'report/security_file_changes_detail.tpl';

        $this->response->setOutput($this->render());
    }

    public function lockouts() {
        $this->language->load('report/security');

        $this->document->setTitle($this->language->get('heading_title_lockouts'));

        $this->load->model('report/security');

        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_lockouts'),
            'href'      => $this->url->link('report/security', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['delete'] = $this->url->link('report/security/delete_lockouts', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['version'] = $this->config->get('security_version');

        $this->data['hosts'] = array();

        $data = array(
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $lockouts_total = $this->model_report_security->getTotalLockouts();

        $results = $this->model_report_security->getLockouts($data);

        foreach ($results as $result) {
            $this->data['hosts'][] = array(
                'lockout_id'  => $result['lockout_id'],
                'host'        => $result['host'],
                'start_time'  => $result['start_time'],
                'expire_time' => $result['expire_time'],
                'selected'    => isset($this->request->post['selected']) && in_array($result['lockout_id'], $this->request->post['selected'])
            );
        }

        $this->data['heading_title'] = $this->language->get('heading_title_lockouts');

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_host'] = $this->language->get('column_host');
        $this->data['column_start_time'] = $this->language->get('column_start_time');
        $this->data['column_expire_time'] = $this->language->get('column_expire_time');

        $this->data['button_delete'] = $this->language->get('button_delete');

        if (isset($this->error['warning'])) {
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

        $pagination = new Pagination();
        $pagination->total = $lockouts_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('report/security/lockouts', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'report/security_lockouts.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function delete_lockouts() {
        $this->load->model('report/security');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $lockout_id) {
                $this->model_report_security->deleteLockouts($lockout_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->redirect($this->url->link('report/security/lockouts', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    public function blacklist() {
        $this->language->load('report/security');

        $this->document->setTitle($this->language->get('heading_title_blacklist'));

        $this->load->model('report/security');

        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_blacklist'),
            'href'      => $this->url->link('report/security/blacklist', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['delete'] = $this->url->link('report/security/delete_blacklist', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['version'] = $this->config->get('security_version');

        $this->data['hosts'] = array();

        $data = array(
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $hosts_total = $this->model_report_security->getTotalHosts();

        $results = $this->model_report_security->getHosts($data);

        foreach ($results as $result) {
            $this->data['hosts'][] = array(
                'ban_list_id' => $result['ban_list_id'],
                'host'        => $result['host'],
                'timestamp'   => $result['timestamp'],
                'selected'    => isset($this->request->post['selected']) && in_array($result['ban_list_id'], $this->request->post['selected'])
            );
        }

        $this->data['heading_title'] = $this->language->get('heading_title_blacklist');

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_host'] = $this->language->get('column_host');
        $this->data['column_date_time'] = $this->language->get('column_date_time');

        $this->data['button_delete'] = $this->language->get('button_delete');

        if (isset($this->error['warning'])) {
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

        $pagination = new Pagination();
        $pagination->total = $hosts_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('report/security/blacklist', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'report/security_blacklist.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function delete_blacklist() {
        $this->load->model('report/security');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $ban_list_id) {
                $this->model_report_security->deleteHost($ban_list_id);
            }

            $this->session->data['success'] = $this->language->get('text_success_blacklist');
        }

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->redirect($this->url->link('report/security/blacklist', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'report/security')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}