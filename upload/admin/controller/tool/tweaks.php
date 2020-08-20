<?php

// *** TWEAKS are built on base of VQMod Manager [by Ryan (rph)] and inherit Creative Commons License:
// *** http://creativecommons.org/licenses/by-nc-sa/3.0/us/legalcode

class ControllerToolTweaks extends Controller {
	private $error = array();

	public function index() {
        $target = false;
        if (!empty($this->request->get['target'])) $target = $this->request->get['target'];
        $this->data['hidden'] = (isset($this->request->get['hidden']) or isset($this->request->post['hidden']));
        if ($target) $this->data['hidden'] = true;

        $this->data['hidden_link']=$this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL');
        if (!$this->data['hidden']) $this->data['hidden_link'].="&hidden=1";
        $this->data['troubleshoot'] = isset($this->request->get['troubleshoot']);
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_editor'] = $this->language->get('button_editor');
		$this->data['text_button_refresh'] = $this->language->get('text_button_refresh');
        if ($target) $this->data['troubleshoot'] = true;
        $this->data['troubleshoot_link']=$this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL')."&troubleshoot=1";
        if ($this->data['hidden']) $this->data['troubleshoot_link'].="&hidden=1";
        if ($this->data['troubleshoot']) $this->data['hidden_link'].="&troubleshoot=1";

        $this->data['advanced'] = strpos(file_get_contents('../vqmod/vqmod.php'),'openshop');
		$this->load->language('tool/tweaks');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['text_clear_vqcache'] = $this->language->get('text_clear_vqcache');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

			// Upload VQMod
			if (isset($this->request->post['upload'])) {
				$this->vqmod_upload();

			// Settings
			} else {
				$this->model_setting_setting->editSetting('tweaks', $this->request->post);

				$this->session->data['success'] = $this->language->get('text_success');

				$this->redirect($this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		// Language
		$this->data = array_merge($this->data, $this->load->language('tool/tweaks'));

		// Warning
		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error_warning'] = '';
		}

		// Success
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		// Breadcrumbs
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		// Action Buttons
		$this->data['action'] = $this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['editor'] = $this->url->link('tool/editor', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['button_refresh'] = $this->url->link('tool/tweaks/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

		// Clear Cache / Logs
		$this->data['clear_log'] = $this->url->link('tool/tweaks/clear_log', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clear_vqcache'] = $this->url->link('tool/tweaks/clear_cache', 'token=' . $this->session->data['token'], 'SSL');

		// Backup VQMods
		$this->data['backup'] = $this->url->link('tool/tweaks/vqmod_backup', 'token=' . $this->session->data['token'], 'SSL');
		
		// OcMod Refresh
		$this->data['refresh'] = $this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL');

        // Attempts to autodetect VQMod path
            $this->data['vqmod_path'] = substr_replace(DIR_SYSTEM, '', -7) . 'vqmod/';
            $this->data['path_set'] = TRUE;

        $this->data['openshop_enabled'] = !file_exists($this->data['vqmod_path'].'xml/openshop/openshop_disabled');
        if (!$this->data['advanced']) $this->data['openshop_enabled'] = false;

		// Detect mods
		$vqmods = glob($this->data['vqmod_path'] . 'xml/*.xml*');

        if ($this->data['openshop_enabled'])
            $vqmods = array_merge(glob($this->data['vqmod_path'] . 'xml/openshop/*.xml*'),$vqmods);

        $this->data['disabled']=array();
        $hidden_add = '';
        if ($this->data['hidden']) $hidden_add = '&hidden=1';
        if ($this->data['troubleshoot']) $hidden_add .= '&troubleshoot=1';

        // VQMod Error Log
        //$log_file = $this->data['vqmod_path'] . 'logs/'. date('D') . '.log';
        $logfiles = glob($this->data['vqmod_path'] . 'logs/*.log');
        if ($logfiles) {
            $logfiles = array_combine($logfiles, array_map("filemtime", $logfiles));
            arsort($logfiles);
            $log_file = key($logfiles);
        } else $log_file = '';

        if (file_exists($log_file) && filesize($log_file) > 0) {

            // Error if log file is larger than 6MB
            if (filesize($log_file) > 6291456) {
                $this->data['error_warning'] = sprintf($this->language->get('error_log_size'), (round((filesize($log_file) / 1048576), 2)));
                $this->data['log'] = sprintf($this->language->get('error_log_size'), (round((filesize($log_file) / 1048576), 2)));

                // Regular log
            } else {
                $this->data['log'] = file_get_contents($log_file, FILE_USE_INCLUDE_PATH, NULL);
            }

            // No log / empty log
        } else {
            $this->data['log'] = '';
        }

	if (!empty($vqmods)) {

	        // Preprocess to find used files and other data

            $vinfo = array(); // Stalked info
            $nhidden = 0;
            foreach ($vqmods as $i => $vqmodd) {
                $info = array();
                if (strpos($vqmodd, '.xml_')) {
                    $file = basename($vqmodd, '.xml_');
                } else {
                    $file = basename($vqmodd, '.xml');
                }

                $info['file'] = $file;
                $info['enabled'] = !strpos($vqmodd, '.xml_');

                $info['hidden'] = (($file[0]=='_') or ($file[0]=='-') or ($file[0]=='z') or ($file=='vqmod_opencart'));
                if ($info['hidden']) $nhidden++;
                $info['openshop'] = (strpos($vqmodd, "OpenShop/")!==false);

                $xml = simplexml_load_file($vqmodd);

                // Get list of modified files
                if ($this->data['troubleshoot']) {
                    $tfiles = array();
                    foreach ($xml->children() as $node)
                        if ($node->GetName()=='file') {
                            $files = @$node['name'];
                            $files = explode(',',$files);
                            foreach ($files as $xfile)
                                if ($add=glob(trim('../'.$xfile)))
                                $tfiles = array_merge($tfiles,$add);
                        }
                    foreach ($tfiles as &$tfile) {
                        $tfile = str_replace('../','',$tfile);
                        if ($tfile[0] == '/') $tfile = substr($tfile,1);
                    }
                    if (!$tfiles) $tfiles = array();
                    $tfiles = array_unique($tfiles);
                    sort($tfiles);
                    $info['files'] = $tfiles;
                }

                $info['version'] = isset($xml->version) ? $xml->version : $this->language->get('text_unavailable');
				$info['vqmver'] = isset($xml->vqmver) ? $xml->vqmver : $this->language->get('text_unavailable');
				$info['author'] = isset($xml->author) ? $xml->author : $this->language->get('text_unavailable');

                $pinfo = pathinfo($vqmodd);

                // vQMods localize
                $name=basename($file,'.'.$pinfo['extension']);
                $title=basename($file,'.'.$pinfo['extension']);
                $title=str_replace('-',' ',$title);
                $title=str_replace('_',' ',$title);
                if ($title[0]=='z') $title = substr($title,1);
                $desc=isset($xml->id) ? $xml->id : $this->language->get('text_unavailable');
                global $os;
                if (isset($os['tweak_'.$name])) $title=$os['tweak_'.$name];
                if (isset($os['desc_'.$name])) $desc=$os['desc_'.$name];
                $info['title'] = $title;
                $info['desc'] = $desc;

                $vinfo[$i] = $info;
            }

            $this->data['nhidden'] = $nhidden;

			foreach ($vqmods as $i => $vqmodd) {
                $info = $vinfo[$i];
				$file = $info['file'];

                if (!$this->data['hidden'] and $info['hidden']) continue;
                if ($target) {
                    $skip = true;
                    foreach ($info['files'] as $f)
                        if (strpos($f,$target)!==false) $skip = false;
                    if ($skip) continue;
                }

				$action = array();

				if (strpos($vqmodd, '.xml_')) {
					$action[] = array(
						'text' => $this->language->get('text_install'),
						'href' => $this->url->link('tool/tweaks/vqmod_install', 'token=' . $this->session->data['token'] . '&vvqmod=' . $file . $hidden_add, 'SSL')
					);
				} else {
                    if (!in_array($file, array('-OpenShop-Core','-OpenShop_tweaks_menu','vqmod_opencart')))
					$action[] = array(
						'text' => $this->language->get('text_uninstall'),
						'href' => $this->url->link('tool/tweaks/vqmod_disable', 'token=' . $this->session->data['token'] . '&vvqmod=' . $file . $hidden_add, 'SSL')
					);
				}


                $errors = array();
                $p = 0;
                while (true) {
                    $p = strpos($this->data['log'],$vqmodd,$p);
                    if ($p==false) break;
                    // Find previos Enter
                    $p2 = strrpos($this->data['log'],":",$p);
                    if (substr($this->data['log'],$p2-18,18)=='DOM UNABLE TO LOAD') {
                        $errors[] = "<font color='red'>Syntax error(s) in XML structure</font>";
                        break;
                    }
                    $p2 = strpos($this->data['log'],'---------------------------------',$p);
                    $p = strpos($this->data['log'],'author    :',$p);
                    if (($p2<$p) or (!$p)) {
                        $p = $p2;
                        continue;
                    }
                    $lines = explode("\n",substr($this->data['log'],$p,$p2-$p));
                    $efile = false;
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (!$line) continue;
                        if (substr($line,0,6)=='author') continue;
                        if (substr($line,0,9)=='File Name') {
                            $efile = substr($line,15,-3);
                            continue;
                        }
                        if (substr($line,0,13)=='VQModObject::') $line = substr($line, strpos($line,'- ')+2);
                        $line = htmlspecialchars($line);
                        if (strpos($line,'(SKIPPED)'))
                            $line = "<font color='green'>$line</font>";
                        else $line = "<font color='red'>$line</font>";
                        if ($efile) $line = "$efile: $line";
                        $errors[]=$line;
                        $efile = false;
                    }
                }
                $errors = array_unique($errors);

                $tadd = false;
                if ($this->data['troubleshoot']) {

                    // Find possible conflicts
                    $conflicts = "";
                    $disable_all = $this->url->link('tool/tweaks/vqmod_disable', 'token=' . $this->session->data['token'] . $hidden_add . '&vvqmod=', 'SSL');
                    $enable_all = $this->url->link('tool/tweaks/vqmod_install', 'token=' . $this->session->data['token'] . $hidden_add . '&vvqmod=', 'SSL');
                    foreach ($vinfo as $xinfo) {
                        if ($info['file']==$xinfo['file']) continue;
                        if ($info['openshop'] and $xinfo['openshop']) continue;
                        if ($xinfo['file']=='vqmod_opencart') continue;
                        if ($xinfo['file']=='-OpenShop_tweaks_menu') continue;
                        if ($xinfo['file']=='-OpenShop-Core') continue;
                        if (($in = array_intersect($info['files'],$xinfo['files'])) and (array_values($in) != array("admin/view/template/common/header.tpl"))) {
                            if ($conflicts) $conflicts .= "<br/>";
                            if ($xinfo['enabled']) $conflicts .= "<a style='text-decoration:none' title='(".$this->language->get('vqmod_uninstall').")\n".$xinfo['desc']."' href='".$this->url->link('tool/tweaks/vqmod_disable', 'token=' . $this->session->data['token'] . '&vvqmod=' . $xinfo['file'] . $hidden_add, 'SSL')."'>" .$xinfo['title']. "</a>";
                            else $conflicts .= "<a style='text-decoration:none; color:grey' title='(".$this->language->get('vqmod_install').")\n".$xinfo['desc']."' href='".$this->url->link('tool/tweaks/vqmod_install', 'token=' . $this->session->data['token'] . '&vvqmod=' . $xinfo['file'] . $hidden_add, 'SSL')."'>" .$xinfo['title']. "</a>";
                            if ($xinfo['hidden']) $conflicts .= " <span style='font-size:0.8em; font-style: italic; color:grey;'>(".$this->language->get('hidden_file'). ")</span>";
                            if ($xinfo['enabled']) $disable_all.= $xinfo['file'] . "|";
                            else $enable_all.= $xinfo['file'] . "|";
                        }
                    }

                    if ($conflicts) {
                        if (strpos($disable_all,'|'))
                            $ins = "<a style='font-size:0.9em; font-style: italic;' href='$disable_all'>".$this->language->get('vqmod_disable_all')."</a>";
                        else $ins = "<a style='font-size:0.9em; font-style: italic;' href='$enable_all'>".$this->language->get('vqmod_enable_all')."</a>";
                        $conflicts = "<div style='margin-bottom:5px'><strong>".$this->language->get('vqmod_conflicts').":</strong> $ins</div>".$conflicts;
                    } else $conflicts = "<div style='margin-bottom:5px; color: green; font-style: italic'>".$this->language->get('vqmod_noconflicts')."</div>";


                    $tadd.= '<div style="font-size:0.9em; color: grey;"><div style="margin-bottom:5px"><strong style="color:black">'.$this->language->get('vqmod_modifies').':</strong></div>';
                    foreach ($info['files'] as $xfile) {
                        $p = strrpos($xfile,'/');
                        $tadd .= "";
                        $xfile = substr($xfile,0,$p) . '/<font color="black">' . substr($xfile,$p+1);
                        $tadd .= $xfile."</font></a><br/>";
                    }
                    $tadd.="</div>";

                    $tadd = "<table style='margin-left:20px' width='100%'><tr><td width='50%' style='padding:17px; border:none; vertical-align: top;background:white !important;'>$conflicts</td><td width='50%'  style='padding: 17px; border:none;  vertical-align: top; background:white !important;'>$tadd</td></tr></table>";

                    $tadd = "<a class='button' onclick='$(\"#mod$i\").toggle(300)'>".$this->language->get('vqmod_tbutton')."</a><div id='mod$i' style='display:none'>$tadd</div>";
                }

				$data = array(
					'file_name'  => $info['title'],
                    'enabled'    => !strpos($vqmodd, '.xml_'),
					'id'         => $info['desc'],
					'version'    => $info['version'],
					'vqmver'     => $info['vqmver'],
					'author'     => $info['author'],
					'status'     => strpos($vqmodd, '.xml_') ? $this->language->get('text_disabled') : $this->language->get('text_enabled'),
					'delete'     => $this->url->link('tool/tweaks/vqmod_delete', 'token=' . $this->session->data['token'] . '&vvqmod=' . basename($vqmodd), 'SSL'),
					'action'     => $action,
                    'vqmod'      => $vqmodd,
                    'hide'       => $info['hidden'],
                    'tadd'       => $tadd,
                    'errors'     => $errors
				);

                if ($data['enabled']) $this->data['vqmods'][$vqmodd] = $data;
                else $this->data['disabled'][$vqmodd] = $data;
			}
		}

        foreach ($this->data['disabled'] as $vq) $this->data['vqmods'][$vq['vqmod']] = $vq;

		// VQCache files
		if (isset($this->data['vqmod_path'])) {
			$vqcache_dir = $this->data['vqmod_path'] . 'vqcache/';
			$this->data['vqcache'] = array_diff(scandir($vqcache_dir), array('.', '..'));
		}

        if ($target)
            $this->data['heading_title'] .= "<span style='font-size:12px; font-weight: normal;'> that modify $target</span>";

		// Template
		$this->template = 'tool/tweaks.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

    // ------------ MXS -------------------------------

    public function openshop_disable() {
        $this->load->language('tool/tweaks');

        if (!$this->user->hasPermission('modify', 'user/user_permission')) {
            $this->session->data['error'] = $this->language->get('error_permission');
        } else {
            $fh = fopen(substr(DIR_SYSTEM,0,-7).'vqmod/xml/OpenShop/OpenShop_disabled', 'w');
            fclose($fh);
            $this->clear_cache(true);
            $this->redirect($this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }

    public function openshop_enable() {
        $this->load->language('tool/tweaks');

        if (!$this->user->hasPermission('modify', 'user/user_permission')) {
            $this->session->data['error'] = $this->language->get('error_permission');
        } else {
            unlink(substr(DIR_SYSTEM,0,-7).'vqmod/xml/OpenShop/OpenShop_disabled');
            $this->clear_cache(true);
            $this->redirect($this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }

	public function vqmod_install() {
		$this->load->language('tool/tweaks');

		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$path = substr_replace(DIR_SYSTEM, '', -7) . 'vqmod/' . 'xml/';
			$vqmods = explode('|',$this->request->get['vvqmod']);
            foreach($vqmods as $vqmod) {

            if (!file_exists($path . $vqmod . '.xml_')) $path.='openshop/';

			if (file_exists($path . $vqmod . '.xml_'))
                rename($path . $vqmod . '.xml_', $path . $vqmod . '.xml');
            }

				$this->clear_cache(true);

				$this->session->data['success'] = $this->language->get('success_install');
		}

        $link = $this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL');
        if (isset($this->request->get['hidden'])) $link .= "&hidden=1";
        if (isset($this->request->get['troubleshoot'])) $link .= "&troubleshoot=1";
        $this->redirect($link);
	}

	public function vqmod_disable() {
		$this->load->language('tool/tweaks');

		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$path = substr_replace(DIR_SYSTEM, '', -7) . 'vqmod/' . 'xml/';

            $vqmods = explode('|',$this->request->get['vvqmod']);
            foreach($vqmods as $vqmod) {
            if (!file_exists($path . $vqmod . '.xml')) $path.='OpenShop/';

			if (file_exists($path . $vqmod . '.xml'))
				rename($path . $vqmod . '.xml', $path . $vqmod . '.xml_');
            }

                $this->clear_cache(true);

				$this->session->data['success'] = $this->language->get('success_uninstall');
		}
        $link = $this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL');
        if (isset($this->request->get['hidden'])) $link .= "&hidden=1";
        if (isset($this->request->get['troubleshoot'])) $link .= "&troubleshoot=1";
		$this->redirect($link);
	}

	public function vqmod_upload() {
		$this->load->language('tool/tweaks');

		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			umask(0002);
			$file = $this->request->files['vqmod_file']['tmp_name'];
			$file_name = $this->request->files['vqmod_file']['name'];

			if ($this->request->files['vqmod_file']['error'] > 0) {

				switch($this->request->files['vqmod_file']['error']) {
					case 1:
						$this->session->data['error'] = $this->language->get('error_ini_max_file_size');
						break;
					case 2:
						$this->session->data['error'] = $this->language->get('error_form_max_file_size');
						break;
					case 3:
						$this->session->data['error'] = $this->language->get('error_partial_upload');
						break;
					case 4:
						$this->session->data['error'] = $this->language->get('error_no_upload');
						break;
					case 6:
						$this->session->data['error'] = $this->language->get('error_no_temp_dir');
						break;
					case 7:
						$this->session->data['error'] = $this->language->get('error_write_fail');
						break;
					case 8:
						$this->session->data['error'] = $this->language->get('error_php_conflict');
						break;
					default:
						$this->session->data['error'] = $this->language->get('error_unknown');
				}

			} else {
				if ($this->request->files['vqmod_file']['type'] != 'text/xml') {
					$this->session->data['error'] = $this->language->get('error_filetype');

				} else {
					libxml_use_internal_errors(true);
					simplexml_load_file($file);

					if (libxml_get_errors()) {
						libxml_clear_errors();
						$this->session->data['error'] = $this->language->get('error_invalid_xml');

					} elseif (move_uploaded_file($file, substr_replace(DIR_SYSTEM, '', -7) . 'vqmod/' . 'xml/' . $file_name) == FALSE) {
						$this->session->data['error'] = $this->language->get('error_move');

					} else {
                        $this->clear_cache(true);

						$this->session->data['success'] = $this->language->get('success_upload');
					}
				}
			}
		}

		$this->redirect($this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function vqmod_delete() {
		$this->load->language('tool/tweaks');

		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$path = $this->config->get('vqmod_path') . 'xml/';
			$vqmod = $this->request->get['vvqmod'];

			if (unlink($path . $vqmod)) {
				$this->clear_cache($return = true);

				$this->session->data['success'] = $this->language->get('success_delete');
			} else {
				$this->session->data['error'] = $this->language->get('error_delete');
			}
		}

		$this->redirect($this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function vqmod_backup() {
		$this->load->language('tool/tweaks');

		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->session->data['error'] = $this->language->get('error_permission');
			$this->redirect($this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$vqmods = glob($this->config->get('vqmod_path') . 'xml/*.xml*');

			$temp = tempnam('tmp', 'zip');

			$zip = new ZipArchive();
			$zip->open($temp, ZipArchive::OVERWRITE);

			foreach ($vqmods as $vqmod) {
				$zip->addFile($vqmod, basename($vqmod));
			}

			$zip->close();

			header('Pragma: public');
			header('Expires: 0');
			header('Content-Description: File Transfer');
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename=vqmod_backup_' . date('Y-m-d') . '.zip');
			header('Content-Transfer-Encoding: binary');
			readfile($temp);
			@unlink($temp);
		}
	}

	public function clear_cache($return = false) {
		$this->load->language('tool/tweaks');

		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$files = glob(substr(DIR_SYSTEM,0,-7) . 'vqmod/vqcache/' . 'vq*');
            $files = array_merge(array(substr(DIR_SYSTEM,0,-7).'vqmod/mods.cache'),$files);

			if ($files) {
				foreach ($files as $file) {
					if (file_exists($file)) {
						@unlink($file);
						clearstatcache();
					}
				}
			}

			if ($return) {
				return;
			}

			$this->session->data['success'] = $this->language->get('success_clear_cache');
		}

		$this->redirect($this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function clear_log() {
		$this->load->language('tool/tweaks');

		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
            $logfiles = glob(substr_replace(DIR_SYSTEM, '', -7) . 'vqmod/logs/*.log');
            if ($logfiles) {
                $logfiles = array_combine($logfiles, array_map("filemtime", $logfiles));
                arsort($logfiles);
                $log_file = key($logfiles);
            } else $log_file = '';
            if ($log_file) unlink($log_file);
			$this->session->data['success'] = $this->language->get('success_clear_log');
		}

		$this->redirect($this->url->link('tool/tweaks', 'token=' . $this->session->data['token'], 'SSL'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
