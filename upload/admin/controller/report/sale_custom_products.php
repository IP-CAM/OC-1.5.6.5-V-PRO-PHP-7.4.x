<?php
class ControllerReportSaleCustomProducts extends Controller { 

	public function index() {  
		$this->load->language('report/sale_custom_products');

		$this->document->setTitle($this->language->get('heading_title'));

        $data = array();
		$url = '';

        # fill stuff:
        # arrays
        $filters = array('order_status_id','shipping_country_id','payment_country_id','shipping_zone_id','payment_zone_id','customer_group_id','payment','product_id','category_id');
        foreach ($filters as $filter) {
            ${'filter_'.$filter} = array();
            if ( isset($this->request->get['filter_'.$filter]) ) {
                ${'filter_'.$filter} = array_filter(explode(',',urldecode($this->request->get['filter_'.$filter])),'is_numeric');
                $url .= '&filter_'.$filter.'='.$this->request->get['filter_'.$filter];
            }
            $this->data['entry_'.$filter] = $this->language->get('entry_'.$filter);
            $this->data['filter_'.$filter] = $data['filter_'.$filter] = ${'filter_'.$filter};
        }

        # single values
        $filters = array('date_start','date_end','total_min','total_max','reward_min','reward_max','export','noshipping','points','debug_sql');
        foreach ($filters as $filter) {
            ${'filter_'.$filter} = '';
            if ( isset($this->request->get['filter_'.$filter]) ) {
                ${'filter_'.$filter} = $this->request->get['filter_'.$filter];
                $url .= '&filter_'.$filter.'='.$this->request->get['filter_'.$filter];
            }
            $this->data['entry_'.$filter] = $this->language->get('entry_'.$filter);
            $this->data['filter_'.$filter] = $data['filter_'.$filter] = ${'filter_'.$filter};
        }

		$filter_group = ( empty($this->request->get['filter_group']) ? '' : $this->request->get['filter_group'] );
		if ( $filter_group ) $url .= '&filter_group='.$filter_group;
        $this->data['filter_group'] = $data['filter_group'] = $filter_group;
		
		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}
		
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/sale_custom_products', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->load->model('report/sale');
		
		$this->data['orders'] = array();
		
		$data['start'] = ($page - 1) * $this->config->get('config_admin_limit');
        $data['limit'] = $this->config->get('config_admin_limit');

        $this->load->model('report/custom');

        $this->data['delivery_countries'] = $this->model_report_custom->getDeliveryCountries();
        $this->data['countries'] = $this->model_report_custom->getCountries();
        $this->data['delivery_zones'] = $this->model_report_custom->getDeliveryZones();
        $this->data['zones'] = $this->model_report_custom->getZones();
        $this->data['customer_groups'] = $this->model_report_custom->getCustomerGroups();
        $this->data['products'] = $this->model_report_custom->getProducts();
        $this->data['categories'] = $this->model_report_custom->getCategories();

        # save some ticks on export
		$order_total = $filter_export ? '' : $this->model_report_custom->getTotalOrdersProducts($data);
        if ( $filter_debug_sql && !$filter_export ) $this->data['debug_sql'] = $this->model_report_custom->prepareProductsSQL($data);

        # do full list for export
        if ( $filter_export ) unset($data['start'],$data['limit']);

		$results = $this->model_report_custom->getOrdersProducts($data);
		
