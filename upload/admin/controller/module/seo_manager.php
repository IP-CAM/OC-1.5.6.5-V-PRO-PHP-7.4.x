<?php
class ControllerModuleSeoManager extends Controller {
        private $error = array();

        public function index() {
                $this->load->language('module/seo_manager');

                $this->document->setTitle($this->language->get('heading_title'));

                $this->load->model('module/seo_manager');

                $this->getList();
        }

        public function update() {
                $this->load->language('module/seo_manager');
                $this->document->setTitle($this->language->get('heading_title'));
                $this->load->model('module/seo_manager');

                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }

                if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                        $this->model_module_seo_manager->updateUrlAlias($this->request->post);
                        $this->session->data['success'] = $this->language->get('text_success');
                }
		$this->redirect($this->url->link('module/seo_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        public function clear() {
    		$this->load->language('module/seo_manager');
                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }
                $this->cache->delete('seo_pro');
                $this->cache->delete('seo_url');
                $this->session->data['success'] = $this->language->get('text_success_clear');
		$this->redirect($this->url->link('module/seo_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        public function delete() {
                $this->load->language('module/seo_manager');
                $this->load->model('module/seo_manager');
                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }

                if (isset($this->request->post['selected']) && $this->validateDelete()) {
                        foreach ($this->request->post['selected'] as $url_alias_id) {
                                $this->model_module_seo_manager->deleteUrlAlias($url_alias_id);
                        }
                        $this->session->data['success'] = $this->language->get('text_success');
                }

                $this->redirect($this->url->link('module/seo_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        private function getList() {
                if (isset($this->request->get['sort'])) {
                        $sort = $this->request->get['sort'];
                } else {
                        $sort = 'ua.query';
                }

                if (isset($this->request->get['order'])) {
                        $order = $this->request->get['order'];
                } else {
                        $order = 'ASC';
                }

                if (isset($this->request->get['page'])) {
                        $page = (int)$this->request->get['page'];
                } else {
                        $page = 1;
                }

                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }

                $this->data['breadcrumbs'] = array();
                $this->data['breadcrumbs'][] = array('text' => $this->language->get('text_home'), 'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'), 'separator' => false);
                $this->data['breadcrumbs'][] = array(
                        'text'      => $this->language->get('text_module'),
                        'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            		'separator' => ' :: '
                );
                $this->data['breadcrumbs'][] = array('text' => $this->language->get('heading_title'), 'href' => $this->url->link('module/seo_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'), 'separator' => ' :: ');

                $this->data['insert'] = $this->url->link('module/seo_manager/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
                $this->data['delete'] = $this->url->link('module/seo_manager/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
                $this->data['save'] = $this->url->link('module/seo_manager/update', 'token=' . $this->session->data['token'] . $url, 'SSL');
                $this->data['clear'] = $this->url->link('module/seo_manager/clear', 'token=' . $this->session->data['token'] . $url, 'SSL');

                $this->data['url_aliases'] = array();

                $data = array(
            		'sort' => $sort, 
            		'order' => $order, 
            		'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
            		'limit' => $this->config->get('config_admin_limit')
            		);

                $url_alias_total = $this->model_module_seo_manager->getTotalUrlAalias();

                $results = $this->model_module_seo_manager->getUrlAaliases($data);

                foreach ($results as $result) {
                        $this->data['url_aliases'][] = array(
                    		'url_alias_id' => $result['url_alias_id'], 
                    		'query' => $result['query'],
                    		'keyword' => $result['keyword'],
                    		'selected' => isset($this->request->post['selected']) && in_array($result['url_alias_id'], $this->request->post['selected']), 
                    		'action_text' => $this->language->get('text_edit')
                    		);
                }

                $this->data['heading_title'] = $this->language->get('heading_title');

                $this->data['text_no_results'] = $this->language->get('text_no_results');

                $this->data['column_query'] = $this->language->get('column_query');
                $this->data['column_keyword'] = $this->language->get('column_keyword');
                $this->data['column_action'] = $this->language->get('column_action');

                $this->data['button_insert'] = $this->language->get('button_insert');
                $this->data['button_delete'] = $this->language->get('button_delete');
                $this->data['button_save'] = $this->language->get('button_save');
                $this->data['button_cancel'] = $this->language->get('button_cancel');
                $this->data['button_clear_cache'] = $this->language->get('button_clear_cache');

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

                $url = '';

                if ($order == 'ASC') {
                        $url .= '&order=DESC';
                } else {
                        $url .= '&order=ASC';
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }

                $this->data['sort_query'] = $this->url->link('module/seo_manager', 'token=' . $this->session->data['token'] . '&sort=ua.query' . $url, 'SSL');
                $this->data['sort_keyword'] = $this->url->link('module/seo_manager', 'token=' . $this->session->data['token'] . '&sort=ua.keyword' . $url, 'SSL');

                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                $pagination = new Pagination();
                $pagination->total = $url_alias_total;
                $pagination->page = $page;
                $pagination->limit = $this->config->get('config_admin_limit');
                $pagination->text = $this->language->get('text_pagination');
                $pagination->url = $this->url->link('module/seo_manager', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

                $this->data['pagination'] = $pagination->render();

                $this->data['sort'] = $sort;
                $this->data['order'] = $order;

                $this->template = 'module/seo_manager.tpl';
                $this->children = array('common/header', 'common/footer');

                $this->response->setOutput($this->render());
        }

        private function validateForm() {
                if (!$this->user->hasPermission('modify', 'module/seo_manager')) {
                        $this->error['warning'] = $this->language->get('error_permission');
                }
                if (!$this->error) {
                        return true;
                } else {
                        return false;
                }
        }

        private function validateDelete() {
                if (!$this->user->hasPermission('modify', 'module/seo_manager')) {
                        $this->error['warning'] = $this->language->get('error_permission');
                }
                if (!$this->error) {
                        return true;
                } else {
                        return false;
                }
        }

        public function install() {
                $this->load->model('module/seo_manager');
                $this->model_module_seo_manager->install();

        }

        public function uninstall() {
                $this->load->model('module/seo_manager');
                $this->model_module_seo_manager->uninstall();
        }
}
?>