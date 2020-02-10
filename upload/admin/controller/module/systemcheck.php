<?php
class ControllerModuleSystemCheck extends Controller {
	private $error = array();
	private $_name = 'systemcheck';
	private $_version = '1.5.6';
	private $_revision = '1.0';
	
	public function index() { 
	
		if ((substr(VERSION, 0, 5) == '1.5.5') || (substr(VERSION, 0, 5) == '1.5.6')) {
			$this->language->load('module/' . $this->_name);
		} else {
			$this->load->language('module/' . $this->_name);
		}
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->data[$this->_name . '_version'] = $this->_version;
	
		$this->data['systemcheck'] = '';
	
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$button = $this->request->post['buttonForm'];
		
			switch($button) {
				case "optimize": $this->data['systemcheck'] = $this->redirect($this->url->link('module/' . $this->_name . '/optimize', 'token=' . $this->session->data['token'], 'SSL')); break;
				case "repair": $this->data['systemcheck'] = $this->redirect($this->url->link('module/' . $this->_name . '/repair', 'token=' . $this->session->data['token'], 'SSL')); break;
			}
		}
	
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
	
		$this->data['heading_title'] = $this->language->get('heading_title');
	
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_on'] = $this->language->get('text_on');
		$this->data['text_off'] = $this->language->get('text_off');
		$this->data['text_no_version'] = $this->language->get('text_no_version');
		
		$this->data['text_system'] = $this->language->get('text_system');
		$this->data['text_opencart'] = sprintf($this->language->get('text_opencart'), VERSION);
		$this->data['text_theme'] = $this->language->get('text_theme');
		$this->data['text_support'] = $this->language->get('text_support');
	
		$this->data['tab_info'] = $this->language->get('tab_info');
		$this->data['tab_system'] = $this->language->get('tab_system');
		$this->data['tab_maintenance'] = $this->language->get('tab_maintenance');
		$this->data['tab_support'] = $this->language->get('tab_support');
	
		$this->data['text_storeinfo'] = $this->language->get('text_storeinfo');
		$this->data['text_serverinfo'] = $this->language->get('text_serverinfo');
		$this->data['text_systeminfo'] = $this->language->get('text_systeminfo');
		$this->data['text_supportinfo'] = $this->language->get('text_supportinfo');
		
		$this->data['column_php'] = $this->language->get('column_php');
		$this->data['column_extension'] = $this->language->get('column_extension');
		$this->data['column_directories'] = $this->language->get('column_directories');
		$this->data['column_database_files'] = $this->language->get('column_database_files');
		$this->data['column_engine_files'] = $this->language->get('column_engine_files');
		$this->data['column_helper_files'] = $this->language->get('column_helper_files');
		$this->data['column_library_files'] = $this->language->get('column_library_files');
		$this->data['column_library_names'] = $this->language->get('column_library_names');
		$this->data['column_current'] = $this->language->get('column_current');
		$this->data['column_required'] = $this->language->get('column_required');
		$this->data['column_status'] = $this->language->get('column_status');
		
		$this->data['text_phpversion'] = $this->language->get('text_phpversion');
		$this->data['text_registerglobals'] = $this->language->get('text_registerglobals');
		$this->data['text_magicquotes'] = $this->language->get('text_magicquotes');
		$this->data['text_fileuploads'] = $this->language->get('text_fileuploads');
		$this->data['text_autostart'] = $this->language->get('text_autostart');
	
		$this->data['text_mysqli'] = $this->language->get('text_mysqli');
		$this->data['text_gd'] = $this->language->get('text_gd');
		$this->data['text_curl'] = $this->language->get('text_curl');
		$this->data['text_mcrypt'] = $this->language->get('text_mcrypt');
		$this->data['text_zlib'] = $this->language->get('text_zlib');
	
		$this->data['text_present'] = $this->language->get('text_present');
		$this->data['text_missing'] = $this->language->get('text_missing');
		$this->data['text_unknown'] = $this->language->get('text_unknown');
	
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
	
