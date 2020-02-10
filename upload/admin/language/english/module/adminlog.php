<?php
// Heading
$_['heading_title']			= '<b>Admin Log</b> Module';

// Buttons
$_['button_save_go']			= 'Save and exit';
$_['button_save_stay']			= 'Save and stay';
$_['button_clear_go']			= '(Clear log)/(delete marked) & exit';
$_['button_clear_stay']			= '(Clear log)/(delete marked) & stay';

// Tabs
$_['tab_log']					= 'Log';
$_['tab_settings']				= 'Settings';
$_['tab_help']					= 'Description';

// Columns
$_['column_user']		= 'User';
$_['column_action']		= 'Action';
$_['column_allowed']	= 'Allowed';
$_['column_url']		= 'URL';
$_['column_ip']			= 'User IP';
$_['column_date']		= 'Date';


// Entry
$_['entry_adminlog_enable']			= 'Enable log';
$_['entry_adminlog_login']		= 'Log authorization';
$_['entry_adminlog_logout']		= 'Log deauthorization';
$_['entry_adminlog_hacklog']	= 'Log failed authorization (brute force)';
$_['entry_adminlog_access']		= 'Log viewing (access)';
$_['entry_adminlog_modify']		= 'Log update (modify)';
$_['entry_adminlog_allowed']	= 'Log: ';
$_['entry_adminlog_display']	= 'Show by: ';

$_['text_denied']			= 'denied actions';
$_['text_allowed']			= 'allowed actions';
$_['text_all']				= 'all';

// Text
$_['text_module']			= 'Modules';
$_['text_success']			= 'Module\'s settings has been updated!';
$_['text_description']		= '<p>The module Admin Log allows to record all or selected actions, which produce administrators of the online store.
								Using the options you can set the log as you are comfortable and keep track of the necessary events.</p>

								<p>Use the following options to config your log: </ p>
								<ul>
								<li>Enable log - enables and disables all maintenance records;</li>
								<li>Log authorization - includes recording each login to the admin panel;</li>
								<li>Log de-authorization - includes a record of each exit from the admin area;</li>
								<li>Log authorization failures - including a record of login attempts by one or another login (helps track admin account brute force); </ li>
								<li>Log view (access) - includes writing plain view/access;</li>
								<li>Log update (edit) - includes entry modification/edit/change items or settings; </li>
								<li>Log - you can choose the events to record. They can be allowed, denied or all; </li>
								<li>Show by - specify the number of rows to display the log in the list.</li>
								</ul>

								<p>All events are divided by two parameters: the ACTION and PERMISSION. Actions can take the values: </ p>
								<ul>
								<li>access - access/view;</li>
								<li>modify - change/modification;</li>
								<li>login/logout - input/output;</li>
								<li>clear log/clear X entries - clearing log/delete X records;</li>
								</ul>

								<p>Permission for action has two options: YES or NO. By importance of the event, every action is marked by the color for easy retrieval and analysis.
								Important messages are highlighted in red. These include: cleaning log, removing log entries, the authorization process fails, attempt to access a prohibited editing or access.</p>

								<p>A successful modification of elements and settings highlighted in yellow. Blue - acess to sections. Green - authorization, gray - deauthorize.</p>';
$_['text_help']				= '<p>If you have any questions or suggestions for improving the operation of the module, you can contact me:</p>
								<p>E-mail: <a href="mailto:mods@nikita-sp.com.ua">mods@nikita-sp.com.ua</a><br>
								Website: <a href="http://nikita-sp.com.ua/" target="_blank">nikita-sp.com.ua</a></p>


								<p>Support module, and donate a coin. Thanks.</p>
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
								<input type="hidden" name="cmd" value="_s-xclick">
								<input type="hidden" name="hosted_button_id" value="UGLKSM4UVN9S2">
								<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
								<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
								</form>
								<br><br>
								WMZ: Z320581374524 (USD)<br/>
								WMR: R227380004010 (RUB)<br/>
								WMU: U237282944947 (UAH)<br/>';

// Error
$_['error_permission']		= 'Warning: You do not have permission to modify module category!';
?>