<?php

class ControllerCacheCleaner extends Controller {
    public function index() {
	
		$this->load->language('cache/cleaner');
		$this->document->setTitle($this->language->get('heading_title'));
        $this->data['text_mode'] = $this->language->get('text_mode');
        $this->data['text_vqcache'] = $this->language->get('text_vqcache');
        $this->data['text_system'] = $this->language->get('text_system');
        $this->data['text_image'] = $this->language->get('text_image');
        $this->data['button_clean'] = $this->language->get('button_clean');
		$this->data['button_refresh'] = $this->language->get('button_refresh');

        $this->template = 'cache/cleaner.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
		$this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['token'] = $this->session->data['token'];
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
		'text'      => $this->language->get('heading_title'),
		'href' => $this->url->link('cache/cleaner', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->model_setting_setting->editSetting('cacheremove', $this->request->post);
            $this->redirect($this->url->link('cache/cleaner', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['action'] = $this->url->link('cache/cleaner', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('cache/cleaner', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['mod_cache'] = 'vqmod/mods.cache';
        $this->data['mod_vqcache'] = 'vqmod/vqcache';
        $this->data['mod_system'] = 'system/cache';
        $this->data['mod_image'] = 'image/cache/data';

        $this->response->setOutput($this->render());
    }

    public function delete() {
        $this->language->load('cache/cleaner');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $is_file = $this->request->post['is_file'];
            if ($is_file) {
                $this->_deleteFile();
            } else {
                $this->_truncateDir();
            }
            $data['error'] = $this->language->get('text_success');
            $data['type'] = "success";
            echo json_encode($data);
        }
    }

    private function _deleteFile() {
        $this->language->load('cache/cleaner');
        $file = $this->request->post['file'];
        $full_path = DIR_CATALOG . $file;
        $full_path = str_replace('/catalog', '', $full_path);
        if (is_writable($full_path)) {
            file_exists($full_path);
            unlink($full_path);
        } else {
            echo $file . ' ' . $this->language->get('text_notwritable');
        }
    }

    private function _truncateDir($dir = '') {
        if (empty($dir)) {
            $dir = $this->request->post['file'];
            $full_path = DIR_CATALOG . $dir;
            $full_path = str_replace('/catalog', '', $full_path);
        } else {
            $full_path = $dir;
        }
        $files = glob($full_path . '/*'); // get all file names
        
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                if (!stripos($file, 'index.') && !stripos($file, '.gitignore') && !stripos($file, '.hgignore') && !stripos($file, '.htaccess')) {
                    unlink($file); // delete file
                }
            } else {
                $this->_truncateDir($file);
                @rmdir($file);
            }
        }
    }

}
?>