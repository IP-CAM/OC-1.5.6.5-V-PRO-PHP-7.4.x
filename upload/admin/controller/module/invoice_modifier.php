<?php
class ControllerModuleInvoicemodifier extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/invoice_modifier');

		$this->document->setTitle($this->language->get('heading_Title'));

		$this->load->model('setting/setting');
		
		
		$this->document->addScript('view/javascript/colpick.js');
		
		$this->document->addStyle('view/stylesheet/colpick.css');
			
		$this->document->addScript('view/javascript/invoice/bootstrap/js/bootstrap.min.js');		
		$this->document->addStyle('view/javascript/invoice/bootstrap/css/bootstrap.min.css');
		$this->document->addStyle('view/javascript/invoice/font-awesome/css/font-awesome.min.css');
		$this->document->addStyle('view/stylesheet/invoice_modifier.css');

		
		//Post the data in database setting table
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('invoice_modifier', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

//for passing variable to .tpl file
		$this->data['heading_title'] = $this->language->get('heading_Title');

		$this->data['text_title'] = $this->language->get('text_title');
		$this->data['text_body'] = $this->language->get('text_body');
		$this->data['text_title_bold'] = $this->language->get('text_title_bold');
		$this->data['text_background'] = $this->language->get('text_background');
		$this->data['text_upload'] = $this->language->get('text_upload');
		$this->data['text_remove'] = $this->language->get('text_remove');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['entry_logo'] = $this->language->get('entry_logo');
		$this->data['entry_add1'] = $this->language->get('entry_add1');
		$this->data['entry_add2'] = $this->language->get('entry_add2');
		$this->data['entry_contact'] = $this->language->get('entry_contact');
		$this->data['entry_store_time'] = $this->language->get('entry_store_time');
		$this->data['entry_font'] = $this->language->get('entry_font');
		$this->data['entry_color'] = $this->language->get('entry_color');
		$this->data['entry_title_bg'] = $this->language->get('entry_title_bg');
		$this->data['entry_title_bold'] = $this->language->get('entry_title_bold');
		$this->data['entry_add_req'] = $this->language->get('entry_add_req');
		
		$this->data['ins_logo'] = $this->language->get('ins_logo');
		$this->data['ins_add'] = $this->language->get('ins_add');
		$this->data['ins_font'] = $this->language->get('ins_font');
		$this->data['ins_bg'] = $this->language->get('ins_bg');
		$this->data['ins_bold'] = $this->language->get('ins_bold');
		$this->data['more_help'] = $this->language->get('more_help');
				
		$this->data['button_stay'] = $this->language->get('button_stay');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

//For passing error variable

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['contact'])) {
			$this->data['error_contact'] = $this->error['contact'];
		} else {
			$this->data['error_contact'] = '';
		}
		
		//Check error for title
		if (isset($this->error['error_tfontsize'])) {
			$this->data['error_tfont_size'] = $this->error['error_tfontsize'];
		} else {
			$this->data['error_tfont_size'] = '';
		}
		
		if (isset($this->error['error_tfontcolour'])) {
			$this->data['error_tfont_colour'] = $this->error['error_tfontcolour'];
		} else {
			$this->data['error_tfont_colour'] = '';
		}
		//End
		
		//Check error for body		
		if (isset($this->error['error_bfontsize'])) {
			$this->data['error_bfont_size'] = $this->error['error_bfontsize'];
		} else {
			$this->data['error_bfont_size'] = '';
		}
		
		if (isset($this->error['error_bfontcolour'])) {
			$this->data['error_bfont_colour'] = $this->error['error_bfontcolour'];
		} else {
			$this->data['error_bfont_colour'] = '';
		}
		//End
		if (isset($this->error['error_bg_colour'])) {
			$this->data['error_background'] = $this->error['error_bg_colour'];
		} else {
			$this->data['error_background'] = '';
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
			'text'      => $this->language->get('heading_Title'),
			'href'      => $this->url->link('module/invoice_modifier', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/invoice_modifier', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
				
		$this->data['token'] = $this->session->data['token'];

		$this->data['modules'] = array();

		//Get data from table 'setting'
		$this->load->model('tool/image');
		
		if (isset($this->request->post['invoice_logo'])) {
			$this->data['invoice_logo'] = $this->request->post['invoice_logo'];
		} else {
			$this->data['invoice_logo'] = $this->config->get('invoice_logo');			
		}

		if ($this->config->get('invoice_logo') && file_exists(DIR_IMAGE . $this->config->get('invoice_logo')) && is_file(DIR_IMAGE . $this->config->get('invoice_logo'))) {
			$this->data['logo'] = $this->model_tool_image->resize($this->config->get('invoice_logo'), 100, 100);		
		} else {
			$this->data['logo'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['module_address_1'])) {
			$this->data['module_address_1'] = $this->request->post['module_address_1'];
		} elseif ($this->config->get('module_address_1')) { 
			$this->data['module_address_1'] = $this->config->get('module_address_1');
		} else { 
			$this->data['module_address_1'] = $this->config->get('config_address');
		}
		
		if (isset($this->request->post['module_address_req'])) {
			$this->data['module_address_req'] = $this->request->post['module_address_req'];
		} elseif ($this->config->get('module_address_1')) { 
			$this->data['module_address_req'] = $this->config->get('module_address_req');
		} else { 
			$this->data['module_address_req'] = '0';
		}
		
		if (isset($this->request->post['module_address_2'])) {
			$this->data['module_address_2'] = $this->request->post['module_address_2'];
		} elseif ($this->config->get('module_address_2')) { 
			$this->data['module_address_2'] = $this->config->get('module_address_2');
		} else { 
			$this->data['module_address_2'] = '';
		}		
		
		if (isset($this->request->post['module_contact_no'])) {
			$this->data['module_contact_no'] = $this->request->post['module_contact_no'];
		} elseif ($this->config->get('module_contact_no')) { 
			$this->data['module_contact_no'] = $this->config->get('module_contact_no');
		} else { 
			$this->data['module_contact_no'] = $this->config->get('config_telephone');
		}	
		
		if (isset($this->request->post['module_store_time'])) {
			$this->data['module_store_time'] = $this->request->post['module_store_time'];
		} elseif ($this->config->get('module_store_time')) { 
			$this->data['module_store_time'] = $this->config->get('module_store_time');
		}else { 
			$this->data['module_store_time'] = '';
		}	
		
		if (isset($this->request->post['module_title_fontsize'])) {
			$this->data['module_title_fontsize'] = $this->request->post['module_title_fontsize'];
		} elseif ($this->config->get('module_title_fontsize')) { 
			$this->data['module_title_fontsize'] = $this->config->get('module_title_fontsize');
		}else { 
			$this->data['module_title_fontsize'] = '12';
		}	
		
		if (isset($this->request->post['module_title_fontcolor'])) {
			$this->data['module_title_fontcolor'] = $this->request->post['module_title_fontcolor'];
		} elseif ($this->config->get('module_title_fontcolor')) { 
			$this->data['module_title_fontcolor'] = $this->config->get('module_title_fontcolor');
		} else { 
			$this->data['module_title_fontcolor'] = '000000';
		}
		
		if (isset($this->request->post['module_body_fontsize'])) {
			$this->data['module_body_fontsize'] = $this->request->post['module_body_fontsize'];
		} elseif ($this->config->get('module_body_fontsize')) { 
			$this->data['module_body_fontsize'] = $this->config->get('module_body_fontsize');
		} else { 
			$this->data['module_body_fontsize'] = '12';
		}
		
		if (isset($this->request->post['module_body_fontcolor'])) {
			$this->data['module_body_fontcolor'] = $this->request->post['module_body_fontcolor'];
		} elseif ($this->config->get('module_body_fontcolor')) { 
			$this->data['module_body_fontcolor'] = $this->config->get('module_body_fontcolor');
		} else { 
			$this->data['module_body_fontcolor'] = '000000';
		}
		
		if (isset($this->request->post['module_title_bg'])) {
			$this->data['module_title_bg'] = $this->request->post['module_title_bg'];
		} elseif ($this->config->get('module_title_bg')) { 
			$this->data['module_title_bg'] = $this->config->get('module_title_bg');
		} else { 
			$this->data['module_title_bg'] = 'e7efef';
		}
		
		if (isset($this->request->post['module_title_bold'])) {
			$this->data['module_title_bold'] = $this->request->post['module_title_bold'];
		} elseif ($this->config->get('module_title_bold')) { 
			$this->data['module_title_bold'] = $this->config->get('module_title_bold');
		} else { 
			$this->data['module_title_bold'] ='0';
		}
		
		$this->template = 'module/invoice_modifier.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	public function modify() {
		
		$this->language->load('module/invoice_modifier');
		
		$this->load->model('setting/setting');
		
			$this->model_setting_setting->editSetting('invoice_modifier', $this->request->get);		
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->setOutput(json_encode($this->session->data['success']));
	}

	protected function validate() {
		
		$error = array();
		if (!$this->user->hasPermission('modify', 'module/invoice_modifier')) {
			$error[] = $this->error['warning'] = $this->language->get('error_permission');
		}	
		
		if(!empty($this->request->post['module_contact_no'])){
			if(!is_numeric($this->request->post['module_contact_no']) || utf8_strlen(($this->request->post['module_contact_no']))!== 10)
			{
			$this->error['contact'] = $this->language->get('error_contact');
			}
		}
		
		//Validation for font size 
		if(!empty($this->request->post['module_title_fontsize'])){
			if (!is_numeric($this->request->post['module_title_fontsize']) || utf8_strlen($this->request->post['module_title_fontsize']) !== 2 )
			{
				$this->error['error_tfontsize'] = $this->language->get('error_font_size');
			}
		}
		
		if(!empty($this->request->post['module_body_fontsize'])){
			if (!is_numeric($this->request->post['module_body_fontsize']) || utf8_strlen($this->request->post['module_body_fontsize']) !== 2)
			{
				$this->error['error_bfontsize'] = $this->language->get('error_font_size');
			}
		}
		//End font size

		//Start validation  font color 
		if(!empty($this->request->post['module_title_fontcolor'])){
			if (utf8_strlen($this->request->post['module_title_fontcolor']) !== 6 || !preg_match('/^[0-9a-fA-F]+$/', $this->request->post['module_title_fontcolor']))
			{
				$this->error['error_tfontcolour'] = $this->language->get('error_font_colour');
			}
		}
		
		if(!empty($this->request->post['module_body_fontcolor'])){
			if (utf8_strlen($this->request->post['module_body_fontcolor']) !== 6 || !preg_match('/^[0-9a-fA-F]+$/', $this->request->post['module_body_fontcolor']))
			{
				$this->error['error_bfontcolour'] = $this->language->get('error_font_colour');
			}
		}
		
		if(!empty($this->request->post['module_title_bg'])){
			if (utf8_strlen($this->request->post['module_title_bg']) !== 6 || !preg_match('/^[0-9a-fA-F]+$/', $this->request->post['module_title_bg']))
			{
				$this->error['error_bg_colour'] = $this->language->get('error_background');
			}
		}
		//End validation
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>