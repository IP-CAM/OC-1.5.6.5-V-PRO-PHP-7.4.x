<?php
class ControllerReportOrdersStatuses extends Controller {
	public function index() {     
		$this->load->language('report/orders_statuses');

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

		if (isset($this->request->get['filter_date_aggregation'])) {
			$filter_date_aggregation = $this->request->get['filter_date_aggregation'];
		} else {
			$filter_date_aggregation = 'week';
		}

		if (isset($this->request->get['filter_date_aggregation'])) {
			$url .= '&filter_date_aggregation=' . $this->request->get['filter_date_aggregation'];
		}

		if (isset($this->request->get['filter_count_type'])) {
			$filter_count_type = $this->request->get['filter_count_type'];
		} else {
			$filter_count_type = 'orders';
		}

		if (isset($this->request->get['filter_count_type'])) {
			$url .= '&filter_count_type=' . $this->request->get['filter_count_type'];
		}
		
		if (isset($this->request->get['filter_no_of_records'])) {
			$filter_no_of_records = (int) $this->request->get['filter_no_of_records'];
			if($filter_no_of_records == 0)
				$filter_no_of_records = $this->config->get('config_admin_limit');
		} else {
			# default is taken from the configuration
			$filter_no_of_records = $this->config->get('config_admin_limit');			
		}

		if (isset($this->request->get['filter_no_of_records'])) {
			$url .= '&filter_no_of_records=' . $filter_no_of_records;
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/orders_statuses', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/sale');
	
		$this->data['orders'] = array();
		
		# contains history records sorted by ID (oldest first)
		# These records contain status of the order and date
		# To know if the status has changed we need to know for each order its previous state to compare it with records
		$results = $this->model_report_sale->getOrdersStatuses();

		# Prepare quantity and totals for orders
		$orders = array();
		if($filter_count_type != 'orders')
		{
			$ordersResults = $this->model_report_sale->getOrdersListAndTotal();
			foreach ($ordersResults as $result) {
				$orders[$result['order_id']]['quantity'] = $result['quantity'];
				$orders[$result['order_id']]['total'] = $result['total'];
			}
		}
	
		# key=order_id, data=latest known status of the order
		$orderStatus=array();
		# key=order_status_id, data is another array with key=date and data set to number of statuses 'added' and 'removed'
		# added and removed are stored separately to show diff in the report
		$statusesByDates=array();
		# Contains cumulated numbers and descriptive text diff, while statusesByDates contains only diff as numbers
		# key=date (might not match the format of date in statusesByDates), data contains:
		#      total - the total number of orders registered in the system by the date
		#      data  - array with key=order_status_id
		#      			- abs   - the total number of orders in specific status on the date    
		#      			- diff  - a text description of change (+/-) in the total number of orders in specific status since the last date    
		$datesCounters=array();

		# composing statusesByDates basing on the data fetched from DB
		#  After that we will know all used statuses (keys in statusesByDates) and
		# the number of changed statuses for each date (data in statusesByDates)
		foreach ($results as $result) {
			
			$newStatus = $result['order_status_id'];
			$newDate   = $result['day_added'];
			$orderId   = $result['order_id'];

			if(array_key_exists($orderId, $orderStatus) &&
			   $orderStatus[$orderId] == $newStatus)
			{
				# this is a history record without status change. Skip it.
				continue;
			}

			if($filter_date_aggregation == 'week')        $newDate   = $result['week_added'];
			else if($filter_date_aggregation == 'month')  $newDate   = $result['month_added'];
			else                                          $newDate   = $result['day_added'];

			# reportCounter represents amounts to be counted in the report
			if($filter_count_type == 'orders')                                               $reportCounter   = 1;
			else if($filter_count_type == 'quantity' && array_key_exists($orderId, $orders)) $reportCounter   = $orders[$orderId]['quantity'];
			else if($filter_count_type == 'total'    && array_key_exists($orderId, $orders)) $reportCounter   = $orders[$orderId]['total'];
			else                                                                             $reportCounter   = 0;
			
			# prepare the full list of dates for the report
			if(!array_key_exists($newDate, $datesCounters))
			{
				$datesCounters[$newDate] = null;
			}
			
			# get ready for ++/-- operations
			if(!array_key_exists($newStatus, $statusesByDates) ||
			   !array_key_exists($newDate, $statusesByDates[$newStatus]))
			{
				$statusesByDates[$newStatus][$newDate]['added'] = 0;
				$statusesByDates[$newStatus][$newDate]['removed'] = 0;
			}
			
			if(!array_key_exists($orderId, $orderStatus))
			{
				# this is a new order, so no need to exclude it from some old status
				$orderStatus[$orderId] = $newStatus;
				$statusesByDates[$newStatus][$newDate]['added'] +=$reportCounter;
			}
			else
			{
				if($orderStatus[$orderId] != $newStatus)
				{
					$oldStatus = $orderStatus[$orderId];
					
					# make sure that we can track old status of the order
					# we will definitely count 'removed' here, but initiate both
					if(!array_key_exists($newDate, $statusesByDates[$oldStatus]))
					{
						$statusesByDates[$oldStatus][$newDate]['added'] = 0;
						$statusesByDates[$oldStatus][$newDate]['removed'] = 0;
					}
					$statusesByDates[$oldStatus][$newDate]['removed'] += $reportCounter;
					$statusesByDates[$newStatus][$newDate]['added'] +=$reportCounter;
					$orderStatus[$orderId] = $newStatus;
				}
			}
		}
		
		# initiate the full table of statuses (all used) by date (all when statuses have changed)
		foreach($datesCounters as $date => $statuses)
		{
			foreach($statusesByDates as $status => $dates)
			{
				$datesCounters[$date][$status]['abs']=0;
				$datesCounters[$date][$status]['diff']="";
			}
		}

		# compose the report in datesCounters
		foreach($statusesByDates as $status => $dates)
		{
			foreach($dates as $date => $noOfStatuses)
			{
				if($noOfStatuses['added'] != 0 || $noOfStatuses['removed'] != 0) 
				{
					$datesCounters[$date][$status]['diff'] = "&nbsp&nbsp[";
					$datesCounters[$date][$status]['diff'] .= ($noOfStatuses['added'] != 0) ? "+".$noOfStatuses['added'] : "";
					$datesCounters[$date][$status]['diff'] .= ($noOfStatuses['added'] != 0 && $noOfStatuses['removed'] != 0) ? "/" : "";
					$datesCounters[$date][$status]['diff'] .= ($noOfStatuses['removed'] != 0) ? "-".$noOfStatuses['removed'] : "";
					$datesCounters[$date][$status]['diff'] .= "]";
				}
				else
				{
					$datesCounters[$date][$status]['diff'] = "";
				}
				
				# calculate the cumulative number of orders in specific status by the date
				foreach($datesCounters as $dateTarget => $noOfStatusesTarget)
				{
					# If order have moved to some status we considered that it stays in that state forever, 
					# so we add it to all the dates in the future.
					# When the order leaves this state we are removing it from all future dates in the same manner
					if($date <= $dateTarget)
					{
						$datesCounters[$dateTarget][$status]['abs'] += $noOfStatuses['added'];
						$datesCounters[$dateTarget][$status]['abs'] -= $noOfStatuses['removed'];
					}
				}
			}
		}

		# get nice text order statuses for culm names
		$this->load->model('localisation/order_status');
		$statusesLocalization = $this->model_localisation_order_status->getOrderStatuses();

		# for each known status we save a text description
		# Since we base	the columns list on statusesByDates, the order of column names will match the report columns	
		foreach($statusesByDates as $status => $dates)
		{
			foreach($statusesLocalization as $statusData)
			{
				if($statusData['order_status_id'] == $status)
					$this->data['columns'][$status] = $statusData['name'];
			}
		}	
		
		# Now all numeric data is ready. Count the total, the diff for it and turn the diff for each status into nice text
		$totalPrev=0;		
		foreach ($datesCounters as $date => $statuses)
		{
			$readableDate = $date . "-" . date('M', strtotime($date));
			$this->data['total'][$readableDate] = 0;
			foreach ($statuses as $status => $noOfStatuses) {
							
				# prepare the text for each date/status: abs [+x/-y]
				$this->data['data'][$readableDate][$status] = $noOfStatuses['abs'] . "&nbsp" . $noOfStatuses['diff'];
				$this->data['total'][$readableDate] += $noOfStatuses['abs'];
			}
			
			# same for total: total abs [+x/-y]
			$totalNew = $this->data['total'][$readableDate];
			if($totalNew != $totalPrev)
			{
				$this->data['total'][$readableDate] = $totalNew . "&nbsp&nbsp[";
				$this->data['total'][$readableDate] .= ($totalNew > $totalPrev) ? "+":"-";
				$this->data['total'][$readableDate] .= $totalNew - $totalPrev ."]";
			}
			
			$totalPrev=$totalNew;
		}
		
		# limit the number of records to show
		$this->data['data'] = array_slice($this->data['data'], -$filter_no_of_records, $filter_no_of_records, true);

		# keep the filter value
		$this->data['filter_count_type'] = $filter_count_type;
		$this->data['filter_date_aggregation'] = $filter_date_aggregation;
		$this->data['filter_no_of_records']    = $filter_no_of_records;
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_description'] = $this->language->get('text_description');
		
		$this->data['column_date'] = $this->language->get('column_date');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_print'] = $this->language->get('button_print');

		$this->data['select_orders'] = $this->language->get('select_orders');
		$this->data['select_quantity'] = $this->language->get('select_quantity');
		$this->data['select_total'] = $this->language->get('select_total') . ", " . $this->config->get('config_currency');
		$this->data['select_day'] = $this->language->get('select_day');
		$this->data['select_week'] = $this->language->get('select_week');
		$this->data['select_month'] = $this->language->get('select_month');
		$this->data['select_no_of_records'] = $this->language->get('select_no_of_records');

		$this->data['token'] = $this->session->data['token'];

		$url = '';		
				
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
				
		$this->data['reset'] = $this->url->link('report/orders_statuses/reset', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->template = 'report/orders_statuses.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function reset() {
		$this->load->language('report/orders_statuses');
		
		$this->load->model('report/product');
		
		$this->model_report_product->reset();
		
		$this->session->data['success'] = $this->language->get('text_success');
		
		$this->redirect($this->url->link('report/orders_statuses', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>