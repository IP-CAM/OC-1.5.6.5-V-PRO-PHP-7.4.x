<?php
// Heading
$_['heading_title'] = '<b>Import / Export Price List to CSV</b> Module';

// Text
$_['text_export'] = 'Make a dump file with prices';
$_['text_success'] = 'Data imported!';
$_['text_module'] = 'Modules';
$_['text_notes'] =' Import supports the following formats: <br />
<strong> [Product ID]; [Product Name]; [Product Model]; [Manufacturer]; [Product Quantity]; [Product Price] </ strong> - corresponds to the export format, updated by [Product ID] <br />
<strong> [Product model]; [Number of goods]; [Product price] </ strong> - update by [Product model] <br />
<strong> [Product model]; [Product price] </ strong> - update by [Product model], only the price of the product is updated.
<br/> <br/> Field separator "<strong> semicolon </ strong>" sign, line separator "<strong> line break </ strong>". <br /> When importing data, only the quantity and price of goods are updated. <p> This module does not delete or add a product! </ p> ';

// Entry
$_['entry_import'] = 'Import data from file:';
$_['entry_import_help'] = 'The source file must be in UTF-8 encoding!';
$_['entry_export'] = 'Export:';
$_['entry_category'] = 'Export from categories:';
$_['entry_category_help'] = 'If no categories are selected - exports all products, <br> file is unloaded in UTF-8 encoding!';

// Error
$_['error_permission'] = 'You are not authorized to control this module!';
$_['error_empty'] = 'The downloaded file is empty!';

// Button
$_['button_export'] = 'Export';
$_['button_import'] = 'Import';
?>