		$this->data['token'] = $this->session->data['token'];
	
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
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
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	
		$this->data['refresh'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
	
		// Version Check
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['module_name'] = $this->language->get('text_module_name');
		$this->data['module_current_name'] = $this->_name;
		$this->data['module_list'] = $this->language->get('text_module_list');
		$this->data['store_version'] = sprintf($this->language->get('text_store_version'), VERSION);
		$this->data['store_base_version'] = substr(VERSION, 0, 5);
		$this->data['text_template'] = $this->language->get('text_template');
	
		$this->data['compatibles'] = array();
	
		$this->data['compatibles'][] = array('opencart' => '1.5.4', 'title' => $this->language->get('text_v154'));
		$this->data['compatibles'][] = array('opencart' => '1.5.5', 'title' => $this->language->get('text_v155'));
		$this->data['compatibles'][] = array('opencart' => '1.5.6', 'title' => $this->language->get('text_v156'));
	
		$this->data['button_showhide'] = $this->language->get('button_showhide');
		$this->data['button_support'] = $this->language->get('button_support');
	
		$this->data['module_current_version'] = sprintf($this->language->get('text_module_version'), $this->_version);
		$this->data['module_current_revision'] = sprintf($this->language->get('text_module_revision'), $this->_revision);
		$this->data['text_no_file'] = $this->language->get('text_no_file');
		$this->data['text_update'] = $this->language->get('text_update');
		$this->data['text_getupdate'] = $this->language->get('text_getupdate');
	
		$vdfurl = 'http://villagedefrance.net/updater/module/' . $this->_name . '/revisions.txt';
		$vdfhandler = curl_init($vdfurl);
		curl_setopt($vdfhandler,  CURLOPT_RETURNTRANSFER, TRUE);
		$resp = curl_exec($vdfhandler);
		$vdf = curl_getinfo($vdfhandler, CURLINFO_HTTP_CODE);
	
		if ($vdf == '200') { 
			$getRevisions = file_get_contents($vdfurl);
		} else {
			$getRevisions = '';
		}
	
		if ($getRevisions !== '') {
			$revisionList = explode("\n", $getRevisions);
		
			foreach ($revisionList as $revision) { 
			
				$version = substr($revision, 0, 5);
				$subversion = substr($revision, -3);
			
				if ($version > $this->_version) {
					$this->data['version'] = sprintf($this->language->get('text_v_update'), $version);
					$this->data['ver_update'] = true;
				
					$this->data['revision'] = $this->language->get('text_no_revision');
				} else {
					$this->data['version'] = sprintf($this->language->get('text_v_no_update'), $version);
					$this->data['ver_update'] = false;
				
					if ($subversion > $this->_revision) {
						$this->data['revision'] = sprintf($this->language->get('text_r_update'), $subversion);
						$this->data['rev_update'] = true;
					} else {
						$this->data['revision'] = sprintf($this->language->get('text_r_no_update'), $subversion);
						$this->data['rev_update'] = false;
					}
				}
			}
		} else {
			$this->data['version'] = '';
			$this->data['revision'] = '';
			$this->data['ver_update'] = false;
			$this->data['rev_update'] = false;
		}
	
		$this->data['cache'] = DIR_SYSTEM . 'cache';
		$this->data['logs'] = DIR_SYSTEM . 'logs';
		$this->data['image_cache'] = DIR_IMAGE . 'cache';
		$this->data['image_data'] = DIR_IMAGE . 'data';
	
		// Template
		$this->data['templates'] = array();
	
		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
	
		foreach ($directories as $directory) {
			$this->data['templates'][] = basename($directory);
		}	
	
		if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');			
		}
	
		// Multi-Store
		$this->load->model('setting/store');
	
		$this->data['store_id'] = $this->config->get('config_store_id');
	
		$this->data['stores'] = array();
	
		$this->data['stores'][] = array(
			'store_id' => $this->config->get('config_store_id'),
			'name'   => $this->config->get('config_name')
		);
	
		$storeresults = $this->model_setting_store->getStores();
	
		foreach ($storeresults as $storeresult) {
			$this->data['stores'][] = array(
				'store_id' => $storeresult['store_id'],
				'name'   => $storeresult['name']
			);
		}
	
		// Database Files
		$this->data['databases'] = array();
	
		$databases = glob(DIR_SYSTEM . 'database/*.php', GLOB_NOSORT);
	
		foreach ($databases as $database) {
			$this->data['databases'][] = $database;
		}
	
		$this->data['oc_version'] = substr(VERSION, 0, 5);
	
		if (file_exists(DIR_SYSTEM . 'database/mysqli.php')) {
			$this->data['url_mysqli'] = DIR_SYSTEM . 'database/mysqli.php'; // 1.5.4, 1.5.5, 1.5.6
		} else {
			$this->data['url_mysqli'] = '';
		}
	
		// Engine Files
		$this->data['engines'] = array();
	
		$engines = glob(DIR_SYSTEM . 'engine/*.php', GLOB_NOSORT);
	
		foreach ($engines as $engine) {
			$this->data['engines'][] = $engine;
		}
	
