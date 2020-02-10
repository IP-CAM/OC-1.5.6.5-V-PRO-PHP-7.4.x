<?php
class ModelCatalogSerial extends Model {
    /**
     * ModelCatalogSerial::tableCheck()
     * Creates the serial key tables if they don't exist
     * @return void
     */
    public function tableCheck() {

        // Create `serials` table
        $query = sprintf('
            CREATE TABLE IF NOT EXISTS `%sserials` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `key` varchar(128) NOT NULL,
            `pid` int(11) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin',
            DB_PREFIX
        );
        $this->db->query($query);

        // Create `serials_order` table
        $query = sprintf('
            CREATE TABLE IF NOT EXISTS `%sserials_order` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `key` varchar(128) NOT NULL,
            `oid` int(11) NOT NULL,
            `pid` int(11) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin',
            DB_PREFIX
        );
        $this->db->query($query);
    }

    /**
     * ModelCatalogSerial::getSerialList()
     * Gets a list of serial key product names and the number of keys it has
     * @return array
     */
    public function getSerialList() {
        $query = sprintf('
            SELECT
                `pd`.`product_id` as `id`,
                COUNT(`pd`.`name`) AS `count`,
                `pd`.`name`
            FROM
                `%1$sserials` `s`
            LEFT JOIN
                `%1$sproduct_description` `pd` ON `pd`.`product_id` = `s`.`pid`
            WHERE
            	pd.language_id = \'%2$s\'
            GROUP BY
                `s`.`pid`
            ORDER BY
                `count`
            ASC',
            DB_PREFIX,
            (int) $this->config->get('config_language_id')
        );
        $result = $this->db->query($query);
        return $result->rows;
    }

    public function getSerials($product_id) {
        $query = sprintf('
            SELECT
                `s`.*
            FROM
                `%1$sserials` `s`
            WHERE
                `s`.`pid` = %2$s
            ORDER BY
                `s`.`id`',
            DB_PREFIX,
            (int) $product_id
        );
        $result = $this->db->query($query);
        return $result->rows;
    }

    public function deleteSerials($keys) {
    	foreach($keys as $k => $key) {
    		$keys[$k] = (int) $key;
    	}
    	
        $keystr = implode(',', $keys);
        $query = sprintf('
            DELETE FROM
                `%1$sserials`
            WHERE
                `pid` IN (%2$s)
            ',
            DB_PREFIX,
            $keystr
        );
        $this->db->query($query);
    }

    public function deleteSerialsByID($keys) {
    	foreach($keys as $k => $key) {
    		$keys[$k] = (int) $key;
    	}
    	
        $keystr = implode(',', $keys);
        $query = sprintf('
            DELETE FROM
                `%1$sserials`
            WHERE
                `id` IN (%2$s)
            ',
            DB_PREFIX,
            $keystr
        );
        $this->db->query($query);
    }

    public function addSerials($serials, $product_id){
        $values = array();
        $product_id = (int) $product_id;
        
        foreach($serials as $s) {
        	$s = $this->db->escape($s);
            $values[] = "('$s', '$product_id')";
        }
        
        $vals = implode(',', $values);
        
        $query = sprintf('
        INSERT INTO
            `%1$sserials` (`key`, `pid`)
        VALUES
            %2$s
        ',
        DB_PREFIX,
        $vals);
        
        $this->db->query($query);

    }

    public function getSerialsByProduct($order_product_id) {
        $query = sprintf('
            SELECT
            	`so`.`id`,
                `so`.`key`
            FROM
                `%1$sserials_order` `so`
            WHERE
                `so`.`pid` = %2$s
            ORDER BY
                `so`.`id`',
            DB_PREFIX,
            (int) $order_product_id
        );
        $result = $this->db->query($query);
        if($result->num_rows) {
            $res = array();
            foreach($result->rows as $row) {
                $res[$row['id']] = $row['key'];
            }
            return $res;
        }
        return false;

    }
    
    public function restoreOrderSerials($order_id) {
    	$result = $this->db->query("SELECT `id` FROM `" . DB_PREFIX . "serials_order` WHERE `oid` = '" . (int) $order_id . "' ORDER BY `id` ASC");
    	if($result->num_rows) {
    		foreach($result->rows as $row) {
    			$this->removeOrderSerial($row['id'], $order_id);
    		}
    	}
    }
    
    public function restoreSerialKey($serial_id, $order_id) {
    	if($this->config->get('config_serial_restore_deleted') == 1) {
    		$sql = sprintf("
SELECT
	`so`.`key`,
	`op`.`product_id`
FROM
	`%1\$sserials_order` `so`
LEFT JOIN
	`%1\$sorder_product` `op`
ON
	`so`.`pid` = `op`.`order_product_id`
WHERE
	`so`.`id` = '%2\$s'
AND
	`so`.`oid` = '%3\$s'",
		DB_PREFIX,
		(int) $serial_id,
		(int) $order_id);
    		$result = $this->db->query($sql);
    		if($result->num_rows == 1) {
    			$this->addSerials(array($result->row['key']), $result->row['product_id']);
    			return true;
    		}
    	}
    	return false;
    }

