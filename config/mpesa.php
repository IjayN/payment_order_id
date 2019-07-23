<?php
/**
 * Created by PhpStorm.
 * User: onyango
 * Date: 9/3/18
 * Time: 9:17 AM
 */
return [
	'url'  =>   'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
	'access_token'    =>  'GA6f0bA5CfARIzJMH6ISbJlLNS8s',

	'BusinessShortCode' =>  '245732',
	'Password'  =>  base64_encode('2457324df26996caff30013755b157bddd1dbc264eb7c84c5199056027725c0b769b2020190303113511'),
	'Timestamp' =>  '20190303113511',
	'TransactionType'   =>  'CustomerPayBillOnline',

	'PartyB'    =>  '245732',
	'CallBackURL'   =>  'api/payment/callback',
	'AccountReference'  =>  'Sembe',
	'TransactionDesc'   =>  'E-commerce'
];