		if (file_exists(DIR_SYSTEM . 'engine/action.php')) {
			$this->data['url_action'] = DIR_SYSTEM . 'engine/action.php';
		} else {
			$this->data['url_action'] = '';
		}
		if (file_exists(DIR_SYSTEM . 'engine/controller.php')) {
			$this->data['url_controller'] = DIR_SYSTEM . 'engine/controller.php';
		} else {
			$this->data['url_controller'] = '';
		}
		if (file_exists(DIR_SYSTEM . 'engine/front.php')) {
			$this->data['url_front'] = DIR_SYSTEM . 'engine/front.php';
		} else {
			$this->data['url_front'] = '';
		}
		if (file_exists(DIR_SYSTEM . 'engine/loader.php')) {
			$this->data['url_loader'] = DIR_SYSTEM . 'engine/loader.php';
		} else {
			$this->data['url_loader'] = '';
		}
		if (file_exists(DIR_SYSTEM . 'engine/model.php')) {
			$this->data['url_model'] = DIR_SYSTEM . 'engine/model.php';
		} else {
			$this->data['url_model'] = '';
		}
		if (file_exists(DIR_SYSTEM . 'engine/registry.php')) {
			$this->data['url_registry'] = DIR_SYSTEM . 'engine/registry.php';
		} else {
			$this->data['url_registry'] = '';
		}
		
		if (file_exists(DIR_SYSTEM . 'library/d_response.php')) {
			$this->data['url_d_response'] = DIR_SYSTEM . 'library/d_response.php';
		} else {
			$this->data['url_d_response'] = '';
		}
		
		if (file_exists(DIR_SYSTEM . 'library/colour_finder.php')) {
			$this->data['url_colour_finder'] = DIR_SYSTEM . 'library/colour_finder.php';
		} else {
			$this->data['url_colour_finder'] = '';
		}
		
		
	
		// Helper Files
		$this->data['helpers'] = array();
	
		$helpers = glob(DIR_SYSTEM . 'helper/*.php', GLOB_NOSORT);
	
		foreach ($helpers as $helper) {
			$this->data['helpers'][] = $helper;
		}
	
		if (file_exists(DIR_SYSTEM . 'helper/csv_helper.php')) {
			$this->data['url_csv_helper'] = DIR_SYSTEM . 'helper/csv_helper.php';
		} else {
			$this->data['url_csv_helper'] = '';
		}

		if (file_exists(DIR_SYSTEM . 'helper/json.php')) {
			$this->data['url_json'] = DIR_SYSTEM . 'helper/json.php';
		} else {
			$this->data['url_json'] = '';
		}
		if (file_exists(DIR_SYSTEM . 'helper/utf8.php')) {
			$this->data['url_utf8'] = DIR_SYSTEM . 'helper/utf8.php';
		} else {
			$this->data['url_utf8'] = '';
		}
		if (file_exists(DIR_SYSTEM . 'helper/vat.php')) {
			$this->data['url_vat'] = DIR_SYSTEM . 'helper/vat.php';
		} else {
			$this->data['url_vat'] = '';
		}
		
		// Library Files
		$this->data['libraries'] = array();
	
		$libraries = glob(DIR_SYSTEM . 'library/*.php', GLOB_NOSORT);
	
		foreach ($libraries as $library) {
			$this->data['libraries'][] = $library;
		}
	
		$core_version = substr(VERSION, 0, 5);
		
		$this->data['core_version'] = $core_version;
	
		$this->data['library_files'] = array();
		
