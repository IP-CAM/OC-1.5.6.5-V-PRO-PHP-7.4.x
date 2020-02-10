<?php

$_['text_security_banned']                  = '<b>Banned</b> Module';

// 404 Detect
$_['text_security_404_lockout']             = 'Your ability to access website has been suspended due to too many attempts to open page or file that does not exist. Please try again later.';
$_['text_security_404_notify_subject']      = '[%s] OpenCart Security 404 Detection Notification';
$_['text_security_404_notify_text']         = 'A %s has been locked out of the site %s due to too many attempts to open page or file that does not exist. You may login to the site to manually release the lock if necessary.';

// Login Attempts
$_['text_security_login_lockout']           = 'Your ability to login has been suspended due to too many recent failed login attempts. Please try again later.';
$_['text_security_login_notify_subject']    = '[%s] OpenCart Security Login Attempts Notification';
$_['text_security_login_notify_text']       = 'A %s has been locked out of the site %s due to too many login attempts. You may login to the site to manually release the lock if necessary.';

$_['text_security_notify_user']             = 'user %s at host %s';
$_['text_security_notify_host']             = 'host %s (you can check the host at http://ip-adress.com/ip_tracer/%s)';
$_['text_security_notify_ban']              = 'permanently';
$_['text_security_notify_until']            = 'until %s (server time)';

// Away Schedule
$_['text_security_away']                    = 'Your ability to login has been suspended due to configured access time schedule. Please try again later in working hours.';
$_['text_security_away_kicked']             = '%s was kicked from backend because security away mode became active';
$_['text_security_away_active']             = '%s tried to access backend when security away mode is active';

// Backup
$_['text_security_backup_notify_subject']   = '[%s] OpenCart Security Database Backup Notification';
$_['text_security_backup_creating']         = 'Creating backup archive %s';
$_['text_security_backup_uploading']        = 'Uploading %s to Google Drive';
$_['text_security_backup_file_size']        = 'File size %sMB';
$_['text_security_backup_chunk_size']       = 'Chunk size %sMB';
$_['text_security_backup_request']          = 'Request #%s';
$_['text_security_backup_backoff']          = 'Exponential backoff kicked in, sleeping for %s and a bit';
$_['text_security_backup_backoff_limit']    = 'Error: Reached time limit of exponential backoff';
$_['text_security_backup_uploaded']         = 'Uploaded %s%% (range %s of %s bytes)';
$_['text_security_backup_expired']          = 'Access token expired, trying to get a new one';
$_['text_security_backup_bad']              = 'Error: Bad response';
$_['text_security_backup_response']         = 'Response: %s';
$_['text_security_backup_done']             = 'All done!';
$_['text_security_backup_speed']            = 'Average upload speed %sMB/s';
$_['text_security_backup_md5']              = 'MD5 hash verification';
$_['text_security_backup_md5_bad']          = 'Error: MD5 mismatch; local:%s, google:%s';
$_['text_security_backup_md5_ok']           = 'MD5 OK';
$_['text_security_backup_not_complete']     = 'Error: Backup file is not complete';
$_['text_security_backup_not_exists']       = 'Error: Backup file is not exists at given path %s';
$_['text_security_backup_zip_error']        = 'Error: Missing ZipArchive Extension on the server';
$_['text_security_backup_zip_error_db']     = 'Error: Missing ZipArchive Extension on the server, trying to send unarchived';
$_['text_security_backup_arch_error']       = 'Error: Archive is not created, trying to send unarchived';
$_['text_security_backup_unauthorized']     = 'Error: Unauthorized';
$_['text_security_backup_resumable_error']  = 'Error: Could not create resumable file';
$_['text_security_backup_location_error']   = 'Error: No location header gotten back';

// Change Detect
$_['text_security_change_subject']          = '[%s] OpenCart Security Files Change Detection Notification';
$_['text_security_change_text']             = '<p>A file (or files) on your site have been changed. Please review the report below to verify changes are not the result of a compromise.<p>';
$_['text_security_file']                    = 'File';
$_['text_security_modified']                = 'Modified';
$_['text_security_file_hash']               = 'File MD5 hash';
$_['text_security_files_added']             = 'Files added';
$_['text_security_files_deleted']           = 'Files removed';
$_['text_security_files_changed']           = 'Files modified';
$_['text_security_file_change_warning']     = 'Security Module has noticed a change to some files in your OpenCart installation. Please review the <a href="%s">report</a> to make sure your system has not been compromised.';

$_['text_security_no_files_added']          = 'No files were added';
$_['text_security_no_files_deleted']        = 'No files were removed';
$_['text_security_no_files_changed']        = 'No files were modified';

$_['entry_security_scan_time']              = 'Scan time:';
$_['entry_security_files_added']            = 'Files added:';
$_['entry_security_files_deleted']          = 'Files removed:';
$_['entry_security_files_changed']          = 'Files modified:';
$_['entry_security_memory_used']            = 'Memory used:';
?>