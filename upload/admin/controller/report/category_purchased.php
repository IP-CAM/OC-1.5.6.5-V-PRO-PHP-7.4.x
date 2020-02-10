<?php

class ControllerReportCategoryPurchased extends Controller {
	
	public function index() {   
		$this->language->load('report/category_purchased');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['filter_time_start'])) {
			$filter_time_start = $this->request->get['filter_time_start'];
		} else {
			$filter_time_start = '';
		}

		if (isset($this->request->get['filter_time_end'])) {
			$filter_time_end = $this->request->get['filter_time_end'];
		} else {
			$filter_time_end = '';
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
		
		if (isset($this->request->get['filter_time_start'])) {
			$url .= '&filter_time_start=' . $this->request->get['filter_time_start'];
		}

		if (isset($this->request->get['filter_time_end'])) {
			$url .= '&filter_time_end=' . $this->request->get['filter_time_end'];
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
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/category_purchased', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		
		
		$this->load->model('report/category');

		$this->data['categories'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_time_start'	     => $filter_time_start, 
			'filter_time_end'	     => $filter_time_end, 
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$category_total = $this->model_report_category->getTotalPurchased($data);

		$results = $this->model_report_category->getPurchased($data);

		foreach ($results as $result) {
			$this->data['categories'][] = array(
				'name'       => $result['name'],
				'model'      => $result['model'],
				'quantity'   => $result['quantity'],
				'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		
		$this->data['entry_time_start'] = $this->language->get('entry_time_start');
		$this->data['entry_time_end'] = $this->language->get('entry_time_end');
		
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_export'] = $this->language->get('text_export');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_time_start'])) {
			$url .= '&filter_time_start=' . $this->request->get['filter_time_start'];
		}

		if (isset($this->request->get['filter_time_end'])) {
			$url .= '&filter_time_end=' . $this->request->get['filter_time_end'];
		}

		$pagination = new Pagination();
		$pagination->total = $category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/category_purchased', 'token=' . $this->session->data['token'] . $url . '&page={page}');

		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_time_start'] = $filter_time_start;
		$this->data['filter_time_end'] = $filter_time_end;

		$this->template = 'report/category_purchased.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
		
}
?>