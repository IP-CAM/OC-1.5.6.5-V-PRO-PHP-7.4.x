<?php
class ControllerReportDevices extends Controller { 
	public function index() {   
		$this->load->language('report/devices');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['column_device_key']   = $this->language->get('column_device_key');
		$this->data['column_device_name']  = $this->language->get('column_device_name');
		$this->data['column_orders_count'] = $this->language->get('column_orders_count');
		$this->data['column_orders_total'] = $this->language->get('column_orders_total');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end']   = $this->language->get('entry_date_end');

		$this->data['text_device_mobile']     = $this->language->get('text_device_mobile');    
		$this->data['text_device_computer']   = $this->language->get('text_device_computer');
		$this->data['text_device_unknown']    = $this->language->get('text_device_unknown');

		$this->data['text_sort_by']           = $this->language->get('text_sort_by');
		$this->data['text_sort_device_key']   = $this->language->get('text_sort_device_key');
		$this->data['text_sort_orders_total'] = $this->language->get('text_sort_orders_total');    
		$this->data['text_total'] = $this->language->get('text_total');

		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
			'separator' => false
 		);

 		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/devices', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
 		);
    
		$url = '';

		if (isset($this->request->get['filter_date_start'])) {			
			$filter_date_start = $this->request->get['filter_date_start'];
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];      
		} else {
			$filter_date_start = '';    
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

    if (isset($this->request->get['sort'])) {      
      $this->data['sort'] = $this->request->get['sort'];
      $url .= '&sort=' . $this->request->get['sort'];
    } else {
      $this->data['sort'] = "orders_total";
    }    
    		       
		$data_mobile = array(
			'filter_date_start'	=> $filter_date_start, 
			'filter_date_end'	  => $filter_date_end,      
		);
    
		$this->load->model('report/devices');
		    
    // ==============================
    // Setting for view in TPL (Zobrazit u poctu objednavek i cisla objednavek?)
    // ==============================
    $this->data['show_orders_id_mobiles'] = true; 
    $this->data['show_orders_id_computers'] = false;

    // MOBILEs
    
    $mobiles_orders = array();
    $mobiles_counts = 0;
    $mobiles_totals = 0;
    
    $mobiles = array(
      'android'     => 'Android',
      'avantgo'     => 'AvantGo PDA',
      'blackberry'  => 'BlackBerry',
      'bb10'        => 'BlackBerry 10',
      'bolt'        => 'Bolt',
      'boost'       => 'Boost',
      'cricket'     => 'Cricket',
      'docomo'      => 'Docomo',
      'fone'        => 'Fone',
      'hiptop'      => 'Hiptop',
      'ipad'        => 'iPad',
      'iphone'      => 'iPhone',
      'ipod'        => 'iPod',
      'j2me'        => 'J2ME',
      //'mini'        => 'Mini',
      'palm'        => 'Palm',
      //'phone'       => 'Phone', // iPhone
      'pie'         => 'Pie',
      'symbianos'   => 'SymbianOS',
      'tablet'      => 'Tablet',
      'up\.browser' => 'Up Browser',
      'up\.link'    => 'Up Link',
      'webos'       => 'Webos',
      'windows phone' => 'Windows Phone',
      'wos'         => 'Wos',
      );
        
    foreach ($mobiles AS $device_key => $device_name) {
      $result = $this->model_report_devices->getDeviceMobile($device_key, $data_mobile);
      //$resulx = $this->model_report_devices->getDeviceMobile_UPDATE($device_key, $data_mobile);
      if ($result) {
        $orders_count = ( isset($result['orders_count']) ? $result['orders_count'] : 0 );
        $orders_total = ( isset($result['orders_total']) ? $result['orders_total'] : 0 );
        $orders_id    = ( isset($result['orders_id']) ? $result['orders_id'] : '' );
        if ($orders_total > 0) {
          $mobiles_orders[] = array(
            'device_name'  => $device_name,
            'device_key'   => $device_key,            
            'orders_count' => $orders_count,
            'orders_total' => $orders_total,
            'orders_id'    => $orders_id,
          );
          $mobiles_counts += $orders_count;
          $mobiles_totals += $orders_total;
        } 
      }
    } // foreach
    
    // seradi data
    switch ($this->data['sort']) {
      case "device_code":
        $devices = array_orderby('device_name', SORT_ASC, 'orders_total', SORT_DESC, 'orders_count', SORT_DESC, $mobiles_orders);
        break;
      case "orders_total":        
        $devices = array_orderby('orders_total', SORT_DESC, 'orders_count', SORT_DESC, 'device_name', SORT_ASC, $mobiles_orders);
        break;
    } // switch
    $this->data['mobiles_orders'] = $devices;
    $this->data['mobiles_counts'] = $mobiles_counts;
    $this->data['mobiles_totals'] = $mobiles_totals;


    
    // DESKTOPs
  
    $computers_orders = array();
    $computers_counts = 0;
    $computers_totals = 0;

    $computers = array(

      'linux'          => 'Linux',

      'playstation'    => 'PlayStastion',

      ' os x'          => 'Mac OS X', 
      ' os 9'          => 'Mac OS 9',

      'windows nt 6.3' => 'Windows 8.1',
      'windows nt 6.2' => 'Windows 8', 
      'windows nt 6.1' => 'Windows 7', 
      'windows nt 6.0' => 'Windows Vista', 
      'windows nt 5.2' => 'Windows Server 2003/XP x64', 
      'windows nt 5.1' => 'Windows XP', 
      'windows nt 5.0' => 'Windows 2000', 
      'windows me'     => 'Windows ME', 
      'win98'          => 'Windows 98', 
      'win95'          => 'Windows 95', 
      'win16'          => 'Windows 3.11',
       
      );
      
    $data_desktop = array(
			'mobiles'           => $mobiles,
			'filter_date_start'	=> $filter_date_start, 
			'filter_date_end'	  => $filter_date_end,      
		);        

    foreach ($computers AS $device_key => $device_name) {
      $result = $this->model_report_devices->getDeviceDesktop($device_key, $data_desktop);
      //$resulx = $this->model_report_devices->getDeviceDesktop_UPDATE($device_key, $data_desktop);
      if ($result) {
        $orders_count = ( isset($result['orders_count']) ? $result['orders_count'] : 0 );
        $orders_total = ( isset($result['orders_total']) ? $result['orders_total'] : 0 );
        $orders_id    = ( isset($result['orders_id']) ? $result['orders_id'] : '' );
        if ($orders_total > 0) {
          $computers_orders[] = array(
            'device_name'  => $device_name,
            'device_key'   => $device_key,            
            'orders_count' => $orders_count,
            'orders_total' => $orders_total,
            'orders_id'    => $orders_id,
          );
          $computers_counts += $orders_count;
          $computers_totals += $orders_total;
        } 
      }
    } // foreach

    // seradi data
    switch ($this->data['sort']) {
      case "device_code":
        $devices = array_orderby('device_name', SORT_ASC, 'orders_total', SORT_DESC, 'orders_count', SORT_DESC, $computers_orders);
        break;
      case "orders_total":        
        $devices = array_orderby('orders_total', SORT_DESC, 'orders_count', SORT_DESC, 'device_name', SORT_ASC, $computers_orders);
        break;
    } // switch
    $this->data['computers_orders'] = $devices;
    $this->data['computers_counts'] = $computers_counts;
    $this->data['computers_totals'] = $computers_totals;



    // UNKNOWNs
  
    $unknowns_orders = array();
    $unknowns_counts = 0;
    $unknowns_totals = 0;
      
    $unknowns = array(     
      '' => '?'
      );

    $data_unknown = array(
			'mobiles'           => $mobiles,
			'computers'         => $computers,
			'filter_date_start'	=> $filter_date_start, 
			'filter_date_end'	  => $filter_date_end,      
		);        

    foreach ($unknowns AS $device_key => $device_name) {
      $result = $this->model_report_devices->getDeviceUnknown($device_key, $data_unknown);
      if ($result) {
        $orders_count = ( isset($result['orders_count']) ? $result['orders_count'] : 0 );
        $orders_total = ( isset($result['orders_total']) ? $result['orders_total'] : 0 );
        $orders_id    = ( isset($result['orders_id']) ? $result['orders_id'] : '' );
        if ($orders_total > 0) {
          $unknowns_orders[] = array(
            'device_name'  => $device_name,
            'device_key'   => $device_key,            
            'orders_count' => $orders_count,
            'orders_total' => $orders_total,
            'orders_id'    => $orders_id,
          );
          $unknowns_counts += $orders_count;
          $unknowns_totals += $orders_total;
        } 
      }
    } // foreach

    // seradi data
    switch ($this->data['sort']) {
      case "device_code":
        $devices = array_orderby('device_name', SORT_ASC, 'orders_total', SORT_DESC, 'orders_count', SORT_DESC, $unknowns_orders);
        break;
      case "orders_total":        
        $devices = array_orderby('orders_total', SORT_DESC, 'orders_count', SORT_DESC, 'device_name', SORT_ASC, $unknowns_orders);
        break;
    } // switch
    $this->data['unknowns_orders'] = $devices;
    $this->data['unknowns_counts'] = $unknowns_counts;
    $this->data['unknowns_totals'] = $unknowns_totals;


  
		// pripravi data pro sablonu
		$this->data['entry_date_start']  = $this->language->get('entry_date_start');
		$this->data['entry_date_end']    = $this->language->get('entry_date_end');
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end']   = $filter_date_end;
		
		$this->template = 'report/devices.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE));
	}	
}
?>