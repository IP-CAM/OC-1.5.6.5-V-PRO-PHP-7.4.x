<?php
class ControllerReportSaleAnalytics extends Controller {
	public function index() {  
		
		$this->language->load('report/sale_analytics');

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

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/sale_analytics', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->load->model('report/analytics');
		
		$this->data['popularDay'] = array();
		$this->data['popularHour'] = array();

		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end
		);
		
		$arrPopularDay = $this->model_report_analytics->mostPopularDay($data);
		$arrPopularHour = $this->model_report_analytics->mostPopularTime($data);
		
		$this->data['column_type'] = $this->language->get('column_type');
	    $this->data['column_value'] = $this->language->get('column_value');
		
		$this->data['text_popular_day'] = $this->language->get('text_popular_day');
		$this->data['text_popular_time'] = $this->language->get('text_popular_time');		

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');

		$this->data['button_filter'] = $this->language->get('button_filter');
		
		$this->data['popularDay'] = $arrPopularDay;	
		$this->data['popularHour'] = $arrPopularHour;				

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['token'] = $this->session->data['token'];

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;

		$this->template = 'report/sale_analytics.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>