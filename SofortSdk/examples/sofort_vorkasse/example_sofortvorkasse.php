<?php
/**
 * Copyright (c) 2012 SOFORT AG
 * 
 * Released under the GNU General Public License (Version 2)
 * [http://www.gnu.org/licenses/gpl-2.0.html]
 *
 * $Date: 2012-11-21 12:02:12 +0100 (Wed, 21 Nov 2012) $
 * @version SofortLib 1.5.0rc  $Id: example_sofortvorkasse.php 5724 2012-11-21 11:02:12Z rotsch $
 * @author SOFORT AG http://www.sofort.com (integration@sofort.com)
 *
 */

require_once('../../library/sofortLib.php');

define('CONFIGKEY', '1111:2222:1f7d368b64eb8d3e69500885f1c13e7c'); //your configkey or userid:projektid:apikey

$Sofort = new SofortLib_Multipay(CONFIGKEY);
$Sofort->setSofortvorkasse();
$Sofort->setAmount(10);
$Sofort->setReason('testueberweisung', 'verwendungszweck 2');
$Sofort->setSenderAccount('88888888', '12345678', 'Max Mustermann');
$Sofort->setSuccessUrl('https://{website}/');
$Sofort->setAbortUrl('https://{website}/');
$Sofort->setTimeoutUrl('https://{website}/');
$Sofort->setNotificationUrl('https://{website}/');
$Sofort->sendRequest();

if($Sofort->isError()) {
	//PNAG-API didn't accept the data
	echo $Sofort->getError();
} else {
	//buyer must be redirected to $paymentUrl else payment cannot be successfully completed!
	$paymentUrl = $Sofort->getPaymentUrl();
	header('Location: '.$paymentUrl);
}