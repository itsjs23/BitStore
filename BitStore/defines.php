<?php

//define('DHS_ROOT', 'http://localhost/inventory/');
//define('DHS_ROOT', 'http://118.139.162.161:90/inventory/');
//define('DHS_ROOT', 'http://paysavy.in/inventory/');

define('DHS_ROOT', '/'); // current working directory 

define('DHS_DISTRIBUTOR_INVENTORY_STATUS_PENDING', 		10);
define('DHS_DISTRIBUTOR_INVENTORY_STATUS_COMPLETED', 	20);
define('DHS_DISTRIBUTOR_INVENTORY_STATUS_VERIFIED', 	30);
define('DHS_DISTRIBUTOR_INVENTORY_STATUS_CANCEL', 		40);
define('DHS_DISTRIBUTOR_INVENTORY_STATUS_REVERT', 		50);


// Configuration Table Ids
define('DHS_CONFIG_MEDICAL_STORE_NAME', 				1000);
define('DHS_CONFIG_MEDICAL_STORE_MOBILE', 				1001);
define('DHS_CONFIG_MEDICAL_STORE_ADDRESS',	 			1002);
define('DHS_CONFIG_MEDICAL_STORE_THERSHOLD_VALUE',	 	1003);

define('PAGE_PER_NO',20); // number of results per page.

?>
