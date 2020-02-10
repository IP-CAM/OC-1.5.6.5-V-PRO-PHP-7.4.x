<?php
class ControllerReportProductQuantity extends Controller {
	public function index() {     
		$this->load->language('report/product_quantity');

		$this->document->setTitle($this->language->get('heading_title'));
		
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
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/product_quantity', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/product');
		
		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
				
		$product_quantity = $this->model_report_product->getProductsQuantity($data); 
		
		$product_quantity = $this->model_report_product->getProductsQuantity(); 
		
		$this->data['products'] = array();
		
		$results = $this->model_report_product->getProductsQuantity($data);
		
foreach ($results as $result) {
					
			$this->data['products'][] = array(
				'product_id'    => $result['product_id'],
				'name'    => $result['name'],
				'model'   => $result['model'],
				'quantity'  => $result['quantity']			
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_id'] = $this->language->get('column_id');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['button_reset'] = $this->language->get('button_reset');

		$url = '';		
				
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
				
		$this->data['reset'] = $this->url->link('report/product_quantity/reset', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
						
		$pagination = new Pagination();
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/product_quantity', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
				 
		$this->template = 'report/product_quantity.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function reset() {
		$this->load->language('report/product_quantity');
		
		$this->load->model('report/product');
		
		$this->model_report_product->reset();
		
		$this->session->data['success'] = $this->language->get('text_success');
		
		$this->redirect($this->url->link('report/product_quantity', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>