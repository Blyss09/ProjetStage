<?php
/*
 * Tutorials :

  http://virusandlinux.baskoroadi.web.id/index.php/2009/05/tutorial-create-report-in-php-with-jasperreport-in-linux/
  http://www.simitgroup.com/?q=PHPJasperXML

 */
/* Testing JAVA */

ini_set("display_errors", 0);
// include _APPS_PATH."/cron/sendBookedAlert.php";
// echo "<br>".$page_requested; http://tpint/fr/MyTransporteo/print/ship/4007
// echo "<br>3eme param =><pre> ".print_r($url_array);
// echo "<br>3eme param =>".$url_array[3];
// echo "<pre>";print_r($_SESSION);

$id = $url_array[5];


switch ($url_array[4]) {
  
  case "inv": // Printing invoices
    //if(trim($_SESSION['customer']['address_id'])){
    $lib->generatePdfInvoice($id, $lib->lang, "I"); // PDF generated
    // }
    break;
  case "il": // Printing invoices
    //if(trim($_SESSION['customer']['address_id'])){
    $lib->generatePdfInvoiceList($id, $lib->lang, "D"); // PDF generated
    // }
    break;
  case 'invoice':
    $lib->printInv($id, $lib->lang, "D");
    break;
  case 'quote':
    $data = $sqlData->getQuoteInfos($id)['data'][0];
    $lib->printQuote($id, $lib->lang, "D", $data);
    break;
  case 'report': 
    $lib->generatePdfTransportReport($id, $lib->lang, "D");
    break;
}