    public function removeOrderSerial($serial_id, $order_id) {
    	$this->restoreSerialKey($serial_id, $order_id);
    	
        $query = sprintf('
            DELETE FROM
                `%1$sserials_order`
            WHERE
                `id` = %2$s
			AND
				`oid` = %3$s',
            DB_PREFIX,
            (int) $serial_id,
            (int) $order_id
        );

        $result = $this->db->query($query);

        return $this->db->countAffected() ? true : false;

    }

    public function addOrderSerial($serial, $order_id, $order_product_id) {
    	$query = sprintf('
			INSERT INTO
				`%1$sserials_order`
				(`key`, `oid`, `pid`)
			VALUES
				(\'%2$s\', %3$s, %4$s)',
			DB_PREFIX,
			$this->db->escape(trim($serial)),
			(int) $order_id,
			(int) $order_product_id
		);

		$result = $this->db->query($query);
		return (bool) $result;
    }

    public function updateOrderSerial($serial_id, $serial) {
        $query = sprintf('
            UPDATE
                `%1$sserials_order`
            SET
            	`key` = \'%3$s\'
            WHERE
                `id` = %2$s',
            DB_PREFIX,
            (int) $serial_id,
            $this->db->escape($serial)
        );

        $result = $this->db->query($query);

        return $this->db->countAffected() ? true : false;

    }

    public function updateSerial($serial_id, $serial) {
        $query = sprintf('
            UPDATE
                `%1$sserials`
            SET
            	`key` = \'%3$s\'
            WHERE
                `id` = %2$s',
            DB_PREFIX,
            (int) $serial_id,
            $this->db->escape($serial)
        );

        $result = $this->db->query($query);

        return $this->db->countAffected() ? true : false;

    }
    
    public function duplicateSerials($serials, $pid) {
    	$pid = (int) $pid;
    	if(!is_array($serials) || empty($serials) || $pid < 1) return false;
    	
    	$dupes = array();
    	
    	foreach($serials as $k => $serial) {
    		$serials[$k] = $this->db->escape($serial);
    	}
    	
    	$serials_list = strtolower(implode("','", $serials));
    	
    	$result = $this->db->query("SELECT `key` FROM `" . DB_PREFIX . "serials` WHERE LOWER(`key`) IN ('$serials_list') AND `pid` = '$pid'");
    	
    	if($result->num_rows) {
    		foreach($result->rows as $row) {
    			$dupes[] = $row['key'];
    		}
    	}
    	
    	$result = $this->db->query("SELECT `so`.`key` AS `key` FROM `" . DB_PREFIX . "serials_order` `so` LEFT JOIN `" . DB_PREFIX . "order_product` `op` ON `so`.`pid` = `op`.`order_product_id` WHERE LOWER(`key`) IN ('$serials_list') AND `op`.`product_id` = '$pid'");
    	
    	if($result->num_rows) {
    		foreach($result->rows as $row) {
    			$dupes[] = $row['key'];
    		}
    	}
    	
    	return empty($dupes) ? false : array_unique($dupes);
    }
    
    public function getOrderSerialsTotal() {
    	$result = $this->db->query("SELECT `op`.`product_id` AS `product_id`, COUNT(`op`.`product_id`) as `cnt` FROM `" . DB_PREFIX . "serials_order` `so` LEFT JOIN `" . DB_PREFIX . "order_product` `op` ON `so`.`pid` = `op`.`order_product_id` GROUP BY `op`.`product_id`");
    	
    	$results = array();
    	if($result->num_rows) {
    		foreach($result->rows as $row) {
    			$results[$row['product_id']] = $row['cnt'];
    		}
    	}
    	
    	return $results;
    }
    
    public function findOrderSerials($serial_key) {
    	$result = $this->db->query("SELECT `oid` FROM `" . DB_PREFIX . "serials_order` WHERE LOWER(`key`) LIKE '%" . strtolower($this->db->escape($serial_key)) . "%' ORDER BY `oid` DESC LIMIT 1");
    	
    	return $result->num_rows ? $result->row['oid'] : false;
    }
    
    public function getProducts() {
    	$result = $this->db->query("SELECT `product_id`, `name` FROM `" . DB_PREFIX . "product_description` WHERE `language_id` = '" . (int) $this->config->get('config_language_id') . "' ORDER BY `name`");
    	return $result->rows;
    }
}
?>