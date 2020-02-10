<?php
class ControllerCommonSearch extends Controller {
	public function index() {
	$this->load->language('common/search');

	$this->data['text_search'] = $this->language->get('text_search');

	if (isset($this->request->get['search'])) {
	$this->data['search'] = $this->request->get['search'];
	} else {
	$this->data['search'] = '';
	}

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/search.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/common/search.tpl';
	} else {
	$this->template = 'default/template/common/search.tpl';
	}
	$this->response->setOutput($this->render());
	}
}
?>