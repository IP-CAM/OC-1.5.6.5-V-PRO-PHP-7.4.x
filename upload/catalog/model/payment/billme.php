<?php 
class ModelPaymentBillMe extends Model {
  	public function getMethod() {
		$this->load->language('payment/billme');
		
		if ($this->config->get('billme_status')) {

			// get customer's group
			if ($this->customer->isLogged()) {
				$customer_group_id = $this->customer->getCustomerGroupId();
			} else {
				$customer_group_id = 0;
			}

			// only allow billing if customer is in one of the allowed groups
			$groups = explode(',', $this->config->get('billme_allowed_groups'));
			if (in_array($customer_group_id, $groups)) {
				$status = TRUE;
				// so far, so good, now check for stock restrictions
				$stock_status = $this->config->get('billme_stock_status_id');
				if ($stock_status > 0) {
					// at this point, all products must have the selected out-of-stock status
					$this->load->model('catalog/product');
					foreach ($this->cart->getProducts() as $result) {
						$product = $this->model_catalog_product->getProduct($result['product_id']);
						$product_stock_status = $product['stock_status_id'];
						if ($product_stock_status <>  $stock_status) {
							$status = FALSE;
							break;
						}
					}
				}
			} else {
				$status = FALSE;
			}
		} else {
			$status = FALSE;
		}

		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'         => 'billme',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('billme_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>