<?php
class ControllerModuleThemeSwitcher extends Controller {
	protected function index() {
	$this->language->load('module/theme_switcher');
	$this->data['heading_title'] = $this->language->get('heading_title');
	$this->data['themes'] = array();

	if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) {
	$length = strpos($_SERVER['QUERY_STRING'], '&theme=');
	if ($length === false) {
	$length = strpos($_SERVER['QUERY_STRING'], '&theme=');
	}

	if ($length === 0) {
	$query_string = '';
	} elseif ($length !== false) {
	$query_string = substr($_SERVER['QUERY_STRING'], 6, $length);
	} else {
	$query_string = 'common/home';
	}

		$this->data['action'] = $this->url->link($query_string);
	} else {
	$this->data['action'] = $this->url->link('common/home');
	}

	$directories = glob(DIR_APPLICATION . 'view/theme/*', GLOB_ONLYDIR);

	foreach ($directories as $directory) {
	$this->data['themes'][] = array(
	'name' => ucwords(basename($directory)),
	'href' => ($this->data['action'] . '&theme=' . basename($directory))
	);
	}

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/theme_switcher.tpl')) {
		$this->template = $this->config->get('config_template') . '/template/module/theme_switcher.tpl';
	} else {
		$this->template = 'default/template/module/theme_switcher.tpl';
	}

	$this->render();
	}
}
?>