		if ($core_version = '1.5.4' || $core_version = '1.5.5' || $core_version = '1.5.6') {
			$this->data['library_files'][] = array('name' => 'address_cleaner','url' => DIR_SYSTEM . 'library/address_cleaner.php');
			$this->data['library_files'][] = array('name' => 'affiliate','url' => DIR_SYSTEM . 'library/affiliate.php');
			$this->data['library_files'][] = array('name' => 'APC_cache','url' => DIR_SYSTEM . 'library/APC_cache.php');
			$this->data['library_files'][] = array('name' => 'cache','url' => DIR_SYSTEM . 'library/cache.php');
			$this->data['library_files'][] = array('name' => 'captcha','url' => DIR_SYSTEM . 'library/captcha.php');
			$this->data['library_files'][] = array('name' => 'cart','url' => DIR_SYSTEM . 'library/cart.php');
			$this->data['library_files'][] = array('name' => 'config','url' => DIR_SYSTEM . 'library/config.php');
			$this->data['library_files'][] = array('name' => 'csrf','url' => DIR_SYSTEM . 'library/csrf.php');
			$this->data['library_files'][] = array('name' => 'currency','url' => DIR_SYSTEM . 'library/currency.php');
			$this->data['library_files'][] = array('name' => 'customer','url' => DIR_SYSTEM . 'library/customer.php');
			$this->data['library_files'][] = array('name' => 'db','url' => DIR_SYSTEM . 'library/db.php');
			$this->data['library_files'][] = array('name' => 'document','url' => DIR_SYSTEM . 'library/document.php');
			$this->data['library_files'][] = array('name' => 'encryption','url' => DIR_SYSTEM . 'library/encryption.php');
			$this->data['library_files'][] = array('name' => 'image','url' => DIR_SYSTEM . 'library/image.php');
			$this->data['library_files'][] = array('name' => 'language','url' => DIR_SYSTEM . 'library/language.php');
			$this->data['library_files'][] = array('name' => 'length','url' => DIR_SYSTEM . 'library/length.php');
			$this->data['library_files'][] = array('name' => 'log','url' => DIR_SYSTEM . 'library/log.php');
			$this->data['library_files'][] = array('name' => 'mail','url' => DIR_SYSTEM . 'library/mail.php');
			$this->data['library_files'][] = array('name' => 'pagination','url' => DIR_SYSTEM . 'library/pagination.php');
			$this->data['library_files'][] = array('name' => 'request','url' => DIR_SYSTEM . 'library/request.php');
			$this->data['library_files'][] = array('name' => 'response','url' => DIR_SYSTEM . 'library/response.php');
			$this->data['library_files'][] = array('name' => 'session','url' => DIR_SYSTEM . 'library/session.php');
			$this->data['library_files'][] = array('name' => 'tax','url' => DIR_SYSTEM . 'library/tax.php');
			$this->data['library_files'][] = array('name' => 'd_response','url' => DIR_SYSTEM . 'library/d_response.php');
			$this->data['library_files'][] = array('name' => 'colour-finder','url' => DIR_SYSTEM . 'library/colour_finder.php');
						
			$this->data['library_files'][] = array('name' => 'template','url' => DIR_SYSTEM . 'library/template.php');
			$this->data['library_files'][] = array('name' => 'url','url' => DIR_SYSTEM . 'library/url.php');
			$this->data['library_files'][] = array('name' => 'user','url' => DIR_SYSTEM . 'library/user.php');
			$this->data['library_files'][] = array('name' => 'weight','url' => DIR_SYSTEM . 'library/weight.php');
		}
		if ($core_version = '1.5.5' || $core_version = '1.5.6') {
			$this->data['library_files'][] = array('name' => 'cba','url' => DIR_SYSTEM . 'library/cba.php'); // true for 1.5.5.2 only !
		}
		if ($core_version = '1.5.6') {
			$this->data['library_files'][] = array('name' => 'play','url' => DIR_SYSTEM . 'library/play.php');
		}
		
		// Optimize & Repair
		$this->load->model('tool/database');
	
		$this->data['tables'] = $this->model_tool_database->getTables();
		
		$this->data['text_optimize'] = $this->language->get('text_optimize');
		$this->data['text_repair'] = $this->language->get('text_repair');
	
		$this->data['text_help_optimize'] = $this->language->get('text_help_optimize');
		$this->data['text_help_repair'] = $this->language->get('text_help_repair');
	
		$this->data['button_optimize'] = $this->language->get('button_optimize');
		$this->data['button_repair'] = $this->language->get('button_repair');
		
		if (isset($this->session->data['success_optimize'])) {
			$this->data['success_optimize'] = $this->session->data['success_optimize'];
		
			unset($this->session->data['success_optimize']);
		} else {
			$this->data['success_optimize'] = '';
		}
		
		if (isset($this->session->data['success_repair'])) {
			$this->data['success_repair'] = $this->session->data['success_repair'];
		
			unset($this->session->data['success_repair']);
		} else {
			$this->data['success_repair'] = '';
		}
	
		if (isset($this->session->data['output'])) {
			$this->data['output'] = $this->session->data['output'];
		
			unset($this->session->data['output']);
		} else {
			$this->data['output'] = '';
		}
	
		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
	
		$this->response->setOutput($this->render());
	}
	
	// Optimise
	public function optimize() {
	
		if ((substr(VERSION, 0, 5) == '1.5.5') || (substr(VERSION, 0, 5) == '1.5.6')) {
			$this->language->load('module/' . $this->_name);
		} else {
			$this->load->language('module/' . $this->_name);
		}
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('tool/database');
	
		$this->session->data['output'] = $this->model_tool_database->tableOptimize();
	
		$this->session->data['success_optimize'] = $this->language->get('text_success_optimize');
	
		$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	// Repair
	public function repair() {
	
		if ((substr(VERSION, 0, 5) == '1.5.5') || (substr(VERSION, 0, 5) == '1.5.6')) {
			$this->language->load('module/' . $this->_name);
		} else {
			$this->load->language('module/' . $this->_name);
		}
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('tool/database');
	
		$this->session->data['output'] = $this->model_tool_database->tableRepair();
	
		$this->session->data['success_repair'] = $this->language->get('text_success_repair');
	
		$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>