<?php
class ModelReportCustom extends Model {
	
	public function getDeliveryCountries() {

		$sql = 'SELECT DISTINCT o.shipping_country_id AS value, IFNULL(c.name,"unnamed") AS text
                    FROM `'.DB_PREFIX.'order` o 
                    LEFT JOIN `'.DB_PREFIX.'country` c ON (o.shipping_country_id=c.country_id) 
                    WHERE o.order_status_id > 0 AND o.store_id='.(int)$this->config->get('config_store_id').'
                    ORDER BY c.name ASC';
		$query = $this->db->query($sql);
		return $query->rows;	
	}	

    public function getCountries() {

        $sql = 'SELECT DISTINCT o.payment_country_id AS value, IFNULL(c.name,"unnamed") AS  text
            FROM `'.DB_PREFIX.'order` o 
            LEFT JOIN `'.DB_PREFIX.'country` c ON (o.payment_country_id=c.country_id) 
            WHERE o.order_status_id > 0 AND o.store_id='.(int)$this->config->get('config_store_id').'
            ORDER BY c.name ASC';
        $query = $this->db->query($sql);
        return $query->rows;

    }

    public function getDeliveryZones() {

        $sql = 'SELECT DISTINCT o.shipping_zone_id AS value, IFNULL(z.name,"unnamed") AS text
            FROM `'.DB_PREFIX.'order` o 
            LEFT JOIN `'.DB_PREFIX.'zone` z ON (o.shipping_zone_id=z.zone_id) 
            WHERE o.order_status_id > 0 AND o.store_id='.(int)$this->config->get('config_store_id').'
            ORDER BY z.country_id,z.name ASC';
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getZones() {

        $sql = 'SELECT DISTINCT o.payment_zone_id AS value, IFNULL(z.name,"unnamed") AS text
            FROM `'.DB_PREFIX.'order` o 
            LEFT JOIN `'.DB_PREFIX.'zone` z ON (o.payment_zone_id=z.zone_id) 
            WHERE o.order_status_id > 0 AND o.store_id='.(int)$this->config->get('config_store_id').'
            ORDER BY z.country_id,z.name ASC';
        $query = $this->db->query($sql);
        return $query->rows;

    }

    public function getCustomerGroups() {

        $sql = 'SELECT DISTINCT o.customer_group_id AS value, IFNULL(g.name,"unnamed") AS text
                FROM `'.DB_PREFIX.'order` o
                LEFT JOIN `'.DB_PREFIX.'customer_group_description` g ON (o.customer_group_id=g.customer_group_id) 
                WHERE o.order_status_id > 0 AND o.store_id='.(int)$this->config->get('config_store_id').' 
                    AND g.language_id='.(int)$this->config->get('config_language_id').'
                ORDER BY g.name ASC';

        $query = $this->db->query($sql);
        return $query->rows;
    }


    public function getProducts() {

        $sql = 'SELECT DISTINCT(o.product_id) AS value, IFNULL(p.model,"unnamed") AS text
            FROM `'.DB_PREFIX.'order_product` o
            LEFT JOIN `'.DB_PREFIX.'product` p ON (o.product_id = p.product_id)
            LEFT JOIN `'.DB_PREFIX.'product_to_store` s ON (o.product_id = s.product_id)
            WHERE s.store_id='.(int)$this->config->get('config_store_id').'
            ORDER BY p.model ASC';
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCategories() {

        $sql = 'SELECT DISTINCT(d.category_id) AS value, IFNULL(d.name,"unnamed") AS text 
                    FROM `'.DB_PREFIX.'category_description` d 
                    LEFT JOIN `'.DB_PREFIX.'category_to_store` s ON (d.category_id = s.category_id)
                    WHERE d.language_id = '.(int)$this->config->get('config_language_id').' AND s.store_id = '.(int)$this->config->get('config_store_id').'
                    ORDER BY d.name ASC';
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getShippingCodes() {

        $sql = 'SELECT DISTINCT(o.shipping_code) AS value, IFNULL(o.shipping_method,"unnamed") AS text 
                    FROM `'.DB_PREFIX.'order` o
                    WHERE o.store_id = '.(int)$this->config->get('config_store_id').'
                    ORDER BY `text` ASC';
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getPaymentCodes() {

        $sql = 'SELECT DISTINCT(o.payment_code) AS value, IFNULL(o.payment_method,"unnamed") AS text 
                    FROM `'.DB_PREFIX.'order` o
                    WHERE o.store_id = '.(int)$this->config->get('config_store_id').'
                    ORDER BY `text` ASC';
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getOrders($data = array()) {

        $sql = $this->prepareSQL($data);

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getOrdersProducts($data = array()) {

        $sql = $this->prepareProductsSQL($data);

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalOrders($data = array()) {
        $sql = $this->prepareSQL($data);
        $query = $this->db->query($sql);
        return $query->num_rows;
    }

    public function getTotalOrdersProducts($data = array()) {
        $sql = $this->prepareProductsSQL($data);
        $query = $this->db->query($sql);
        return $query->num_rows;
    }



    public function prepareSQL($data = array()) {

        $group = empty($data['filter_group']) ? '' : $data['filter_group'];

        $sql_products = array();
        $sql_shipping = '';

        if ( !empty($data['filter_noshipping']) ) {
            $sql_shipping = 'LEFT JOIN (SELECT order_id, SUM(value) AS shipping FROM `'.DB_PREFIX.'order_total` WHERE code = "shipping" GROUP BY order_id) s ON (o.order_id = s.order_id)';
        }
   
        # fancy week grouping 
        $sql_week = ( $group == 'week' || $group == 'day' ? ', DAYNAME(o.date_added) AS `dayname` ' : '' );

        $sql = 'SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, COUNT(o.order_id) AS `orders`,
                       SUM(p.quantity) AS products, SUM(r.reward) AS reward, SUM(tax) AS tax, 
                       SUM(o.total'.($sql_shipping ? '-IFNULL(s.shipping,0)' : '' ).(!empty($data['filter_points']) ? '+IFNULL(g.points,0)' : '' ).') AS total
                       '.$sql_week.'
                FROM `'.DB_PREFIX.'order` o 
                LEFT JOIN (SELECT order_id, SUM(quantity) AS quantity FROM `'.DB_PREFIX.'order_product` WHERE product_id > 0 GROUP BY order_id) p ON (o.order_id = p.order_id)
                LEFT JOIN (SELECT order_id, SUM(reward) AS reward FROM `'.DB_PREFIX.'order_product` GROUP BY order_id) r ON (o.order_id = r.order_id)
                LEFT JOIN (SELECT order_id, SUM(value) AS tax FROM `'.DB_PREFIX.'order_total` WHERE code = "tax" GROUP BY order_id) t ON (o.order_id = t.order_id)
                LEFT JOIN (SELECT order_id, SUM(total) AS points FROM `'.DB_PREFIX.'order_product` WHERE product_id=0 GROUP BY order_id) g ON (o.order_id = g.order_id)
                '.$sql_shipping.'
                WHERE p.quantity>0 AND o.store_id = '.(int)$this->config->get('config_store_id').'
                ';



        # filter_order_status_id
        # filter zero
        if ( !empty($data['filter_order_status_id']) ) $data['filter_order_status_id'] = array_filter($data['filter_order_status_id']);
        $sql .= ' AND o.order_status_id'.( !empty($data['filter_order_status_id']) ? ' IN ('.implode(',',$data['filter_order_status_id']).')' : '> 0' );

        # filter_date_start
        if ( !empty($data['filter_date_start']) ) $sql .= ' AND DATE(o.date_added) >= "'.$this->db->escape($data['filter_date_start']).'"';

        # filter_date_end
        if ( !empty($data['filter_date_end']) ) $sql .= ' AND DATE(o.date_added) <= "'.$this->db->escape($data['filter_date_end']).'"';

        # filter_delivery_country_id
        if ( !empty($data['filter_shipping_country_id']) ) $sql .= ' AND o.shipping_country_id IN ('.implode(',',$data['filter_shipping_country_id']).')';

        # filter_payment_country_id
        if ( !empty($data['filter_payment_country_id']) ) $sql .= ' AND o.payment_country_id IN ('.implode(',',$data['filter_payment_country_id']).')';

        # filter_delivery_zone_id
        if ( !empty($data['filter_shipping_zone_id']) ) $sql .= ' AND o.shipping_zone_id IN ('.implode(',',$data['filter_shipping_zone_id']).')';

        # filter_payment_zone_id
        if ( !empty($data['filter_payment_zone_id']) ) $sql .= ' AND o.payment_zone_id IN ('.implode(',',$data['filter_payment_zone_id']).')';

        # filter_customer_group
        if ( !empty($data['filter_customer_group_id']) ) $sql .= ' AND o.customer_group_id IN ('.implode(',',$data['filter_customer_group_id']).')';

        # filter_total_min
        if ( !empty($data['filter_total_min']) ) 
            $sql .= ' AND (o.total'.($sql_shipping ? '-IFNULL(s.shipping,0)' : '' ).(!empty($data['filter_points']) ? '+IFNULL(g.points,0)' : '' ).') >= '. floatval($data['filter_total_min']);

        # filter_total_max
        if ( !empty($data['filter_total_max']) ) 
            $sql .= ' AND (o.total'.($sql_shipping ? '-IFNULL(s.shipping,0)' : '' ).(!empty($data['filter_points']) ? '+IFNULL(g.points,0)' : '' ).') <= '. floatval($data['filter_total_max']);

        # filter_reward_min
        if ( !empty($data['filter_reward_min']) ) $sql .= ' AND r.reward >='. floatval($data['filter_reward_min']);

        # filter_reward_max
        if ( !empty($data['filter_reward_max']) ) $sql .= ' AND r.reward <='. floatval($data['filter_reward_max']);


        # filter_payment
        if ( !empty($data['filter_payment']) ) {
            $sql_product_payment = '';
            # money
            if ( in_array(1,$data['filter_payment']) )  $sql_product_payment[] = ' g.points IS NULL ';
            # points
            if ( in_array(2,$data['filter_payment']) )  $sql_product_payment[] = ' g.points IS NOT NULL '; 
            $sql .= ' AND ('.implode(' OR ',$sql_product_payment).') ';
        }

        # filter_shipping_code
        if ( !empty($data['filter_shipping_code']) ) $sql .= ' AND o.shipping_code IN ("'.implode('","',array_map(array($this->db,"escape"),$data['filter_shipping_code'])).'")';
        # filter_payment_code
        if ( !empty($data['filter_payment_code']) ) $sql .= ' AND o.payment_code IN ("'.implode('","',array_map(array($this->db,"escape"),$data['filter_payment_code'])).'")';


        $sql .= "\n".' GROUP BY ';


        switch($group) {
            case 'day';
                $sql .= 'DATE(o.date_added) ORDER BY DATE(o.date_added) DESC';
                break;
            case 'week':
                $sql .= 'DAYOFWEEK(o.date_added) ORDER BY DAYOFWEEK(o.date_added)';
                break;
            case 'month':
                $sql .= 'DATE_FORMAT(o.date_added,"%m-%Y") ORDER BY (o.date_added) DESC';
                break;
            default:
                $sql .= 'YEAR(o.date_added) ORDER BY YEAR(o.date_added) DESC';
        }

        return $sql;
    }

    public function prepareProductsSQL($data = array()) { 

        $group = empty($data['filter_group']) ? '' : $data['filter_group'];

        $sql_products = array();

        # filter_product_id
        if ( !empty($data['filter_product_id']) ) {
            $sql_products[] = 'product_id IN ('.implode(',',$data['filter_product_id']).')';
        }
        # filter_category_id
        if ( !empty($data['filter_category_id']) ) {
            $sql_products[] = 'product_id IN (SELECT product_id 
                                                FROM `'.DB_PREFIX.'product_to_category` 
                                                WHERE category_id IN ('.implode(',',$data['filter_category_id']).'))';
        }

        # filter_total_min
        if ( !empty($data['filter_total_min']) ) $sql_products[] = 'price >= '. floatval($data['filter_total_min']);

        # filter_total_max
        if ( !empty($data['filter_total_max']) ) $sql_products[] = 'price <= '. floatval($data['filter_total_max']);

        # filter_reward_min
        if ( !empty($data['filter_reward_min']) ) $sql_products[] = 'reward >= '. floatval($data['filter_reward_min']);

        # filter_reward_max
        if ( !empty($data['filter_reward_max']) ) $sql_products[] = 'reward <= '. floatval($data['filter_reward_max']);

        $sql_product = $sql_products ? ' AND '.implode(' AND ',$sql_products) : '';

        # fancy week grouping 
        $sql_week = ( $group == 'week' || $group == 'day' ? ', DAYNAME(o.date_added) AS `dayname` ' : '' );

        $sql = 'SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, COUNT(o.order_id) AS `orders`,
                       SUM(p.quantity) AS products, SUM(p.tax) AS tax, SUM(p.reward) AS reward,
                       SUM(p.total) AS total '.$sql_week.'
                FROM `'.DB_PREFIX.'order` o 
                LEFT JOIN (SELECT order_id, SUM(quantity) AS quantity, SUM(total) AS total, SUM(tax) AS tax, SUM(reward) AS reward 
                            FROM `'.DB_PREFIX.'order_product` WHERE product_id >0 '.$sql_product.' 
                            GROUP BY order_id) p ON (o.order_id = p.order_id)
                WHERE p.quantity>0 AND o.store_id = '.(int)$this->config->get('config_store_id').'
                ';



        # filter_order_status_id
        # filter zero
        if ( !empty($data['filter_order_status_id']) ) $data['filter_order_status_id'] = array_filter($data['filter_order_status_id']);
        $sql .= ' AND o.order_status_id'.( !empty($data['filter_order_status_id']) ? ' IN ('.implode(',',$data['filter_order_status_id']).')' : '> 0' );

        # filter_date_start
        if ( !empty($data['filter_date_start']) ) $sql .= ' AND DATE(o.date_added) >= "'.$this->db->escape($data['filter_date_start']).'"';

        # filter_date_end
        if ( !empty($data['filter_date_end']) ) $sql .= ' AND DATE(o.date_added) <= "'.$this->db->escape($data['filter_date_end']).'"';

        # filter_delivery_country_id
        if ( !empty($data['filter_shipping_country_id']) ) $sql .= ' AND o.shipping_country_id IN ('.implode(',',$data['filter_shipping_country_id']).')';

        # filter_payment_country_id
        if ( !empty($data['filter_payment_country_id']) ) $sql .= ' AND o.payment_country_id IN ('.implode(',',$data['filter_payment_country_id']).')';

        # filter_delivery_zone_id
        if ( !empty($data['filter_shipping_zone_id']) ) $sql .= ' AND o.shipping_zone_id IN ('.implode(',',$data['filter_shipping_zone_id']).')';

        # filter_payment_zone_id
        if ( !empty($data['filter_payment_zone_id']) ) $sql .= ' AND o.payment_zone_id IN ('.implode(',',$data['filter_payment_zone_id']).')';

        # filter_customer_group
        if ( !empty($data['filter_customer_group_id']) ) $sql .= ' AND o.customer_group_id IN ('.implode(',',$data['filter_customer_group_id']).')';

        $sql .= "\n".' GROUP BY ';


        switch($group) {
            case 'day';
                $sql .= 'DATE(o.date_added) ORDER BY DATE(o.date_added) DESC';
                break;
            case 'week':
                $sql .= 'DAYOFWEEK(o.date_added) ORDER BY DAYOFWEEK(o.date_added)';
                break;
            case 'month':
                $sql .= 'DATE_FORMAT(o.date_added,"%m-%Y") ORDER BY (o.date_added) DESC';
                break;
            default:
                $sql .= 'YEAR(o.date_added) ORDER BY YEAR(o.date_added) DESC';
        }

        return $sql;
    }

    public function getProductsDetails($data) {


        $sql = 'SELECT CONCAT_WS("|", p.product_id, p.price) AS pp, MIN(DISTINCT p.model) AS model, MIN(DISTINCT p.price) AS price, 
                       MIN(DISTINCT d.name) AS name, SUM(p.quantity) AS quantity, SUM(p.total) AS total, SUM(p.tax) AS tax, SUM(p.reward) AS reward
                            FROM `'.DB_PREFIX.'order_product` p 
                LEFT JOIN `'.DB_PREFIX.'order` o ON (p.order_id = o.order_id)
                LEFT JOIN `'.DB_PREFIX.'product_description` d ON (p.product_id = d.product_id)
                WHERE p.quantity>0 AND o.store_id IS NOT NULL
                    AND d.language_id = '.(int)$this->config->get('config_language_id').' 
                    AND o.store_id = '.(int)$this->config->get('config_store_id');


        # filter_order_status_id
        # filter zero
        if ( !empty($data['filter_order_status_id']) ) $data['filter_order_status_id'] = array_filter($data['filter_order_status_id']);
        $sql .= ' AND o.order_status_id'.( !empty($data['filter_order_status_id']) ? ' IN ('.implode(',',$data['filter_order_status_id']).')' : '> 0' );

        # special date format - came from opencart
        # filter_date_start
        if ( !empty($data['filter_ds']) ) $sql .= ' AND DATE(o.date_added) >= DATE(FROM_UNIXTIME('.intval($data['filter_ds']).'))';

        # filter_date_end
        if ( !empty($data['filter_de']) ) $sql .= ' AND DATE(o.date_added) <= DATE(FROM_UNIXTIME('.intval($data['filter_de']).'))';

        # filter_delivery_country_id
        if ( !empty($data['filter_shipping_country_id']) ) $sql .= ' AND o.shipping_country_id IN ('.implode(',',$data['filter_shipping_country_id']).')';

        # filter_payment_country_id
        if ( !empty($data['filter_payment_country_id']) ) $sql .= ' AND o.payment_country_id IN ('.implode(',',$data['filter_payment_country_id']).')';

        # filter_delivery_zone_id
        if ( !empty($data['filter_shipping_zone_id']) ) $sql .= ' AND o.shipping_zone_id IN ('.implode(',',$data['filter_shipping_zone_id']).')';

        # filter_payment_zone_id
        if ( !empty($data['filter_payment_zone_id']) ) $sql .= ' AND o.payment_zone_id IN ('.implode(',',$data['filter_payment_zone_id']).')';

        # filter_customer_group
        if ( !empty($data['filter_customer_group_id']) ) $sql .= ' AND o.customer_group_id IN ('.implode(',',$data['filter_customer_group_id']).')';

        # filter_product_id
        if ( !empty($data['filter_product_id']) ) $sql .= ' AND p.product_id IN ('.implode(',',$data['filter_product_id']).')';

        # filter_category_id
        if ( !empty($data['filter_category_id']) ) $sql .= ' AND p.product_id IN (SELECT product_id FROM `'.DB_PREFIX.'product_to_category` WHERE category_id IN ('.implode(',',$data['filter_category_id']).'))'; 

        # filter_total_min
        if ( !empty($data['filter_total_min']) ) $sql .= ' AND p.price >= '. floatval($data['filter_total_min']);

        # filter_total_max
        if ( !empty($data['filter_total_max']) ) $sql .= ' AND p.price <= '. floatval($data['filter_total_max']);

        # filter_total_reward
        if ( !empty($data['filter_reward_min']) ) $sql .= ' AND p.reward >= '. floatval($data['filter_reward_min']);

        # filter_total_reward
        if ( !empty($data['filter_reward_max']) ) $sql .= ' AND p.reward <= '. floatval($data['filter_reward_max']);

        $sql .= ' GROUP BY CONCAT_WS("|",p.product_id, p.price)';

        $query = $this->db->query($sql);

        return $query->rows;
    }
}
?>