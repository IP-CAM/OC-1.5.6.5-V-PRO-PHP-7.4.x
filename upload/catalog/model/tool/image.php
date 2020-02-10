<?php
class ModelToolImage extends Model {
	/**
	*	@param filename string
	*	@param width 
	*	@param height
	*	@param type char [default, w, h]
	*				default = scale with white space, 
	*				w = fill according to width, 
	*				h = fill according to height
	*/
public function resize($filename, $width, $height, $type = "") {
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		
		$extension = $info['extension'];
		
		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type .'.' . $extension;
		
		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {

// JTI MOD Image resizer - Stop Resize Small Images
    		list($original_width, $original_height, $original_type, $original_attr)= getimagesize(DIR_IMAGE . $old_image);
    		if ($original_width < $width && $original_height < $height) {
    		     $width = $original_width;
    		     $height = $original_height;
    		}
// END JTI MOD

				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height, $type);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}

// JTI MOD fix bug when attach image on email (gmail.com). it is automatic changing space " " to +
			$new_image = str_replace(' ', '%20', $new_image);
// END JTI MOD 
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
	//	return $this->config->get('config_ssl') . 'image/' . $new_image;
			return HTTPS_IMAGE . $new_image . '" width="' . $width . '" height="' . $height;
		} else {
	//	return $this->config->get('config_url') . 'image/' . $new_image;
			return HTTP_IMAGE . $new_image . '" width="' . $width . '" height="' . $height;
		}	
	}
}
?>