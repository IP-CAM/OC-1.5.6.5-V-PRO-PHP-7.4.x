<?php
class ControllerModuleMassPrice extends Controller {

	
	public function index() {   

		$this->load->language('module/mass_price');
		$this->load->model('mass_price/mass_price');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		
		//$this->load->model('sale/customer_group');
		//$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		$this->load->model('catalog/category');
				
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		
		if (isset($this->request->post['product_category'])) {
			$this->data['product_category'] = $this->request->post['product_category'];
		} elseif (isset($product_info)) {
			$this->data['product_category'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$this->data['product_category'] = array();
		}		
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
	
			$this->model_setting_setting->editSetting('mass_price', $this->request->post);		
			
			
			$this->session->data['success'] = $this->language->get('text_success');		
			
			$cats = ((isset($this->request->post['product_category']))?implode(",",$this->request->post['product_category']):0);
			
			$data = $this->model_mass_price_mass_price->updatePrice($this->request->post['mass_percent'], $cats, $this->request->post['mass_date_available'],$this->request->post['mass_quantity'], $this->request->post['mass_sign'], $this->request->post['substract_stock'], $this->request->post['minimal_quantity']);
			
			
			
			if( isset( $this->request->post['mode'] ) && $this->request->post['mode'] == 'apply' ) {
				$this->redirect(HTTPS_SERVER . 'index.php?route=module/mass_price&token=' . $this->session->data['token']);
			}else{
				$this->redirect(HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token']);
			}
			
			
			
			
		}
		
		if( isset( $this->session->data['success'] ) ) {
			$this->data['success'] = $this->session->data['success'];
			unset( $this->session->data['success'] );
		}else{
			$this->data['success'] = '';
		}
		
		$text_strings = array(
				'heading_title',
				'text_enabled',
				'text_disabled',
				'entry_status',
				'entry_discount_rate',
				'entry_discount_note',
				'entry_date_available',
				'entry_mass_quantity',
				'button_apply',
				'button_save',
				'button_cancel',
				'entry_category',
				'text_select_all',
				'text_unselect_all',
				'entry_substract_stock',
				'entry_yes',
				'entry_no',
				'entry_minimal_quantity'
		);
				
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}

		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->data['breadcrumbs'][] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=module/mass_price&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=module/mass_price&token=' . $this->session->data['token'];
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/module&token=' . $this->session->data['token'];



		$config_data = array(
				'mass_price_status',
				'mass_percent',
				'mass_date_available',
				'mass_quantity',
				'mass_sign',
				'substract_stock',
				'minimal_quantity'
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}		
		
		
		$this->template = 'module/mass_price.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/mass_price')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>