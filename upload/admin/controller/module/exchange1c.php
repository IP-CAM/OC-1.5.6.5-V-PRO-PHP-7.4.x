<?php
class ControllerModuleExchange1c extends Controller {
	private $error = array();

	public function index() {

		$this->language->load('module/exchange1c');

		//$this->document->title = $this->language->get('heading_title');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('exchange1c', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['version'] = 'Version dev.43';
		//$this->data['version'] = 'Version 1.4';

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_allow_ip'] = $this->language->get('entry_allow_ip');
		$this->data['entry_price_type'] = $this->language->get('entry_price_type');
		$this->data['entry_flush_product'] = $this->language->get('entry_flush_product');
		$this->data['entry_flush_category'] = $this->language->get('entry_flush_category');
		$this->data['entry_flush_manufacturer'] = $this->language->get('entry_flush_manufacturer');
		$this->data['entry_flush_quantity'] = $this->language->get('entry_flush_quantity');
		$this->data['entry_flush_attribute'] = $this->language->get('entry_flush_attribute');
		$this->data['entry_fill_parent_cats'] = $this->language->get('entry_fill_parent_cats');
		$this->data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_tab_general'] = $this->language->get('text_tab_general');
		$this->data['text_tab_product'] = $this->language->get('text_tab_product');
		$this->data['text_tab_order'] = $this->language->get('text_tab_order');
		$this->data['text_tab_manual'] = $this->language->get('text_tab_manual');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_max_filesize'] = sprintf($this->language->get('text_max_filesize'), @ini_get('max_file_uploads'));
		$this->data['text_homepage'] = $this->language->get('text_homepage');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_order_currency'] = $this->language->get('entry_order_currency');
		$this->data['entry_order_notify'] = $this->language->get('entry_order_notify');
		$this->data['entry_fill_parent_cats'] = $this->language->get('entry_fill_parent_cats');
		$this->data['entry_upload'] = $this->language->get('entry_upload');
		$this->data['button_upload'] = $this->language->get('button_upload');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

  		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		}
		else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['exchange1c_username'])) {
			$this->data['error_exchange1c_username'] = $this->error['exchange1c_username'];
		}
		else {
			$this->data['error_exchange1c_username'] = '';
		}

 		if (isset($this->error['exchange1c_password'])) {
			$this->data['error_exchange1c_password'] = $this->error['exchange1c_password'];
		}
		else {
			$this->data['error_exchange1c_password'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/enginedb', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '

		);

   		$this->data['token'] = $this->session->data['token'];

		//$this->data['action'] = HTTPS_SERVER . 'index.php?route=module/exchange1c&token=' . $this->session->data['token'];
		$this->data['action'] = $this->url->link('module/exchange1c', 'token=' . $this->session->data['token'], 'SSL');

		//$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/exchange1c&token=' . $this->session->data['token'];
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['exchange1c_username'])) {
			$this->data['exchange1c_username'] = $this->request->post['exchange1c_username'];
		}
		else {
			$this->data['exchange1c_username'] = $this->config->get('exchange1c_username');
		}

		if (isset($this->request->post['exchange1c_password'])) {
			$this->data['exchange1c_password'] = $this->request->post['exchange1c_password'];
		}
		else {
			$this->data['exchange1c_password'] = $this->config->get('exchange1c_password');
		}

		if (isset($this->request->post['exchange1c_allow_ip'])) {
			$this->data['exchange1c_allow_ip'] = $this->request->post['exchange1c_allow_ip'];
		}
		else {
			$this->data['exchange1c_allow_ip'] = $this->config->get('exchange1c_allow_ip');
		}

		if (isset($this->request->post['exchange1c_status'])) {
			$this->data['exchange1c_status'] = $this->request->post['exchange1c_status'];
		}
		else {
			$this->data['exchange1c_status'] = $this->config->get('exchange1c_status');
		}

		if (isset($this->request->post['exchange1c_price_type'])) {
			$this->data['exchange1c_price_type'] = $this->request->post['exchange1c_price_type'];
		}
		else {
			$this->data['exchange1c_price_type'] = $this->config->get('exchange1c_price_type');
		}

		if (isset($this->request->post['exchange1c_flush_product'])) {
			$this->data['exchange1c_flush_product'] = $this->request->post['exchange1c_flush_product'];
		}
		else {
			$this->data['exchange1c_flush_product'] = $this->config->get('exchange1c_flush_product');
		}

		if (isset($this->request->post['exchange1c_flush_category'])) {
			$this->data['exchange1c_flush_category'] = $this->request->post['exchange1c_flush_category'];
		}
		else {
			$this->data['exchange1c_flush_category'] = $this->config->get('exchange1c_flush_category');
		}

		if (isset($this->request->post['exchange1c_flush_manufacturer'])) {
			$this->data['exchange1c_flush_manufacturer'] = $this->request->post['exchange1c_flush_manufacturer'];
		}
		else {
			$this->data['exchange1c_flush_manufacturer'] = $this->config->get('exchange1c_flush_manufacturer');
		}

		if (isset($this->request->post['exchange1c_flush_quantity'])) {
			$this->data['exchange1c_flush_quantity'] = $this->request->post['exchange1c_flush_quantity'];
		}
		else {
			$this->data['exchange1c_flush_quantity'] = $this->config->get('exchange1c_flush_quantity');
		}

		if (isset($this->request->post['exchange1c_flush_attribute'])) {
			$this->data['exchange1c_flush_attribute'] = $this->request->post['exchange1c_flush_attribute'];
		}
		else {
			$this->data['exchange1c_flush_attribute'] = $this->config->get('exchange1c_flush_attribute');
		}

		if (isset($this->request->post['exchange1c_fill_parent_cats'])) {
			$this->data['exchange1c_fill_parent_cats'] = $this->request->post['exchange1c_fill_parent_cats'];
		}
		else {
			$this->data['exchange1c_fill_parent_cats'] = $this->config->get('exchange1c_fill_parent_cats');
		}

		if (isset($this->request->post['exchange1c_seo_url'])) {
			$this->data['exchange1c_seo_url'] = $this->request->post['exchange1c_seo_url'];
		}
		else {
			$this->data['exchange1c_seo_url'] = $this->config->get('exchange1c_seo_url');
		}

		if (isset($this->request->post['exchange1c_order_status'])) {
			$this->data['exchange1c_order_status'] = $this->request->post['exchange1c_order_status'];
		}
		else {
			$this->data['exchange1c_order_status'] = $this->config->get('exchange1c_order_status');
		}

		if (isset($this->request->post['exchange1c_order_currency'])) {
			$this->data['exchange1c_order_currency'] = $this->request->post['exchange1c_order_currency'];
		}
		else {
			$this->data['exchange1c_order_currency'] = $this->config->get('exchange1c_order_currency');
		}

		if (isset($this->request->post['exchange1c_order_notify'])) {
			$this->data['exchange1c_order_notify'] = $this->request->post['exchange1c_order_notify'];
		}
		else {
			$this->data['exchange1c_order_notify'] = $this->config->get('exchange1c_order_notify');
		}

		$this->load->model('localisation/order_status');

		$order_statuses = $this->model_localisation_order_status->getOrderStatuses();

		foreach ($order_statuses as $order_status) {
			$this->data['order_statuses'][] = array(
				'order_status_id' => $order_status['order_status_id'],
				'name'			  => $order_status['name']
			);
		}

		$this->template = 'module/exchange1c.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {

		if (!$this->user->hasPermission('modify', 'module/exchange1c')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function install() {}

	public function uninstall() {}

	// ---
	public function modeCheckauth() {

		// Проверяем включен или нет модуль
		if(!$this->config->get('exchange1c_status')) {
			echo "failure\n";
			echo "1c module OFF";
			exit;
		}

		// Разрешен ли IP
		if ($this->config->get('exchange1c_allow_ip') != '') {
			$ip = $_SERVER['REMOTE_ADDR'];
			$allow_ips = explode("\r\n", $this->config->get('exchange1c_allow_ip'));

			if (!in_array($ip, $allow_ips)) {
				echo "failure\n";
				echo "IP is not allowed";
			}
		}

		// Авторизуем
		if(($this->config->get('exchange1c_username') != '') && (@$_SERVER['PHP_AUTH_USER'] != $this->config->get('exchange1c_username'))) {
			echo "failure\n";
			echo "error login";
		}

		if(($this->config->get('exchange1c_password') != '') && (@$_SERVER['PHP_AUTH_PW'] != $this->config->get('exchange1c_password'))) {
			echo "failure\n";
			echo "error password";
			exit;
		}

		echo "success\n";
		echo session_name()."\n";
		echo session_id() ."\n";
	}

	public function manualImport() {
		$this->language->load('module/exchange1c');

		$cache = DIR_CACHE . 'exchange1c/';
		$json = array();

		if (!empty($this->request->files['file']['name'])) {

			$zip = new ZipArchive;

			if ($zip->open($this->request->files['file']['tmp_name']) === true) {
				$this->modeCatalogInit(false);

				$zip->extractTo($cache);

				if (file_exists($cache . 'import.xml')) {
					$this->modeImport('import.xml');
				}

				if (file_exists($cache . 'offers.xml')) {
					$this->modeImport('offers.xml');
				}

				if (is_dir($cache . 'import_files')) {
					$images = DIR_IMAGE . 'import_files/';

					if (is_dir($images)) {
						$this->cleanDir($images);
					}

					rename($cache . 'import_files/', $images);
				}

			}
			else {

				$handle = fopen($this->request->files['file']['tmp_name'], 'r');
				$buffer = fread($handle, 256);
				fclose($handle);

				if (strpos($buffer, 'Классификатор')) {
					$this->modeCatalogInit(false);
					move_uploaded_file($this->request->files['file']['tmp_name'], $cache . 'import.xml');
					$this->modeImport('import.xml');

				}
				else if (strpos($buffer, 'ПакетПредложений')) {
					move_uploaded_file($this->request->files['file']['tmp_name'], $cache . 'offers.xml');
					$this->modeImport('offers.xml');

				}
				else {
					$json['error'] = $this->language->get('text_upload_error');
					exit;
				}
			}

			$json['success'] = $this->language->get('text_upload_success');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function modeCatalogInit($echo = true) {

		$this->load->model('tool/exchange1c');

		// чистим кеш, убиваем старые данные
		$this->cleanCacheDir();

		// Проверяем естль ли БД для хранения промежуточных данных.
		$this->model_tool_exchange1c->checkDbSheme();

		// Очищаем таблицы
		$this->model_tool_exchange1c->flushDb(array(
			'product' 		=> $this->config->get('exchange1c_flush_product'),
			'category'		=> $this->config->get('exchange1c_flush_category'),
			'manufacturer'	=> $this->config->get('exchange1c_flush_manufacturer'),
			'attribute'		=> $this->config->get('exchange1c_flush_attribute'),
			'quantity'		=> $this->config->get('exchange1c_flush_quantity')
		));

		$limit = 100000 * 1024;

		if ($echo) {
			echo "zip=no\n";
			echo "file_limit=".$limit."\n";
		}

	}

	public function modeSaleInit() {
		$limit = 100000 * 1024;

		echo "zip=no\n";
		echo "file_limit=".$limit."\n";
	}

	public function modeFile() {

		$cache = DIR_CACHE . 'exchange1c/';

		// Проверяем на наличие имени файла
		if (isset($this->request->get['filename'])) {
			$uplod_file = $cache . $this->request->get['filename'];
		}
		else {
			echo "failure\n";
			echo "ERROR 10: No file name variable";
			return;
		}

		// Проверяем XML или изображения
		if( strpos( $this->request->get['filename'], 'import_files') !== false ) {
			$cache = DIR_IMAGE;
			$uplod_file = $cache . $this->request->get['filename'];
			$this->checkUploadFileTree( dirname($this->request->get['filename']) , $cache);

			// TODO: физическое обновление изображений.

		}

		// Получаем данные
		$DATA = file_get_contents("php://input");

		if ($DATA !== false) {
			if ($fp = fopen($uplod_file, "wb")) {
				$result = fwrite($fp, $DATA);

				if ($result === strlen($DATA)) {
					echo "success\n";

					chmod($uplod_file , 0777);
					//echo "success\n";
				}
				else {
					echo "failure\n";
				}
			}
			else {
				echo "failure\n";
				echo "Can not open file: $uplod_file\n";
				echo $cache;
			}
		}
		else {
			echo "failure\n";
			echo "No data file\n";
		}


	}

	public function modeImport($manual = false) {

		$cache = DIR_CACHE . 'exchange1c/';

		if ($manual) {
			$filename = $manual;
			$importFile = $cache . $filename;
		}
		else if (isset($this->request->get['filename'])) {
			$filename = $this->request->get['filename'];
			$importFile = $cache . $filename;
		}
		else {
			echo "failure\n";
			echo "ERROR 10: No file name variable";
			return 0;
		}

		$this->load->model('tool/exchange1c');

		if($filename == 'import.xml') {

			$this->model_tool_exchange1c->parseImport();

			if ($this->config->get('exchange1c_fill_parent_cats')) {
				$this->model_tool_exchange1c->fillParentsCategories();
			}

			if ($this->config->get('exchange1c_seo_url')) {
				$this->load->model('module/deadcow_seo');
				$this->model_module_deadcow_seo->generateCategories($this->config->get('deadcow_seo_categories_template'), 'Russian');
				$this->model_module_deadcow_seo->generateProducts($this->config->get('deadcow_seo_products_template'), 'Russian');
				$this->model_module_deadcow_seo->generateManufacturers($this->config->get('deadcow_seo_manufacturers_template'), 'Russian');
			}

			if (!$manual) {
				echo "success\n";
			}

		}
		else if ($filename == 'offers.xml') {

			if ($this->config->get('exchange1c_price_type') == '') {
				$config_price_type = false;
			}
			else {
				$config_price_type = $this->config->get('exchange1c_price_type');
			}

			$this->model_tool_exchange1c->parseOffers($config_price_type);

			if (!$manual) {
				echo "success\n";
			}

		}
		else {

			echo "failure\n";
			echo $filename;

		}

		$this->cache->delete('product');
		return;
	}

	public function modeQueryOrders() {

		$this->load->model('tool/exchange1c');
		$orders = $this->model_tool_exchange1c->queryOrders(array(
			 'query_status' => $this->config->get('config_order_status_id')
			,'new_status'	=> $this->config->get('exchange1c_order_status')
			,'notify'		=> $this->config->get('exchange1c_order_notify')
			,'currency'		=> $this->config->get('exchange1c_order_currency') ? $this->config->get('exchange1c_order_currency') : 'руб.'
		));

		echo iconv('utf-8', 'cp1251', $orders);
	}


	// -- Системные процедуры
	private function cleanCacheDir() {

		// Проверяем есть ли директория
		if (file_exists(DIR_CACHE . 'exchange1c')) {
			if (is_dir(DIR_CACHE . 'exchange1c')) {
				return $this->cleanDir(DIR_CACHE . 'exchange1c/');
			}
			else {
				unlink(DIR_CACHE . 'exchange1c');
			}
		}

		mkdir (DIR_CACHE . 'exchange1c');

		return 0;
	}

	private function checkUploadFileTree($path, $curDir = null) {

		if (!$curDir) $curDir = DIR_CACHE . 'exchange1c/';

		foreach (explode('/', $path) as $name) {

			if (!$name) continue;

			if (file_exists($curDir . $name)) {
				if (is_dir( $curDir . $name)) {
					$curDir = $curDir . $name . '/';
					continue;
				}

				unlink ($curDir . $name);
			}

			mkdir ($curDir . $name );
			$curDir = $curDir . $name . '/';
		}

	}


	private function cleanDir($root, $self = false) {

		$dir = dir($root);

		while ($file = $dir->read()) {
			if ($file == '.' || $file == '..') continue;
			if (file_exists($root . $file)) {
				if (is_file($root . $file)) { unlink($root . $file); continue; }
				if (is_dir($root . $file)) { $this->cleanDir($root . $file . '/', true); continue; }
				var_dump ($file);
			}
			var_dump($file);
		}

		if ($self) {
			if(file_exists($root) && is_dir($root)) {
				rmdir($root); return 0;
			}

			var_dump($root);
		}
		return 0;
	}
}
?>