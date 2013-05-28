<?php
/**
 * Copyright (c) 2012 SOFORT AG
 * 
 * Released under the GNU General Public License (Version 2)
 * [http://www.gnu.org/licenses/gpl-2.0.html]
 *
 * $Date: 2012-11-21 12:02:12 +0100 (Wed, 21 Nov 2012) $
 * @version SofortLib 1.5.0  $Id: example_sofortrechnung.php 5724 2012-11-21 11:02:12Z rotsch $
 * @author SOFORT AG http://www.sofort.com (integration@sofort.com)
 *
 */

require_once('../../../library/sofortLib.php');

define('CONFIGKEY', '1111:2222:6f3d938b65eb833e695393985e1r13z79c'); //your configkey or userid:projektid:apikey

$PnagInvoice = new PnagInvoice(CONFIGKEY);
$PnagInvoice->setVersion('MY_VERSION');

$PnagInvoice->addInvoiceAddress('John', 'Doe', 'Street', '15', '35578', 'City', 2, 'Max Mustermann', '3 Stock', 'Firma ABC');	//try firstname 'success' or 'decline' as firstname
$PnagInvoice->addShippingAddress('John', 'Doe', 'Street', '15', '35578', 'City', 2);
$PnagInvoice->setReason('Invoice', 'Invoice');
$PnagInvoice->setOrderId('213124');
$PnagInvoice->setCustomerId('213124');
$PnagInvoice->setDebitorVatNumber('DE325236');
$PnagInvoice->setEmailCustomer('tester@example.com');
$PnagInvoice->addItemToInvoice(
	md5('unique'),					// unique term to represent each item
	'Art01', 						// article number, type number, ... defined in shop
	'a simple title', 				// title
	1.20, 							// unit price (incl. VAT)
	0, 								// product type
	'a simple description', 		// description
	6, 								// number of articles
	19								// VAT
);

$PnagInvoice->setSuccessUrl('https://{website}/');
$PnagInvoice->setAbortUrl('https://{website}/');
$PnagInvoice->setTimeoutUrl('https://{website}/');
$PnagInvoice->setNotificationUrl('https://{website}/');

$err = $PnagInvoice->checkout();
$PnagInvoice->confirmInvoice($PnagInvoice->transactionId);

if($PnagInvoice->isError()) {
	//PNAG-API didn't accept the data
	echo $PnagInvoice->getError();
} else {
	//buyer must be redirected to $paymentUrl else payment cannot be successfully completed!
	$paymentUrl = $PnagInvoice->getPaymentUrl();
	header('Location: '.$paymentUrl);
}