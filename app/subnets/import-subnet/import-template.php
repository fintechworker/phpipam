<?php

/**
 *	Generate XLS template
 *********************************/

/* functions */
require_once( dirname(__FILE__) . '/../../../functions/functions.php' );
require( dirname(__FILE__) . '/../../../functions/PEAR/Spreadsheet/Excel/Writer.php');

# classes
$Database 	= new Database_PDO;
$User 		= new User ($Database);
$Tools	 	= new Tools ($Database);
$Addresses	= new Addresses ($Database);
$Result 	= new Result;

# verify that user is logged in
$User->check_user_session();


// Create a workbook
$filename = "phpipam_template_". date("Y-m-d") .".xls";
$workbook = new Spreadsheet_Excel_Writer();
$workbook->setVersion(8);

//get all custom fields!
$custom_address_fields = $Tools->fetch_custom_fields('ipaddresses');

// Create a worksheet
$worksheet = $workbook->addWorksheet("template");
$worksheet->setInputEncoding("utf-8");

$lineCount = 1;

// set headers
$worksheet->write($lineCount, 0, _('ip address'));
$worksheet->write($lineCount, 1, _('ip state'));
$worksheet->write($lineCount, 2, _('description'));
$worksheet->write($lineCount, 3, _('hostname'));
// $worksheet->write($lineCount, 3, _('fw_object')); wrong line number

//daienliang 增加业务系统名称表头
$worksheet->write($lineCount, 4, _('App Name'));
$worksheet->write($lineCount, 5, _('fw object'));
$worksheet->write($lineCount, 6, _('mac'));
$worksheet->write($lineCount, 7, _('owner'));
$worksheet->write($lineCount, 8, _('device'));
$worksheet->write($lineCount, 9, _('port'));
$worksheet->write($lineCount, 10, _('note'));
$worksheet->write($lineCount, 11, _('Location'));
$fc = 11;
foreach($custom_address_fields as $k=>$f) {
	$worksheet->write($lineCount, $fc, $k);
	$fc++;
}

// sending HTTP headers
$workbook->send($filename);

// Let's send the file
$workbook->close();

?>
