<?php
class ModelModuleMassimgrename extends Model {
    public $limit = 200;
    public function getmodifiedproducts($data) {
        $lastrun = $data['lastrun'];
        $sql = "SELECT *  FROM " . DB_PREFIX . "product WHERE `date_modified` > '$lastrun'";


        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = $this->limit;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getproduct($data) {
        $query = $this->db->query("
	SELECT * 
	FROM `product`
	WHERE `product_id` = '$data'
	");
        return $query->rows;
    }

    public function getmodifiedproductimages($data) {
        $query = $this->db->query("
	SELECT *
	FROM product_image

	");
        return $query->rows;
    }

    public function update_image($data) {
        $image = $data['image'];
        $newimage = $data['new_image'];
        $sql = "
	UPDATE " . DB_PREFIX . "product_image SET image = '$newimage' WHERE image = '$image' ;
	";
        //   var_dump($sql);
        $query = $this->db->query($sql);
        ////krumo($data);
        // $this->cache->delete('product');
       // echo "all images in the images table named $image have been renamed to $newimage <br>";
    }

    public function getTotalmodifiedproductimages() {
        $sql = " SELECT distinct COUNT(image) AS total FROM " . DB_PREFIX . "product_image";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getTotalproductimages($data = null) {
        $lastrun = $data['lastrun'];
        $sql = " SELECT distinct COUNT(pi.image) AS total FROM " . DB_PREFIX . "product_image as pi";
        if (isset($lastrun) && $lastrun != "0000-00-00 00:00:00")
            $sql .=" LEFT JOIN `" . DB_PREFIX . "product` as `p` 
            ON `pi`.`product_id` = `p`.`product_id` 
             where 'p.date_modified' > '$lastrun'";
        //  var_dump($sql);
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getTotalthumbs() {
        $sql = " SELECT distinct COUNT(image) AS total FROM " . DB_PREFIX . "product_image";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
public function normalizeString ($str = '')
{
    $str = strip_tags($str); 
    $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
    $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
    $str = strtolower($str);
    $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
    $str = htmlentities($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
    $str = str_replace(' ', '-', $str);
    $str = rawurlencode($str);
    $str = str_replace('%', '-', $str);
    return $str;
}
    public function slugify($data) {
//remove with regex to make safe
        $unsafe=array();
        $unsafe[]='%';
        $slugified=  $this->normalizeString($data);
        $size=count($slugified);
        if($size > 255){
         $slugified=$this->chomp($slugified,250);
          }
        return $slugified;
    }
    public function chomp($data,$size) {
        //break extension off
        $data_array = explode('/', $data);
        $end = count($product_image_array) - 1;
        $extension = strchr($product_image_array[$end], '.');
        //pop off array
        $path_array =  array_pop($data_array);
        $path =  implode('/', $path_array);
        //count size of remaining data w/o extension
        $pathsize =  count($path);
        $specialchar= stristr($path, '-');
 while($pathsize > $size){
     if(isset($specialchar)){
       $path=  strchr($path, $specialchar, 1);
       $pathsize = count($path);
     }else{
         $path= (strlen($path) > $size) ? substr($string,0,$size) : $string; 
         $pathsize =  count($path);
     }
 }
$path=$path. $extension;

        return $path;
    }
    public function delete($product) {
        //check to see that no other product uses old  image
        $inuse = $this->products_with_image($product);
//        echo '<br>';
//        echo 'do any other products use ' . $product['image'] . " :";
//        echo '<br>';
        // var_dump($inuse);
//        if (count($inuse) > 0) {
//            echo "yes";
//            echo '<br>';
//        }
        $test = $this->images_with_image($product);
//        echo 'do any other images use  ' . $product['image'] . " :";
//        echo '<br>';
        if (count($test) > 0) {
            $inuse = true;
//            echo "yes";
//            echo '<br>';
        }
        //check to see that no other image uses old  image
        //  $test=$query=$this->model_module_massimgrename->ebay_with_image($product);
        //check to see that no other ebay/openbay uses old  image

//        echo 'do any other ebay use ' . $product['image'] . " :";
//        echo '<br>';
        if (count($test) > 0) {
            $inuse = true;
//            echo "yes";
//            echo '<br>';
        }


        //remove old image ?
        if ($inuse == false)
            $this->deleteimage($product['image']);
    }

    public function deleteimage($filename) {
    //    echo 'removing image :' . DIR_IMAGE . $filename;
        $success = unlink(DIR_IMAGE . $filename);
    }

    public function update_product_image($data) {
        $image = $data['image'];
        $newimage = $data['new_image'];
        //echo 'updating product model in progress';

        $sql = "
	UPDATE " . DB_PREFIX . "product SET image = '$newimage' WHERE image = '$image' ;
	";
        //  var_dump($sql);
        $query = $this->db->query($sql);
       // echo "Now all products in db whose image name is $image has been renamed to $newimage <br>";
        $this->cache->delete('product');
    }

    public function getimages($data) {
        $sql = "SELECT DISTINCT image FROM " . DB_PREFIX . "product_image";


        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = $this->limit;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }
        //var_dump($sql);
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getproductimages($data) {

        $sql = "SELECT DISTINCT image FROM " . DB_PREFIX . "product";


        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = $this->limit;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function randomfilename($data) {
        $product_image_array = explode('/', $data);
        //replace last element with random name
        $end = count($product_image_array) - 1;
        $extension = strchr($product_image_array[$end], '.');
        $product_image_array[$end] = time() * rand(1, 999999999) . $extension;
        $filename = implode('/', $product_image_array);
        //  var_dump($filename);
        return $filename;
    }

    public function makefilename($mode = sku, $data) {

        $filename = $data[$mode];
        $product_image_array = explode('/', $data['image']);
        //replace last element with random name
        $end = count($product_image_array) - 1;
        $extension = strchr($product_image_array[$end], '.');
        $oldfilename = $product_image_array[$end];
        if (strlen($filename) < 4) {
           //$oldfilename = $this->normalizeString($oldfilename);
            $product_image_array[$end] = $oldfilename;
        } else {
            $filename = $this->normalizeString($filename);
            $product_image_array[$end] = $filename . $extension;
        }
        $filename = implode('/', $product_image_array);
        //  var_dump($filename);
        return $filename;
    }

    public function update_openbay_image_links($data) {
        $image = $data['image'];
        $sql = "UPDATE " . DB_PREFIX . "ebay_image_import SET image_original = '" . $this->db->escape(html_entity_decode($data['new_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE image_original = '" . $data['image'] . "'";
        $this->db->query($sql);
       // echo "updated image id $image_id to $image";
    }

    public function update_thumb_image($data) {
        $image_id = $data['product_image_id'];
        $image = $data['image'];
        $sql = "UPDATE " . DB_PREFIX . "product_image SET image = '" . $this->db->escape(html_entity_decode($data['new_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_image_id = '" . (int) $image_id . "'";

        $this->db->query($sql);
       // echo "updated image id $image_id to $image";
        // $this->cache->delete('product');
    }

    public function update_product_image_by_product_id($data) {
        $image = $data['image'];
        $id = $data['product_id'];
        $newimage = $data['new_image'];
        //echo 'updating product model in progress';

        $sql = "
	UPDATE " . DB_PREFIX . "product SET image = '$newimage' WHERE image = '$image' AND product_id =  '$id' ;
	";
        //  var_dump($sql);
        $query = $this->db->query($sql);
        // $this->cache->delete('product');
        return $newimage;
    }

    public function products_with_image($image) {
        $img = $image['image'];
        $sql = "
                SELECT *
                FROM " . DB_PREFIX . "product
                WHERE image LIKE '$img'
                ";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function images_with_image($image) {
        $img = $image['image'];
        $sql = "
                SELECT *
                FROM " . DB_PREFIX . "product_image
                WHERE image LIKE '$img'
                ";
        // var_dump($sql);
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function openebay_with_image($image) {
        $img = $image['image'];
        $sql = "
                SELECT *
                FROM " . DB_PREFIX . "ebay_image_import
                WHERE image_new LIKE '$img'
                ";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function copytofolder($data) {
        $src = DIR_IMAGE . $data['image'];
        $dest = DIR_IMAGE . 'old_images/'.$data['image'];
echo 'copying from ' . $src . ' to ' . $dest . '<br>';
        $success = false;
        $success = copy($src, $dest);
        if ($success != false)
          // echo 'copying from ' . $src . ' to ' . $dest . '<br>';
        return $success;
    }

    public function copyimage($data) {
        $src = DIR_IMAGE . $data['image'];
        $dest = DIR_IMAGE . $data['new_image'];

        $success = false;
        $success = copy($src, $dest);
        if ($success != false)
           // echo 'copying from ' . $src . ' to ' . $dest . '<br>';
        return $success;
    }

    public function processproductimage($mode = 'sku', $data) {

        $product_mode_data = $data[$mode];
        $product_mode_data = $this->normalizeString($product_mode_data);

        $currentimage['image'] = $data['image'];
        $currentimage['pathtofile'] = DIR_IMAGE . $data['image'];

        $product_image_array = explode('/', $currentimage['image']);

        $end = count($product_image_array) - 1;
        $extension = strchr($product_image_array[$end], '.');
        $tempimage = $product_mode_data . $extension;

        $new_image_array = explode('/', $currentimage['image']);
        array_pop($new_image_array);
        $new_image_array[] = $tempimage;
        $newimage['image'] = implode('/', $new_image_array);
        $newimage['pathtofile'] = DIR_IMAGE . $newimage['image'];

        $newimage_exists = $this->file_exist($newimage);
        $currentimage_exists = $this->file_exist($currentimage);

        if ($currentimage_exists == true) {
            $currentfilesize = filesize($currentimage['pathtofile']);

            if ($newimage_exists) {

                $newimagefilesize = filesize($newimage['pathtofile']);
;

                if ($currentfilesize == $newimagefilesize) {
                    $newimage_exists = false;
                    array_pop($product_image_array);
                    $product_image_array[] = $tempimage;
                }
            } else {
                $product_image_array = explode('/', $newimage['image']);

            }

            $x = 1;
            while ($newimage_exists == true) {

                array_pop($product_image_array);
                $product_image_array[] = $product_mode_data . '_' . $x  . $extension;


                $newimage['image'] = implode('/', $product_image_array);

                $newimage_exists = $this->file_exist($newimage);

                if (isset($newimage_exists)) {
                    $newimagefilesize = filesize($newimage['pathtofile']);

                    
                    if ($currentfilesize == $newimagefilesize) {

                        $newimage_exists = false;
                        array_pop($product_image_array);
                        $product_image_array[] = $tempimage;
                        //echo 'files are same size';
                    }
                }

                $x++;
            }

            $data['image'] = $currentimage['image'];
            $data['new_image'] = implode('/', $product_image_array);
            ////krumo($data['image']);
        } else {
            $data['image'] = $currentimage['image'];
            $data['new_image'] = null;
        }
        //  var_dump($data);
        return $data;
    }

    public function file_exist($data, $key = null) {
        //get image fs location 
        //echo 'data[image] is ';
        ////krumo($data['image']);
        $image = $data['image'];
        if (isset($key)) {
            $image = $data[$key];
        }
        $product_image_fs = DIR_IMAGE . $image;

        if (file_exists($product_image_fs)) {
            $file_exists = true;
            //echo $product_image_fs. ' Exists <br>';
        } else {
            //echo $product_image_fs. ' Does not Exist <br>';
            $file_exists = null;
        }
        return $file_exists;
    }
}
?>