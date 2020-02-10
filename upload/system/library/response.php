<?php
class Response {
	private $headers = array();
	private $level = 0;
	private $output;

	public function addHeader($header) {
		$this->headers[] = $header;
	}

	public function redirect($url, $status = 302) {
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
		exit();
	}

	public function setCompression($level) {
		$this->level = $level;
	}

	public function setOutput($output) {
		$this->output = $output;
	}

	public function getOutput() {
		return $this->output;
	}

	private function compress($data, $level = 0) {
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding) || ($level < -1 || $level > 9)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}

   public function output() {
        /*source compressor*/
        if ($this->output) {
            //$this->output = preg_replace('/<!--(.|\n)*?-->/', " ", $this->output);
            $this->output = preg_replace("/\n+/", "\n", $this->output);
            $this->output = preg_replace("/\r\n+/", "\n", $this->output);
            $this->output = preg_replace("/\n\t+/", "\n", $this->output);
            $this->output = preg_replace("/\n\ +/", "\n", $this->output);
            $this->output = preg_replace("/\>\n</", '><', $this->output);
            $this->output = preg_replace("/\>\r\n</", '><', $this->output);
        }
		
		if ($this->output) {
			
			if ($this->level) {
				$output = $this->compress(minify($this->output,1), $this->level);
			} else {
				$output = minify($this->output,1);
			}

			if (!headers_sent()) {
				foreach ($this->headers as $header) {
					header($header, true);
				}
			}

	echo $output;
	}
	}

}

define('SAFE', 1);
define('EXTREME', 2);
define('EXTREME_SAVE_COMMENTS', 4);
define('EXTREME_SAVE_PRE', 3);

function minify($html, $level=2)
{
	switch((int)$level)
	{
		case 0:
			//Don't minify
		break;
		
		case 1: //Safe Minify
		
			// Replace all whitespace characters between tags with a single space
			$html = preg_replace("`>\s+<`", "> <", $html);
		break;
		
		case 2: //Extreme Minify
			
			// Placeholder to save conditional comment hack, <pre> and <code> tags
			$place_holders = array(
				'<!-->' => '_!--_',
			);
			
			//Set placeholders
			$html = strtr($html, $place_holders);
			
			// Remove all normal comments - save conditionals
			$html = preg_replace('/<!--[^(\[|(<!))](.*)-->/Uis', '', $html);
			
			// Replace all whitespace characters with a single space
			$html = preg_replace("`\s+`", " ", $html);
			
			// Remove the spaces between adjacent html tags
			$html = preg_replace("`> <`", "><", $html);
			
			// Replace space between adjacent a tags for readability
			$html = str_replace("</a><a", "</a> <a", $html);
			
			// Restore placeholders
			$html = strtr($html, array_flip($place_holders));
		break;
		
		case 3: //Extreme, save pre and code tags
			// Placeholder to save conditional comment hack, <pre> and <code> tags
			$place_holders = array(
				'<!-->' => '_!--_',
				'<pre>' => '_pre_',
				'</pre>' => '_/pre_',
				'<code>' => '_code_',
				'</code>' => '_/code_'
			);
			
			//Set placeholders
			$html = strtr($html, $place_holders);
			
			// Remove all normal comments - save conditionals
			$html = preg_replace('/<!--[^(\[|(<!))](.*)-->/Uis', '', $html);
			
			// Replace all whitespace characters with a single space
			$html = preg_replace(">`\s+`<", "> <", $html);
			
			// Remove the spaces between adjacent html tags
			$html = preg_replace("`> <`", "><", $html);
			
			// Replace space between adjacent a tags for readability
			$html = str_replace("</a><a", "</a> <a", $html);
			
			// Restore placeholders
			$html = strtr($html, array_flip($place_holders));
		
		break;
		
		case 4: //Extreme minify, save comments
			
			// Replace all whitespace characters with a single space
			$html = preg_replace("`\s+`", " ", $html);
			
			// Remove spaces between adjacent html tags
			$html = preg_replace("`> <`", "><", $html);
			
			// Restore space between ajacent a tags
			$html = str_replace("</a><a", "</a> <a", $html);
		break;
	}

	//Normalize ampersands
	//$html = str_replace("&amp;", "&", $html);
	//$html = str_replace("&", "&amp;", $html);
	
	//Replace common entities with more compatible versions
	$replace = array(
		'&nbsp;' => '&#160;',
		'&copy;' => '&#169;',
		'&acirc;' => '&#226;',
		'&cent;' => '&#162;',
		'&raquo;' => '&#187;',
		'&laquo;' => '&#171;'
	);
	
	//$html = strtr($html, $replace);
	
	//Return minified html
	return $html;
}		