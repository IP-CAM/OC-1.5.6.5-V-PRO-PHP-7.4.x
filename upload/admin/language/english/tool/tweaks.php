<?php
// Heading
$_['heading_error_log']    = 'Error Log';
$_['heading_settings']     = 'Settings and Maintenance';
$_['heading_title']        = 'OS Tweaks VqMod-Admin';
$_['heading_vqmods']       = 'VQMod Scripts';

// Columns
$_['column_action']        = 'Click Status to:';
$_['column_author']        = 'Author';
$_['column_delete']        = 'Delete';
$_['column_file_name']     = 'VqMod Title / Description';
$_['column_id']            = 'Name / Description';
$_['column_status']        = 'Status';
$_['column_version']       = 'OS - Version';
$_['column_vqmver']        = 'VQMod Version';

// Entry
$_['entry_backup']         = 'Backup VQMod Scripts:';
$_['entry_ext_version']    = 'VQMod Manager Version:';
$_['entry_status']         = 'VQMod Manager Status:';
$_['entry_upload']         = 'VQMod Upload:';
$_['entry_vqmod_path']     = 'VQMod Path:';
$_['entry_vqcache']        = 'VQMod Cache:';
$_['entry_use_cache']      = 'Output Caching:';

// Text
$_['text_autodetect']      = 'VQMod appears to be installed at the following path. Press Save to confirm path and complete installation.';
$_['text_autodetect_fail'] = 'Unable to detect VQMod installation.';
$_['text_delete']          = 'Delete';
$_['text_disabled']        = 'Disabled';
$_['text_enabled']         = 'Enabled';
$_['text_install']         = 'Enable';
$_['text_module']          = 'Module';
$_['text_no_results']      = 'No VQMod scripts were found!';
$_['text_success']         = 'Success: You have modified module VQMod Manager!';
$_['text_unavailable']     = '&mdash;';
$_['text_uninstall']       = 'Disable';
$_['text_vqcache_help']    = 'Some system files will always be present even after clearing the cache.';
$_['text_vqmod_path']      = 'VQMod directory path';
$_['text_button_refresh']         = 'Refresh';
$_['text_clear_vqcache']         = 'Clear Cache';
$_['text_clear_log']         = 'Clear Error Log';

// Button
$_['button_backup']        = 'Backup';
$_['button_cancel']        = 'Cancel';
$_['button_editor']        = 'Editor';
$_['button_clear']         = 'Clear';
$_['button_save']          = 'Save';
$_['button_upload']        = 'Upload';

// Error
$_['error_delete']         = 'Warning: Unable to delete VQMod script!';
$_['error_filetype']       = 'Warning: Invalid filetype!  Please only upload .xml files.';
$_['error_install']        = 'Warning: Unable to install VQMod script!';
$_['error_invalid_xml']    = 'Warning: VQMod script XML syntax does not appear to be valid!';
$_['error_log_size']       = 'Warning: Your VQMod error log is %sMBs.  The limit for VQMod Manager is 6MB.  If you need to view the errors you should download the log by FTP.  Otherwise consider clearing it below.';
$_['error_moddedfile']     = 'Warning: VQMod script attempts to mod file \'%s\' which does not appear to exist!';
$_['error_move']           = 'Warning: Unable to save file on server.  Please check directory permissions.';
$_['error_permission']     = 'Warning: You do not have permission to modify module VQMod Manager!';
$_['error_uninstall']      = 'Warning: Unable to uninstall VQMod script!';

// $_FILE Upload Errors
$_['error_form_max_file_size']   = 'Warning: VQMod script exceeds max allowable size!';
$_['error_ini_max_file_size']    = 'Warning: VQMod script exceeds max php.ini file size!';
$_['error_no_temp_dir']          = 'Warning: No temporary directory found!';
$_['error_no_upload']            = 'Warning: No file selected for upload!';
$_['error_partial_upload']       = 'Warning: Upload incomplete!';
$_['error_php_conflict']         = 'Warning: Unknown PHP conflict!';
$_['error_unknown']              = 'Warning: Unknown error!';
$_['error_write_fail']           = 'Warning: Failed to write VQMod script!';

// VQMod Log Errors
$_['error_mod_aborted']          = 'Mod Aborted';
$_['error_mod_skipped']          = 'Operation Skipped';

// Success
$_['success_clear_cache']        = 'Success: VQMod cache cleared!';
$_['success_clear_log']          = 'Success: VQMod error log cleared!';
$_['success_delete']             = 'Success: VQMod script deleted!';
$_['success_install']            = 'Success: VQMod script installed!';
$_['success_uninstall']          = 'Success: VQMod script uninstalled!';
$_['success_upload']             = 'Success: VQMod script uploaded!';

// Javascript Warnings
$_['warning_required_delete']    = 'WARNING: Deleting \\\'vqmod_opencart.xml\\\' will cause VQMod to STOP WORKING! Continue?';
$_['warning_required_uninstall'] = 'WARNING: Uninstalling \\\'vqmod_opencart.xml\\\' will cause VQMod to STOP WORKING! Continue?';
$_['warning_vqmod_delete']       = 'WARNING: Deleting a VQMod script cannot be undone! Are you sure you want to do this?';

// Version
$_['vqmod_manager_version']      = 'OS_1.5.6.5';

// Manual mode
$_['vqmod_manual']               = 'Switch to Manual Mode';
$_['vqmod_manual_adv']           = 'Switch to Manual Mode for better perfomance';
$_['vqmod_manual_wait']          = 'Creating modification database, it can take up to 30 seconds...';
$_['vqmod_auto']                 = 'Switch to Auto Mode';
$_['vqmod_auto_adv']             = 'Auto Mode is more comfortable for development and tests';
$_['vqmod_apply']                = 'Apply Changes';
$_['vqmod_toapply']              = 'Press "Apply Changes" to feel the change.';

// Hidden
$_['hidden_file']                = 'Hidden';
$_['show_hidden']                = 'Click to show <big>%d</big> hidden VqMod\'s';

// Troubleshoot
$_['vqmod_troubleshoot'] = 'Troubleshoot';
$_['vqmod_modifies'] = 'Modifies files';
$_['vqmod_install'] = 'Click to Enable';
$_['vqmod_uninstall'] = 'Click to Disable';
$_['vqmod_conflicts'] = 'May conflict with';
$_['vqmod_noconflicts'] = 'Possible conflicts not found';
$_['vqmod_tbutton'] = 'Inspect';
$_['vqmod_disable_all'] = 'Disable all';
$_['vqmod_enable_all'] = 'Enable all';
$_['vqmod_nerrors'] = 'Errors';
?>