<?php
class ControllerCommonImageEditor extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('common/imageeditor');
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}
		$this->data['token'] = $this->session->data['token'];
		$this->data['filename_error'] = $this->language->get('error_filename');
		$this->data['select_size_error'] = $this->language->get('error_select_size');
		
		$this->data['scale_image'] = $this->language->get('text_scale_image');
		$this->data['crop_image'] = $this->language->get('text_crop_image');
		$this->data['rotate_counter'] = $this->language->get('text_rotate_counter');
		$this->data['rotate_clockwise'] = $this->language->get('text_rotate_clockwise');
		$this->data['flip_vertically'] = $this->language->get('text_flip_vertically');
		$this->data['flip_horizontally'] = $this->language->get('text_flip_horizontally');
		$this->data['undo'] = $this->language->get('text_undo');
		$this->data['redo'] = $this->language->get('text_redo');
		$this->data['scale_description'] = $this->language->get('text_scale_description');
		
		if (!file_exists(DIR_IMAGE . 'editor')) {
			@mkdir(DIR_IMAGE . 'editor', 0777);
		}
		if (!is_writable(DIR_IMAGE . 'editor')) {
			$this->data['error'] = 'Warning: Image editor directory needs to be writable for OpenCart to work!';
		}else{
			if (isset($this->request->get['name']) && $this->request->get['name']){
				$imageinfo = $this->getimageinfo($this->request->get['name'],'data');
				if (!file_exists($imageinfo['ap'])) {
					$this->data['error'] = $this->language->get('error_missing');
				}else{
					//copy to editor folder
					if (!file_exists(DIR_IMAGE . 'editor/' . $imageinfo['basename'])){
						copy($imageinfo['ap'], DIR_IMAGE . 'editor/' . $imageinfo['basename']);
					}
				}
				$this->data['originalimage'] = $this->request->get['name'];
				$this->data['imagename'] = $imageinfo['basename'];
				$this->data['targetimage'] = $imageinfo['rp'];
				$this->data['truewidth'] = $imageinfo['tw'];
				$this->data['trueheight'] = $imageinfo['th'];
				$this->data['fixwidth'] = $imageinfo['fw'];
				$this->data['fixheight'] = $imageinfo['fh'];
			}else{
				$this->data['error'] = $this->language->get('error_missing');
			}
		}
		
		$this->template = 'common/imageeditor.tpl';
		$this->response->setOutput($this->render());
	}
	
	
	private function getimageinfo($image, $root='editor'){
		$info = array();
		//relative path
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$info['rp'] = rtrim(HTTPS_CATALOG . 'image/' . $root . '/' . str_replace('../', '', $image), '/');
		} else {
			$info['rp'] = rtrim(HTTP_CATALOG . 'image/' . $root . '/' . str_replace('../', '', $image), '/');
		}
		//absolute path
		$info['ap'] = rtrim(DIR_IMAGE . $root . '/' . str_replace('../', '', $image), '/');
		$size = getimagesize($info['ap']);
		//true width
		$info['tw'] = $size[0];
		//true height
		$info['th'] = $size[1];
		//fixed width
		//fixed height
		if ($size[0]/$size[1] > 470/340){
			$info['fw'] = 470;
			$info['fh'] = round(470 * $size[1] / $size[0]);
		}else{
			$info['fw'] = round(340 * $size[0] / $size[1]);
			$info['fh'] = 340;
		}
		$path = pathinfo($image);
		//basename ex: ttt.jpg
		$info['basename'] = $path['basename'];
		//only name ex: ttt
		$info['onlyname'] = utf8_substr($path['basename'], 0, strrpos($path['basename'], '.'));
		//extension ex: jpg
		$info['extension'] = $path['extension'];
		//dirname 
		$info['dirname'] = $path['dirname'];
		return $info;
	}
	
	public function scaleimage(){
		$this->load->language('common/imageeditor');
		$json = array();
		$w = (isset($this->request->post['width']) && $this->request->post['width']) ? (int)$this->request->post['width'] : 0;
		$h = (isset($this->request->post['height']) && $this->request->post['height']) ? (int)$this->request->post['height'] : 0;
		$imagefile = (isset($this->request->post['image']) && $this->request->post['image']) ? $this->request->post['image'] : '';
		if ($w == 0 || $h == 0 || $imagefile == ''){
			$json['error'] = $this->language->get('error_select_size');
		}else{
			$imageinfo = $this->getimageinfo($imagefile);
			if (!file_exists($imageinfo['ap'])) {
				$json['error'] = $this->language->get('error_missing');
			}else{
				$newname = rand(1,1000) . rand(1000,9999) . '.' . $imageinfo['extension'];
				$image = new Image($imageinfo['ap']);
				$image->resize($w, $h);
				$image->save(DIR_IMAGE . 'editor/' . $newname,100);
				
				$imageinfo = $this->getimageinfo($newname);
				$json['width'] = $imageinfo['tw'];
				$json['height'] = $imageinfo['th'];
				$json['src'] = $imageinfo['rp'];
				$json['fixwidth'] = $imageinfo['fw'];
				$json['fixheight'] = $imageinfo['fh'];
				$json['newname'] = $newname;
				$json['undo'] = false;
				$json['redo'] = false;
			}
		}
		$this->response->setOutput(json_encode($json));	
	}
	
	public function cropimage(){
		$this->load->language('common/imageeditor');
		$json = array();
		$x1 = (isset($this->request->post['x1']) && $this->request->post['x1']) ? (int)$this->request->post['x1'] : 0;
		$y1 = (isset($this->request->post['y1']) && $this->request->post['y1']) ? (int)$this->request->post['y1'] : 0;
		$x2 = (isset($this->request->post['x2']) && $this->request->post['x2']) ? (int)$this->request->post['x2'] : 0;
		$y2 = (isset($this->request->post['y2']) && $this->request->post['y2']) ? (int)$this->request->post['y2'] : 0;
		$imagefile = (isset($this->request->post['image']) && $this->request->post['image']) ? $this->request->post['image'] : '';
		
		if ($x1 == $x2 || $y1 == $y2){
			$json['error'] = $this->language->get('error_select_size');
		}else{
			$imageinfo = $this->getimageinfo($imagefile);
			if (!file_exists($imageinfo['ap'])) {
				$json['error'] = $this->language->get('error_missing');
			}else{
				$newname = rand(1,1000) . rand(1000,9999) . '.' . $imageinfo['extension'];
				$image = new Image($imageinfo['ap']);
				$image->crop($x1, $y1, $x2, $y2);
				$image->save(DIR_IMAGE . 'editor/' . $newname,100);
				
				$imageinfo = $this->getimageinfo($newname);
				$json['width'] = $imageinfo['tw'];
				$json['height'] = $imageinfo['th'];
				$json['src'] = $imageinfo['rp'];
				$json['fixwidth'] = $imageinfo['fw'];
				$json['fixheight'] = $imageinfo['fh'];
				$json['newname'] = $newname;
				$json['undo'] = false;
				$json['redo'] = false;
			}
		}
		$this->response->setOutput(json_encode($json));	
	}
	
	public function rotateimage(){
		$this->load->language('common/imageeditor');
		$json = array();
		$d = (isset($this->request->post['d']) && $this->request->post['d']) ? (int)$this->request->post['d'] : 0;
		$imagefile = (isset($this->request->post['image']) && $this->request->post['image']) ? $this->request->post['image'] : '';
		if (($d % 360) == 0)
			$json['error'] = $this->language->get('error_degree');
		else{
			$imageinfo = $this->getimageinfo($imagefile);
			if (!file_exists($imageinfo['ap'])) {
				$json['error'] = $this->language->get('error_missing');
			}else{
				$newname = rand(1,1000) . rand(1000,9999) . '.' . $imageinfo['extension'];
				$image = new Image($imageinfo['ap']);
				$image->rotate($d);
				$image->save(DIR_IMAGE . 'editor/' . $newname,100);
				
				$imageinfo = $this->getimageinfo($newname);
				$json['width'] = $imageinfo['tw'];
				$json['height'] = $imageinfo['th'];
				$json['src'] = $imageinfo['rp'];
				$json['fixwidth'] = $imageinfo['fw'];
				$json['fixheight'] = $imageinfo['fh'];
				$json['newname'] = $newname;
				$json['undo'] = false;
				$json['redo'] = false;
			}
		}
		$this->response->setOutput(json_encode($json));	
	}
	
	
	public function flipimage(){
		$this->load->language('common/imageeditor');
		$json = array();
		$f = (isset($this->request->post['f']) && $this->request->post['f']) ? (int)$this->request->post['f'] : 1;
		$imagefile = (isset($this->request->post['image']) && $this->request->post['image']) ? $this->request->post['image'] : '';
		$imageinfo = $this->getimageinfo($imagefile);
		if (!file_exists($imageinfo['ap'])) {
			$json['error'] = $this->language->get('error_missing');
		}else{
			$newname = rand(1,1000) . rand(1000,9999) . '.' . $imageinfo['extension'];
			$image = new Image($imageinfo['ap']);
			$image->flip($f);
			$image->save(DIR_IMAGE . 'editor/' . $newname,100);
			
			$imageinfo = $this->getimageinfo($newname);
			$json['width'] = $imageinfo['tw'];
			$json['height'] = $imageinfo['th'];
			$json['src'] = $imageinfo['rp'];
			$json['fixwidth'] = $imageinfo['fw'];
			$json['fixheight'] = $imageinfo['fh'];
			$json['newname'] = $newname;
			$json['undo'] = false;
			$json['redo'] = false;
		}
		
		$this->response->setOutput(json_encode($json));	
	}
	
	public function redoundo(){
		$this->load->language('common/imageeditor');
		$json = array();
		$d = (isset($this->request->post['d']) && $this->request->post['d']) ? $this->request->post['d'] : 'u';
		$imagefile = (isset($this->request->post['image']) && $this->request->post['image']) ? $this->request->post['image'] : '';
		$imageinfo = $this->getimageinfo($imagefile);
		if (!file_exists($imageinfo['ap'])) {
			$json['error'] = $this->language->get('error_missing');
		}else{
			$json['width'] = $imageinfo['tw'];
			$json['height'] = $imageinfo['th'];
			$json['src'] = $imageinfo['rp'];
			$json['fixwidth'] = $imageinfo['fw'];
			$json['fixheight'] = $imageinfo['fh'];
			$json['newname'] = $imagefile;
			$json['undo'] = $d == 'u' ? true : false;
			$json['redo'] = $d == 'r' ? true : false;
		}
		$this->response->setOutput(json_encode($json));	
	}
	
	public function saveimage(){
		$this->load->language('common/imageeditor');
		$json = array();
		$imagefile = (isset($this->request->post['image']) && $this->request->post['image']) ? $this->request->post['image'] : '';
		$originalimage = (isset($this->request->post['oi']) && $this->request->post['oi']) ? $this->request->post['oi'] : '';
		$imageinfo = $this->getimageinfo($imagefile);
		if (!file_exists($imageinfo['ap'])) {
			$json['error'] = $this->language->get('error_missing');
		}else{
			$originalinfo = $this->getimageinfo($originalimage, 'data');
			$newfile = DIR_IMAGE . 'data/' . $originalinfo['dirname'] .'/'. $originalinfo['onlyname'] .'-'. rand(1,1000) . '.' . $originalinfo['extension'];
			copy($imageinfo['ap'], $newfile);
			$this->clean();
		}
		$this->response->setOutput(json_encode($json));	
	}
	
	private function clean(){
		$files = glob(rtrim(DIR_IMAGE . 'editor/', '/') . '/*');
		
		if ($files) {
			foreach ($files as $file) {
				if (is_file($file)) {
					if(time() - filectime($file)>3600*24*0){
						@chmod($file, 0777);
						@unlink($file);
					}
				}
			}
		}
	}
}
?>