		foreach ($results as $result) {
			$this->data['orders'][] = array(
				'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])).(isset($result['dayname']) ? ' ('.$this->language->get($result['dayname']).')' : ''),
				'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
                'ds'         => strtotime($result['date_start']),
                'de'         => strtotime($result['date_end']),
				'orders'     => $result['orders'],
				'products'   => $result['products'],
				'tax'        => $this->currency->format($result['tax'],false,false,false),
                'reward'     => $this->currency->format($result['reward'],false,false,false),
				'total'      => $this->currency->format($result['total'],false,false,false)
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');
		
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
    	$this->data['column_orders'] = $this->language->get('column_orders');
		$this->data['column_products'] = $this->language->get('column_products');
		$this->data['column_reward'] = $this->language->get('column_reward');
		$this->data['column_tax'] = $this->language->get('column_tax').', '.$this->config->get('config_currency');
		$this->data['column_total'] = $this->language->get('column_total').', '.$this->config->get('config_currency');
		
		$this->data['entry_group'] = $this->language->get('entry_group');	
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_export'] = $this->language->get('button_export');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->data['groups'] = array();

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_year'),
			'value' => 'year',
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_month'),
			'value' => 'month',
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_week'),
			'value' => 'week',
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_day'),
			'value' => 'day',
		);

        $this->data['payments'][] = array(
            'text'  => $this->language->get('text_paid_money'),
            'value' => '1',
        );

        $this->data['payments'][] = array(
            'text'  => $this->language->get('text_paid_points'),
            'value' => '2',
        );

        if ($filter_export) {
            $this->template = 'report/sale_custom_products_export.tpl';
            $this->response->addHeader('Content-Type: application/vnd.ms-excel; charset=UTF-8');
            $this->response->addHeader('Content-Disposition: attachment; filename="custom_products_report-'.date('YmdHis').'.xls"');
            $this->response->setOutput($this->render());
            return;
        }


		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/sale_custom_products', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();		
				 
		$this->template = 'report/sale_custom_products.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

    public function details() {

        $json = array();

        $this->load->language('report/sale_custom_products');

        $data = array();

        # fill stuff, like in index()
        # arrays
        $filters = array('order_status_id','shipping_country_id','payment_country_id','shipping_zone_id','payment_zone_id','customer_group_id','payment','product_id','category_id');
        foreach ($filters as $filter) {
            ${'filter_'.$filter} = array();
            if ( isset($this->request->get['filter_'.$filter]) ) ${'filter_'.$filter} = array_filter(explode(',',urldecode($this->request->get['filter_'.$filter])),'is_numeric');
            $this->data['filter_'.$filter] = $data['filter_'.$filter] = ${'filter_'.$filter};
        }

        # single values
        $filters = array('date_start','date_end','total_min','total_max','reward_min','reward_max','export','noshipping','points','debug_sql','ds','de');
        foreach ($filters as $filter) {
            ${'filter_'.$filter} = '';
            if ( isset($this->request->get['filter_'.$filter]) ) ${'filter_'.$filter} = $this->request->get['filter_'.$filter];
            $this->data['filter_'.$filter] = $data['filter_'.$filter] = ${'filter_'.$filter};
        }

        $words=array('column_model','column_name','column_price','column_total','column_tax','column_info','column_quantity','text_from','text_to','text_no_results','button_close','button_export','text_details','column_reward');
        foreach ($words as $word) $this->data[$word] = $this->language->get($word);

        $this->data['date_start'] = date($this->language->get('date_format_short'), intval($filter_ds));
        $this->data['date_end'] = date($this->language->get('date_format_short'), intval($filter_de));

        # a little bit of hardcode ;)
        preg_match('/(sale_custom_products.*)$/',$this->request->server['REQUEST_URI'],$matches);

        $this->data['export_uri'] = ($filter_export ? '' : $this->url->link('report/'.trim($matches[1]).'&filter_export=1','','SSL') );

        $this->data['products'] = array();
        $this->load->model('report/custom');

        $results = $this->model_report_custom->getProductsDetails($data);

        foreach ($results as $result) {
            $this->data['products'][] = array(
                'model'      => $result['model'],
                'quantity'   => $result['quantity'],
                'name'       => $result['name'],
                'price'      => $this->currency->format($result['price'],false,false,false),
                'tax'        => $this->currency->format($result['tax'],false,false,false),
                'reward'     => $this->currency->format($result['reward'],false,false,false),
                'total'      => $this->currency->format($result['total'],false,false,false),
            );
        }

        $this->template = 'report/sale_custom_products_details.tpl';

        if ($filter_export) {
            $this->response->addHeader('Content-Type: application/vnd.ms-excel; charset=UTF-8');
            $this->response->addHeader('Content-Disposition: attachment; filename="custom_products_report-'.date('YmdHis').'.xls"');
            $this->response->setOutput($this->render());
            return;
        }

        $json['output'] = $this->render();

        $this->response->setOutput(json_encode($json));
    }
}
?>