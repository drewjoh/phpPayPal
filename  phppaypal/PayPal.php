<?php

/*
	Software License Agreement (New BSD License)
	
	Copyright (c) 2007, Drew Johnston, YipMedia
	All rights reserved.
	
	Redistribution and use of this software in source and binary forms, with or without modification, are
	permitted provided that the following conditions are met:
	
	* Redistributions of source code must retain the above
	  copyright notice, this list of conditions and the
	  following disclaimer.
	
	* Redistributions in binary form must reproduce the above
	  copyright notice, this list of conditions and the
	  following disclaimer in the documentation and/or other
	  materials provided with the distribution.
	
	* Neither the name of Drew Johnston nor the names of his
	  contributors may be used to endorse or promote products
	  derived from this software without specific prior
	  written permission.
	
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED
	WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
	PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
	ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
	LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
	INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
	TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
	ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	
	Please give credit where credit is due. :)
*/



class PayPal { 
	
	// Public VARIABLES
	
	
	// Array of the response variables from PayPal requests
	public $Response;
	
	// Error Variables
	/*	$Error = an array of PayPal's response to any paypal errors
		All $_error's = are filled for any error that occurs, including PayPal errors
		Typically, if a method returns false, the $_error's should be filled with error information
		*/
	// Array of the error response from PayPal
	//  - [TIMESTAMP] [CORRELATIONID] [ACK] [L_ERRORCODE0] [L_SHORTMESSAGE0] [L_LONGMESSAGE0] [L_SEVERITYCODE0] [VERSION] [BUILD]
	public $Error; 
	
	public $_error = false;
	public $_error_ack;
	public $_error_type;
	public $_error_date;
	public $_error_code;
	public $_error_short_message;
	public $_error_long_message;
	public $_error_corrective_action;
	public $_error_severity_code;
	public $_error_version;
	public $_error_build; 
	public $_error_display_message;
	
	/*
	typical values found in a Request
	Format is  $our_variable_name; // PAYPALS_VARIABLE_NAME
	
	This could probably be organized a bit better
	*/
	
	public $payment_type = 'Sale'; // PAYMENTTYPE
	
	public $email; // EMAIL
	public $salutation; // SALUTATION
	public $first_name; // FIRSTNAME
	public $middle_name; // MIDDLENAME
	public $last_name; // LASTNAME
	public $suffix; // SUFFIX
	public $credit_card_type; // CREDITCARDTYPE --- Visa, MasterCard, Discover, Amex, Switch, Solo
	public $credit_card_number; // ACCT
	public $expire_date;  // EXPDATE - MMYYYY
	public $cvv2_code; // CVV2
	public $address1; // STREET
	public $address2; // STREET2
	public $city; // CITY
	public $state; // STATE
	public $postal_code; // ZIP
	public $phone_number; // PHONENUM
	
	public $country_code; // COUNTRYCODE
	
	public $currency_code = "USD"; // CURRENCYCODE
	
	public $ip_address; //IPADDRESS
	
	public $amount_total; // AMT
	public $amount_shipping; // SHIPPINGAMT
	public $amount_handling; // HANDLINGAMT
	public $amount_tax; // TAXAMT
	public $amount_sales_tax; // SALESTAX - This is apparently only used with getTransactionDetails, and appears to be the same as amount_tax
	public $amount_items; // ITEMAMT
	public $amount_max; // MAXAMT
	public $amount_fee; // FEEAMT
	public $amount_settle; // SETTLEAMT
	public $amount_refund_net; // NETREFUNDAMT
	public $amount_refund_fee; // FEEREFUNDAMT
	public $amount_refund_total; // GROSSREFUNDAMT
	
	public $shipping_name; // SHIPTONAME
	public $shipping_address1; // SHIPTOSTREET
	public $shipping_address2; // SHIPTOSTREET2
	public $shipping_city; // SHIPTOCITY
	public $shipping_state; // SHIPTOSTATE
	public $shipping_postal_code; // SHIPTOZIP
	public $shipping_country_code; // SHIPTOCOUNTRYCODE
	public $shipping_country_name;
	public $shipping_phone_number; // SHIPTOPHONENUM
	
	public $description; // DESC
	public $custom; // CUSTOM
	public $invoice; // INVNUM
	
	public $note; // NOTE
	
	public $notify_url; // NOTIFYURL
	public $require_confirmed_shipping_address; // REQCONFIRMSHIPPING
	public $no_shipping; // NOSHIPPING
	public $address_override; // ADDROVERRIDE
	public $local_code; // LOCALECODE
	public $page_style; // PAGESTYLE
	public $hdr_image; // HDRIMG
	public $hdr_border_color; //HDRBORDERCOLOR
	public $hdr_back_color; // HDRBACKCOLOR
	public $payflow_color; // PAYFLOWCOLOR
	public $channel_type; // CHANNELTYPE
	public $solution_type; // SOLUTIONTYPE
	
	 // Variables found (usually) to be returned to us
	
	public $ack;
	public $token; // TOKEN
	public $payer_id; // PAYERID
	public $payer_status; // PAYERSTATUS
	public $payer_business; // PAYERBUSINESS
	public $address_owner; // ADDRESSOWNER
	public $address_status; // ADDRESSSTATUS
	public $address_id;
	public $business; // BUSINESS
	
	public $avs_code;
	public $cvv2_match;
	
	public $transaction_id; // TRANSACTIONID
	public $parent_transaction_id; // PARENTTRANSACTIONID
	public $refund_transaction_id; // REFUNDTRANSACTIONID
	public $transaction_type; // TRANSACTIONTYPE
	public $payment_status; // PAYMENTSTATUS
	public $payment_pending_reason; // PENDINGREASON
	public $payment_reason_code; // REASONCODE
	public $order_time; // ORDERTIME
	public $timestamp;
	
	public $exchange_rate; // EXCHANGERATE
	
	public $receipt_id; // RECEIPTID
	
	public $receiver_business; // RECEIVERBUSINESS
	public $receiver_email; // RECEIVEREMAIL
	public $receiver_id; // RECEIVERID
	
	public $subscription_id; // SUBSCRIPTIONID
	public $subscription_date; // SUBSCRIPTIONDATE
	public $effective_date; // EFFECTIVEDATE
	public $retry_time; // RETRYTIME
	public $user_name; // USERNAME
	public $password; // PASSWORD
	public $recurrences; // RECURRENCES
	public $reattempt; // REATTEMPT
	public $recurring; // RECURRING
	public $period; // PERIOD
	public $buyer_id; // BUYERID
	public $closing_date; // CLOSINGDATE
	public $multiitem; // MULTIITEM
	
	public $refund_type; // REFUNDTYPE
	
	// Other
	
	public $build;
	public $version;
	public $correlation_id;
	
	/*
		This is the Items array, contains KEY => VALUE pairs
		for NAME => VALUE of items where NAME = name of item variable
		Names include: name, number, quantity, amount_tax, amount_total
	*/
	public $ItemsArray;
	
	
	/*
		This is an array of country names and their country codes
		Organized in CODE => NAME format
		This is purely for informational purposes, the class itself 
		doesn't use these.
	*/
	
	
	// $countries[COUNTRY_CODE] = COUNTRY_NAME
	public $countries = array ("US"=>"United States","AL"=>"Albania","DZ"=>"Algeria","AS"=>"American Samoa","AD"=>"Andorra","AI"=>"Anguilla","AG"=>"Antigua and Barbuda","AR"=>"Argentina","AM"=>"Armenia","AW"=>"Aruba","AU"=>"Australia","AT"=>"Austria","AZ"=>"Azerbaijan Republic","BS"=>"Bahamas","BH"=>"Bahrain","BD"=>"Bangladesh","BB"=>"Barbados","BY"=>"Belarus","BE"=>"Belgium","BZ"=>"Belize","BJ"=>"Benin","BM"=>"Bermuda","BO"=>"Bolivia","BA"=>"Bosnia and Herzegovina","BW"=>"Botswana","BR"=>"Brazil","VG"=>"British Virgin Islands","BN"=>"Brunei","BG"=>"Bulgaria","BF"=>"Burkina Faso","KH"=>"Cambodia","CM"=>"Cameroon","CA"=>"Canada","CV"=>"Cape Verde","KY"=>"Cayman Islands","CL"=>"Chile","C2"=>"China","CO"=>"Colombia","CK"=>"Cook Islands","CR"=>"Costa Rica","CI"=>"Cote D'Ivoire","HR"=>"Croatia","CY"=>"Cyprus","CZ"=>"Czech Republic","DK"=>"Denmark","DJ"=>"Djibouti","DM"=>"Dominica","DO"=>"Dominican Republic","TP"=>"East Timor","EC"=>"Ecuador","EG"=>"Egypt","SV"=>"El Salvador","EE"=>"Estonia","FM"=>"Federated States of Micronesia","FJ"=>"Fiji","FI"=>"Finland","FR"=>"France","GF"=>"French Guiana","PF"=>"French Polynesia","GA"=>"Gabon Republic","GE"=>"Georgia","DE"=>"Germany","GH"=>"Ghana","GI"=>"Gibraltar","GR"=>"Greece","GD"=>"Grenada","GP"=>"Guadeloupe","GU"=>"Guam","GT"=>"Guatemala","GN"=>"Guinea","GY"=>"Guyana","HT"=>"Haiti","HN"=>"Honduras","HK"=>"Hong Kong","HU"=>"Hungary","IS"=>"Iceland","IN"=>"India","ID"=>"Indonesia","IE"=>"Ireland","IL"=>"Israel","IT"=>"Italy","JM"=>"Jamaica","JP"=>"Japan","JO"=>"Jordan","KZ"=>"Kazakhstan","KE"=>"Kenya","KW"=>"Kuwait","LA"=>"Laos","LV"=>"Latvia","LB"=>"Lebanon","LS"=>"Lesotho","LT"=>"Lithuania","LU"=>"Luxembourg","MO"=>"Macau","MK"=>"Macedonia","MG"=>"Madagascar","MY"=>"Malaysia","MV"=>"Maldives","ML"=>"Mali","MT"=>"Malta","MH"=>"Marshall Islands","MQ"=>"Martinique","MU"=>"Mauritius","MX"=>"Mexico","MD"=>"Moldova","MN"=>"Mongolia","MS"=>"Montserrat","MA"=>"Morocco","MZ"=>"Mozambique","NA"=>"Namibia","NP"=>"Nepal","NL"=>"Netherlands","AN"=>"Netherlands Antilles","NZ"=>"New Zealand","NI"=>"Nicaragua","MP"=>"Northern Mariana Islands","NO"=>"Norway","OM"=>"Oman","PK"=>"Pakistan","PW"=>"Palau","PS"=>"Palestine","PA"=>"Panama","PG"=>"Papua New Guinea","PY"=>"Paraguay","PE"=>"Peru","PH"=>"Philippines","PL"=>"Poland","PT"=>"Portugal","PR"=>"Puerto Rico","QA"=>"Qatar","RO"=>"Romania","RU"=>"Russia","RW"=>"Rwanda","VC"=>"Saint Vincent and the Grenadines","WS"=>"Samoa","SA"=>"Saudi Arabia","SN"=>"Senegal","CS"=>"Serbia and Montenegro","SC"=>"Seychelles","SG"=>"Singapore","SK"=>"Slovakia","SI"=>"Slovenia","SB"=>"Solomon Islands","ZA"=>"South Africa","KR"=>"South Korea","ES"=>"Spain","LK"=>"Sri Lanka","KN"=>"St. Kitts and Nevis","LC"=>"St. Lucia","SZ"=>"Swaziland","SE"=>"Sweden","CH"=>"Switzerland","TW"=>"Taiwan","TZ"=>"Tanzania","TH"=>"Thailand","TG"=>"Togo","TO"=>"Tonga","TT"=>"Trinidad and Tobago","TN"=>"Tunisia","TR"=>"Turkey","TM"=>"Turkmenistan","TC"=>"Turks and Caicos Islands","UG"=>"Uganda","UA"=>"Ukraine","AE"=>"United Arab Emirates","GB"=>"United Kingdom","UY"=>"Uruguay","UZ"=>"Uzbekistan","VU"=>"Vanuatu","VE"=>"Venezuela","VN"=>"Vietnam","VI"=>"Virgin Islands (USA)","YE"=>"Yemen","ZM"=>"Zambia");
	
	
	// States for certain countries, many of these are required formats for PayPal (learned that the hard way)
	//	$states[COUNTRY_CODE][STATE_CODE] = STATE_NAME
	public $states = array(
		'US' => array ("AK"=>"AK","AL"=>"AL","AR"=>"AR","AZ"=>"AZ","CA"=>"CA","CO"=>"CO","CT"=>"CT","DC"=>"DC","DE"=>"DE","FL"=>"FL","GA"=>"GA","HI"=>"HI",
					"IA"=>"IA","ID"=>"ID","IL"=>"IL","IN"=>"IN","KS"=>"KS","KY"=>"KY","LA"=>"LA","MA"=>"MA","MD"=>"MD","ME"=>"ME","MI"=>"MI","MN"=>"MN",
					"MO"=>"MO","MS"=>"MS","MT"=>"MT","NC"=>"NC","ND"=>"ND","NE"=>"NE","NH"=>"NH","NJ"=>"NJ","NM"=>"NM","NV"=>"NV","NY"=>"NY","OH"=>"OH",
					"OK"=>"OK","OR"=>"OR","PA"=>"PA","RI"=>"RI","SC"=>"SC","SD"=>"SD","TN"=>"TN","TX"=>"TX","UT"=>"UT","VA"=>"VA","VT"=>"VT","WA"=>"WA",
					"WI"=>"WI","WV"=>"WV","WY"=>"WY","AA"=>"AA","AE"=>"AE","AP"=>"AP","AS"=>"AS","FM"=>"FM","GU"=>"GU","MH"=>"MH","MP"=>"MP","PR"=>"PR",
					"PW"=>"PW","VI"=>"VI")
				,
		'CA' => array ("AB"=>"Alberta", "BC"=>"British Columbia", "MB"=>"Manitoba", "NB"=>"New Brunswick", "NL"=>"Newfoundland", "NS"=>"Nova Scotia", 
					"NU"=>"Nunavut", "NT"=>"Northwest Territories", "ON"=>"Ontario", "PE"=>"Prince Edward Island", "QC"=>"Quebec", "SK"=>"Saskatchewan", 
					"YT"=>"Yukon")
				,
		'AU' => array ("Australian Capital Territory"=>"Australian Capital Territory","New South Wales"=>"New South Wales","Northern Territory"=>"Northern Territory",
					"Queensland"=>"Queensland","South Australia"=>"South Australia","Tasmania"=>"Tasmania","Victoria"=>"Victoria","Western Australia"=>"Western Australia")
				,
		'GB' => array ("Aberdeen City"=>"Aberdeen City","Aberdeenshire"=>"Aberdeenshire","Angus"=>"Angus","Antrim"=>"Antrim","Argyll and Bute"=>"Argyll and Bute",
					"Armagh"=>"Armagh","Avon"=>"Avon","Bedfordshire"=>"Bedfordshire","Berkshire"=>"Berkshire","Blaenau Gwent"=>"Blaenau Gwent","Borders"=>"Borders",
					"Bridgend"=>"Bridgend","Bristol"=>"Bristol","Buckinghamshire"=>"Buckinghamshire","Caerphilly"=>"Caerphilly","Cambridgeshire"=>"Cambridgeshire",
					"Cardiff"=>"Cardiff","Carmarthenshire"=>"Carmarthenshire","Ceredigion"=>"Ceredigion","Channel Islands"=>"Channel Islands","Cheshire"=>"Cheshire",
					"Clackmannan"=>"Clackmannan","Cleveland"=>"Cleveland","Conwy"=>"Conwy","Cornwall"=>"Cornwall","Cumbria"=>"Cumbria","Denbighshire"=>"Denbighshire",
					"Derbyshire"=>"Derbyshire","Devon"=>"Devon","Dorset"=>"Dorset","Down"=>"Down","Dumfries and Galloway"=>"Dumfries and Galloway","Durham"=>"Durham",
					"East Ayrshire"=>"East Ayrshire","East Dunbartonshire"=>"East Dunbartonshire","East Lothian"=>"East Lothian","East Renfrewshire"=>"East Renfrewshire",
					"East Riding of Yorkshire"=>"East Riding of Yorkshire","East Sussex"=>"East Sussex","Edinburgh City"=>"Edinburgh City","Essex"=>"Essex",
					"Falkirk"=>"Falkirk","Fermanagh"=>"Fermanagh","Fife"=>"Fife","Flintshire"=>"Flintshire","Glasgow"=>"Glasgow","Gloucestershire"=>"Gloucestershire",
					"Greater Manchester"=>"Greater Manchester","Gwynedd"=>"Gwynedd","Hampshire"=>"Hampshire","Herefordshire"=>"Herefordshire",
					"Hertfordshire"=>"Hertfordshire","Highland"=>"Highland","Humberside"=>"Humberside","Inverclyde"=>"Inverclyde","Isle of Anglesey"=>"Isle of Anglesey",
					"Isle of Man"=>"Isle of Man","Isle of Wight"=>"Isle of Wight","Isles of Scilly"=>"Isles of Scilly","Kent"=>"Kent","Lancashire"=>"Lancashire",
					"Leicestershire"=>"Leicestershire","Lincolnshire"=>"Lincolnshire","London"=>"London","Londonderry"=>"Londonderry","Merseyside"=>"Merseyside",
					"Merthyr Tydfil"=>"Merthyr Tydfil","Middlesex"=>"Middlesex","Midlothian"=>"Midlothian","Monmouthshire"=>"Monmouthshire","Moray"=>"Moray",
					"Neath Port Talbot"=>"Neath Port Talbot","Newport"=>"Newport","Norfolk"=>"Norfolk","North Ayrshire"=>"North Ayrshire",
					"North Lanarkshire"=>"North Lanarkshire","North Yorkshire"=>"North Yorkshire","Northamptonshire"=>"Northamptonshire","Northumberland"=>"Northumberland",
					"Nottinghamshire"=>"Nottinghamshire","Orkney"=>"Orkney","Oxfordshire"=>"Oxfordshire","Pembrokeshire"=>"Pembrokeshire",
					"Perthshire and Kinross"=>"Perthshire and Kinross","Powys"=>"Powys","Renfrewshire"=>"Renfrewshire","Rhondda Cynon Taff"=>"Rhondda Cynon Taff",
					"Rutland"=>"Rutland","Shetland"=>"Shetland","Shropshire"=>"Shropshire","Somerset"=>"Somerset","South Ayrshire"=>"South Ayrshire",
					"South Lanarkshire"=>"South Lanarkshire","South Yorkshire"=>"South Yorkshire","Staffordshire"=>"Staffordshire","Stirling"=>"Stirling",
					"Suffolk"=>"Suffolk","Surrey"=>"Surrey","Swansea"=>"Swansea","The Vale of Glamorgan"=>"The Vale of Glamorgan","Tofaen"=>"Tofaen",
					"Tyne and Wear"=>"Tyne and Wear","Tyrone"=>"Tyrone","Warwickshire"=>"Warwickshire","West Dunbartonshire"=>"West Dunbartonshire",
					"West Lothian"=>"West Lothian","West Midlands"=>"West Midlands","West Sussex"=>"West Sussex","West Yorkshire"=>"West Yorkshire",
					"Western Isles"=>"Western Isles","Wiltshire"=>"Wiltshire","Worcestershire"=>"Worcestershire","Wrexham"=>"Wrexham")
				,
		'ES' => array ("Alava" => "Alava", "Albacete" => "Albacete", "Alicante" => "Alicante", "Almeria" => "Almeria", "Asturias" => "Asturias", 
					"Avila" => "Avila", "Badajoz" => "Badajoz", "Barcelona" => "Barcelona", "Burgos" => "Burgos", "Caceres" => "Caceres", 
					"Cadiz" => "Cadiz", "Cantabria" => "Cantabria", "Castellon" => "Castellon", "Ceuta" => "Ceuta", "Ciudad Real" => "Ciudad Real", 
					"Cordoba" => "Cordoba", "Cuenca" => "Cuenca", "Guadalajara" => "Guadalajara", "Gerona" => "Gerona", "Granada" => "Granada", 
					"Guipuzcoa" => "Guipuzcoa", "Huelva" => "Huelva", "Huesca" => "Huesca", "Islas Baleares" => "Islas Baleares", "Jaen" => "Jaen", 
					"La Coruna" => "La Coruna", "Las Palmas" => "Las Palmas", "La Rioja" => "La Rioja", "Leon" => "Leon", "Lerida" => "Lerida", 
					"Lugo" => "Lugo", "Madrid" => "Madrid", "Malaga" => "Malaga", "Melilla" => "Melilla", "Murcia" => "Murcia", "Navarra" => "Navarra", 
					"Orense" => "Orense", "Palencia" => "Palencia", "Pontevedra" => "Pontevedra", "Salamanca" => "Salamanca", 
					"Santa Cruz de Tenerife" => "Santa Cruz de Tenerife", "Segovia" => "Segovia", "Sevilla" => "Sevilla", "Soria" => "Soria", 
					"Tarragona" => "Tarragona", "Teruel" => "Teruel", "Toledo" => "Toledo", "Valencia" => "Valencia", "Valladolid" => "Valladolid", 
					"Vizcaya" => "Vizcaya", "Zamora" => "Zamora", "Zaragoza" => "Zaragoza")
				);
	

	
	// Internal Use
	
	
	// AVS Response Code Values and Meanings
	//	$AvsResponseCodesArray[CODE][MESSAGE]
	//	$AvsResponseCodesArray[CODE][DETAILS]
	public $AvsResponseCodesArray = array (
			'A' => array('message' => 'Address', 'details' => 'Address Only (no ZIP)'),
			'B' => array('message' => 'International "A"', 'details' => 'Address Only (no ZIP)'),
			'C' => array('message' => 'International "N"', 'details' => 'None - The transaction is declined.'),
			'D' => array('message' => 'International "X"', 'details' => 'Address and Postal Code'),
			'E' => array('message' => 'Not Allowed for MOTO (Internet/Phone) transactions', 'details' => 'Not applicable - The transaction is declined.'),
			'F' => array('message' => 'UK-Specific "X"', 'details' => 'Address and Postal Code'),
			'G' => array('message' => 'Global Unavailable', 'details' => 'Not applicable'),
			'I' => array('message' => 'International Unavailable', 'details' => 'Not applicable'),
			'N' => array('message' => 'No', 'details' => 'None - The transaction is declined.'),
			'P' => array('message' => 'Postal (International "Z")', 'details' => 'Postal Code only (no Address)'),
			'R' => array('message' => 'Retry', 'details' => 'Not Applicable'),
			'S' => array('message' => 'Service Not Supported', 'details' => 'Not Applicable'),
			'U' => array('message' => 'Unavailable', 'details' => 'Not Applicable'),
			'W' => array('message' => 'Whole ZIP', 'details' => 'Nine-digit ZIP code (no Address)'),
			'X' => array('message' => 'Exact Match', 'details' => 'Address and nine-digit ZIP code'),
			'Y' => array('message' => 'Yes', 'details' => 'Address and five-digit ZIP'),
			'Z' => array('message' => 'ZIP', 'details' => 'Five-digit ZIP code (no Address)'),
			'' => array('message' => 'Error', 'details' => 'Not Applicable')
		);
			
	// CVV Rsponse Code Values and Meanings
	//	$CvvResponseCodesArray[CODE][MESSAGE]
	//	$CvvResponseCodesArray[CODE][DETAILS]
	public $CvvResponseCodesArray = array (
			'M' => array('message' => 'Match', 'details' => 'CVV2'), 
			'N' => array('message' => 'No Match', 'details' => 'None'), 
			'P' => array('message' => 'Not Processed', 'details' => 'Not Applicable'), 
			'S' => array('message' => 'Service not supported', 'details' => 'Not Applicable'), 
			'U' => array('message' => 'Service not available', 'details' => 'Not Applicable'), 
			'X' => array('message' => 'No response', 'details' => 'Not Applicable')
		);
	
	// CVV Rsponse Code Values and Meanings for Switch and Solo cards
	// TODO: ??
			
	
	
	
	public $RequestFieldsArray = array(
		'DoDirectPayment' => array(
				'payment_type' => array('name' => 'PAYMENTACTION', 'required' => 'yes'),
				'ip_address' => array('name' => 'IPADDRESS', 'required' => 'yes'),
				'amount_total' => array('name' => 'AMT', 'required' => 'yes'), 
				'credit_card_type' => array('name' => 'CREDITCARDTYPE', 'required' => 'yes'), 
				'credit_card_number' => array('name' => 'ACCT', 'required' => 'yes'), 
				'expire_date' => array('name' => 'EXPDATE', 'required' => 'yes'), 
				'first_name' => array('name' => 'FIRSTNAME', 'required' => 'yes'), 
				'last_name' => array('name' => 'LASTNAME', 'required' => 'yes'), 
				'address1' => array('name' => 'STREET', 'required' => 'no'), 
				'address2' => array('name' => 'STREET2', 'required' => 'no'), 
				'city' => array('name' => 'CITY', 'required' => 'no'), 
				'state' => array('name' => 'STATE', 'required' => 'no'), 
				'country_code' => array('name' => 'COUNTRYCODE', 'required' => 'no'), 
				'postal_code' => array('name' => 'ZIP', 'required' => 'no'), 
				'notify_url' => array('name' => 'NOTIFYURL', 'required' => 'no'), 
				'currency_code' => array('name' => 'CURRENCYCODE', 'required' => 'no'), 
				'amount_items' => array('name' => 'ITEMAMT', 'required' => 'no'), 
				'amount_shipping' => array('name' => 'SHIPPINGAMT', 'required' => 'no'), 
				'amount_handling' => array('name' => 'HANDLINGAMT', 'required' => 'no'), 
				'amount_tax' => array('name' => 'TAXAMT', 'required' => 'no'), 
				'description' => array('name' => 'DESC', 'required' => 'no'), 
				'custom' => array('name' => 'CUSTOM', 'required' => 'no'), 
				'invoice' => array('name' => 'INVNUM', 'required' => 'no'), 
				'cvv2_code' => array('name' => 'CVV2', 'required' => 'yes'), 
				'email' => array('name' => 'EMAIL', 'required' => 'no'), 
				'phone_number' => array('name' => 'PHONENUM', 'required' => 'no'), 
				'shipping_name' => array('name' => 'SHIPTONAME', 'required' => 'no'), 
				'shipping_address1' => array('name' => 'SHIPTOSTREET', 'required' => 'no'), 
				'shipping_address2' => array('name' => 'SHIPTOSTREET2', 'required' => 'no'), 
				'shipping_city' => array('name' => 'SHIPTOCITY', 'required' => 'no'), 
				'shipping_state' => array('name' => 'SHIPTOSTATE', 'required' => 'no'), 
				'shipping_postal_code' => array('name' => 'SHIPTOZIP', 'required' => 'no'), 
				'shipping_country_code' => array('name' => 'SHIPTOCOUNTRYCODE', 'required' => 'no'), 
				'shipping_phone_number' => array('name' => 'SHIPTOPHONENUM', 'required' => 'no')
				)
		,		
		'SetExpressCheckout' => array(
				'RETURN_URL' => array('name' => 'RETURNURL', 'required' => 'yes'),
				'CANCEL_URL' => array('name' => 'CANCELURL', 'required' => 'yes'),
				'amount_total' => array('name' => 'AMT', 'required' => 'yes'), 
				'currency_code' => array('name' => 'CURRENCYCODE', 'required' => 'no'), 
				'amount_max' => array('name' => 'MAXAMT', 'required' => 'no'), 
				'payment_type' => array('name' => 'PAYMENTACTION', 'required' => 'no'), 
				'email' => array('name' => 'EMAIL', 'required' => 'no'), 
				'description' => array('name' => 'DESC', 'required' => 'no'), 
				'custom' => array('name' => 'CUSTOM', 'required' => 'no'), 
				'invoice' => array('name' => 'INVNUM', 'required' => 'no'), 
				'phone_number' => array('name' => 'PHONENUM', 'required' => 'no'), 
				'shipping_name' => array('name' => 'SHIPTONAME', 'required' => 'no'), 
				'shipping_address1' => array('name' => 'SHIPTOSTREET', 'required' => 'no'), 
				'shipping_address2' => array('name' => 'SHIPTOSTREET2', 'required' => 'no'), 
				'shipping_city' => array('name' => 'SHIPTOCITY', 'required' => 'no'), 
				'shipping_state' => array('name' => 'SHIPTOSTATE', 'required' => 'no'), 
				'shipping_postal_code' => array('name' => 'SHIPTOZIP', 'required' => 'no'), 
				'shipping_country_code' => array('name' => 'SHIPTOCOUNTRYCODE', 'required' => 'no'), 
				'shipping_phone_number' => array('name' => 'SHIPTOPHONENUM', 'required' => 'no'), 
				'require_confirmed_shipping_address' => array('name' => 'REQCONFIRMSHIPPING', 'required' => 'no'),
				'no_shipping' => array('name' => 'NOSHIPPING', 'required' => 'no'), 
				'address_override' => array('name' => 'ADDROVERRIDE', 'required' => 'no'), 
				'token' => array('name' => 'TOKEN', 'required' => 'no'), 
				'locale_code' => array('name' => 'LOCALECODE', 'required' => 'no'), 
				'page_style' => array('name' => 'PAGESTYLE', 'required' => 'no'), 
				'hdr_img' => array('name' => 'HDRIMG', 'required' => 'no'), 
				'hdr_border_color' => array('name' => 'HDRBORDERCOLOR', 'required' => 'no'), 
				'hdr_background_color' => array('name' => 'HDRBACKCOLOR', 'required' => 'no'), 
				'payflow_color' => array('name' => 'PAYFLOWCOLOR', 'required' => 'no'), 
				'channel_type' => array('name' => 'CHANNELTYPE', 'required' => 'no'), 
				'solution_type' => array('name' => 'SOLUTIONTYPE', 'required' => 'no') 
				)
		,		
		'GetExpressCheckoutDetails' => array(
				'token' => array('name' => 'TOKEN', 'required' => 'yes')
				)
		,		
		'DoExpressCheckoutPayment' => array(
				'token' => array('name' => 'TOKEN', 'required' => 'yes'),
				'payment_type' => array('name' => 'PAYMENTACTION', 'required' => 'yes'), 
				'payer_id' => array('name' => 'PAYERID', 'required' => 'yes'),
				'amount_total' => array('name' => 'AMT', 'required' => 'yes'), 
				'description' => array('name' => 'DESC', 'required' => 'no'), 
				'custom' => array('name' => 'CUSTOM', 'required' => 'no'), 
				'invoice' => array('name' => 'INVNUM', 'required' => 'no'), 
				'notify_url' => array('name' => 'NOTIFYURL', 'required' => 'no'), 
				'amount_items' => array('name' => 'ITEMAMT', 'required' => 'no'), 
				'amount_shipping' => array('name' => 'SHIPPINGAMT', 'required' => 'no'), 
				'amount_handling' => array('name' => 'HANDLINGAMT', 'required' => 'no'), 
				'amount_tax' => array('name' => 'TAXAMT', 'required' => 'no'), 
				'currency_code' => array('name' => 'CURRENCYCODE', 'required' => 'no'), 
				'shipping_name' => array('name' => 'SHIPTONAME', 'required' => 'no'), 
				'shipping_address1' => array('name' => 'SHIPTOSTREET', 'required' => 'no'), 
				'shipping_address2' => array('name' => 'SHIPTOSTREET2', 'required' => 'no'), 
				'shipping_city' => array('name' => 'SHIPTOCITY', 'required' => 'no'), 
				'shipping_state' => array('name' => 'SHIPTOSTATE', 'required' => 'no'), 
				'shipping_postal_code' => array('name' => 'SHIPTOZIP', 'required' => 'no'), 
				'shipping_country_code' => array('name' => 'SHIPTOCOUNTRYCODE', 'required' => 'no'), 
				'shipping_phone_number' => array('name' => 'SHIPTOPHONENUM', 'required' => 'no')
				)
		,		
		'GetTransactionDetails' => array(
				'transaction_id' => array('name' => 'TRANSACTIONID', 'required' => 'yes')
				)
		,		
		'RefundTransaction' => array(
				'transaction_id' => array('name' => 'TRANSACTIONID', 'required' => 'yes'), 
				'refund_type' => array('name' => 'REFUNDTYPE', 'required' => 'yes'), 
				'amount_total' => array('name' => 'AMT', 'required' => 'no'), 
				'note' => array('name' => 'NOTE', 'required' => 'no'),
				)
		);
	
	
	public $ResponseFieldsArray = array(
		'DoDirectPayment' => array(
				'timestamp' => 'TIMESTAMP',
				'correlation_id' => 'CORRELATIONID',
				'ack' => 'ACK',
				'version' => 'VERSION',
				'build' => 'BUILD',
				'avs_code' => 'AVSCODE',
				'cvv2_match' => 'CVV2MATCH',
				'transaction_id' => 'TRANSACTIONID',
				'amount_total' => 'AMT',
				'currency_code' => 'CURRENCYCODE'
				)
		,
		'SetExpressCheckout' => array(
				'timestamp' => 'TIMESTAMP',
				'correlation_id' => 'CORRELATIONID',
				'ack' => 'ACK',
				'version' => 'VERSION',
				'build' => 'BUILD',
				'token' => 'TOKEN'
				)
		,
		'DoExpressCheckoutPayment' => array(
				'timestamp' => 'TIMESTAMP',
				'correlation_id' => 'CORRELATIONID',
				'ack' => 'ACK',
				'version' => 'VERSION',
				'build' => 'BUILD',
				'token' => 'TOKEN',
				'transaction_id' => 'TRANSACTIONID',
				'transaction_type' => 'TRANSACTIONTYPE',
				'payment_type' => 'PAYMENTTYPE',
				'order_time' => 'ORDERTIME',
				'amount_total' => 'AMT',
				'currency_code' => 'CURRENCYCODE',
				'amount_fee' => 'FEEAMT',
				'amount_settle' => 'SETTLEAMT',
				'amount_tax' => 'TAXAMT',
				'exchange_rate' => 'EXCHANGERATE',
				'payment_status' => 'PAYMENTSTATUS',
				'payment_pending_reason' => 'PENDINGREASON',
				'payment_reason_code' => 'REASONCODE'
				)
		,
		'GetExpressCheckoutDetails' => array(
				'timestamp' => 'TIMESTAMP',
				'correlation_id' => 'CORRELATIONID',
				'ack' => 'ACK',
				'version' => 'VERSION',
				'build' => 'BUILD',
				'token' => 'TOKEN',
				'email' => 'EMAIL',
				'payer_id' => 'PAYERID',
				'payer_status' => 'PAYERSTATUS',
				'salutation' => 'SALUTATION',
				'first_name' => 'FIRSTNAME',
				'middle_name' => 'MIDDLENAME',
				'last_name' => 'LASTNAME',
				'suffix' => 'SUFFIX',
				'country_code' => 'COUNTRYCODE',
				'business' => 'BUSINESS',
				'shipping_name' => 'SHIPTONAME',
				'shipping_address1' => 'SHIPTOSTREET',
				'shipping_address2' => 'SHIPTOSTREET2',
				'shipping_city' => 'SHIPTOCITY',
				'shipping_state' => 'SHIPTOSTATE',
				'shipping_country_code' => 'SHIPTOCOUNTRYCODE',
				'shipping_country_name' => 'SHIPTOCOUNTRYNAME',
				'shipping_postal_code' => 'SHIPTOZIP',
				'address_id' => 'ADDRESSID', // Is this a returned variable? Some docs say yes, some no
				'address_status' => 'ADDRESSSTATUS',
				'description' => 'DESC',
				'custom' => 'CUSTOM',
				'phone_number' => 'PHONENUM'
				)
		,
		'GetTransactionDetails' => array(
				'timestamp' => 'TIMESTAMP',
				'correlation_id' => 'CORRELATIONID',
				'ack' => 'ACK',
				'version' => 'VERSION',
				'build' => 'BUILD',
				'receiver_business' => 'RECEIVERBUSINESS',
				'receiver_email' => 'RECEIVEREMAIL',
				'receiver_id' => 'RECEIVERID',
				'email' => 'EMAIL',
				'payer_id' => 'PAYERID',
				'payer_status' => 'PAYERSTATUS',
				'salutation' => 'SALUTATION',
				'first_name' => 'FIRSTNAME',
				'last_name' => 'LASTNAME',
				'middle_name' => 'MIDDLENAME',
				'suffix' => 'SUFFIX',
				'payer_business' => 'PAYERBUSINESS',
				'country_code' => 'COUNTRYCODE',
				'business' => 'BUSINESS',
				'shipping_name' => 'SHIPTONAME',
				'shipping_address1' => 'SHIPTOSTREET',
				'shipping_address2' => 'SHIPTOSTREET2',
				'shipping_city' => 'SHIPTOCITY',
				'shipping_state' => 'SHIPTOSTATE',
				'shipping_country_code' => 'SHIPTOCOUNTRYCODE',
				'shipping_country_name' => 'SHIPTOCOUNTRYNAME',
				'shipping_postal_code' => 'SHIPTOZIP',
				'address_id' => 'ADDRESSID', // Is this a returned variable? Some docs say yes, some no
				'address_status' => 'ADDRESSSTATUS',
				'address_owner' => 'ADDRESSOWNER',
				'parent_transaction_id' => 'PARENTTRANSACTIONID',
				'transaction_id' => 'TRANSACTIONID',
				'receipt_id' => 'RECEIPTID',
				'transaction_type' => 'TRANSACTIONTYPE',
				'payment_type' => 'PAYMENTTYPE',
				'order_time' => 'ORDERTIME',
				'amount_total' => 'AMT',
				'currency_code' => 'CURRENCYCODE',
				'amount_fee' => 'FEEAMT',
				'amount_settle' => 'SETTLEAMT',
				'amount_tax' => 'TAXAMT',
				'exchange_rate' => 'EXCHANGERATE',
				'payment_status' => 'PAYMENTSTATUS',
				'payment_pending_reason' => 'PENDINGREASON',
				'payment_reason_code' => 'REASONCODE',
				'amount_sales_tax' => 'SALESTAX',
				'invoice' => 'INVNUM',
				'note' => 'NOTE',
				'custom' => 'CUSTOM',
				'subscription_id' => 'SUBSCRIPTIONID',
				'subscription_date' => 'SUBSCRIPTIONDATE',
				'effective_date' => 'EFFECTIVEDATE',
				'retry_time' => 'RETRYTIME',
				'user_name' => 'USERNAME',
				'recurrences' => 'RECURRENCES',
				'reattempt' => 'REATTEMPT',
				'recurring' => 'RECURRING',
				'period' => 'PERIOD',
				'buyer_id' => 'BUYERID',
				'closing_date' => 'CLOSINGDATE',
				'multiitem' => 'MULTIITEM'
				)
		,
		'RefundTransaction' => array(
				'refund_transaction_id' => 'REFUNDTRANSACTIONID',
				'amount_refund_net' => 'NETFUNDAMT',
				'amount_refund_fee' => 'FEEREFUNDAMT',
				'amount_refund_total' => 'GROSSREFUNDAMT'
				)
		);
	
	
	public $ErrorCodesArray = array(
		
		// ***********************************************
		// NVP Validation Errors
		// ***********************************************
		
		'81000' => array('short_message' => 'Missing Parameter', 'long_message' => 'Required Parameter Missing : Unable to identify parameter', 'display_message' => ''), 
		'81001' => array('short_message' => 'Invalid Parameter', 'long_message' => 'A Parameter is Invalid : Unable to identify parameter', 'display_message' => ''), 
		'81002' => array('short_message' => 'Unspecified Method', 'long_message' => 'Method Specified is not Supported', 'display_message' => ''), 
		'81003' => array('short_message' => 'Unspecified Method', 'long_message' => 'No Method Specified', 'display_message' => ''), 
		'81004' => array('short_message' => 'Unspecified Method', 'long_message' => 'No Request Received', 'display_message' => ''), 
		'81100' => array('short_message' => 'Missing Parameter', 'long_message' => 'OrderTotal (Amt) : Required parameter missing', 'display_message' => ''), 
		'81101' => array('short_message' => 'Missing Parameter', 'long_message' => 'MaxAmt : Required parameter missing', 'display_message' => ''), 
		'81102' => array('short_message' => 'Missing Parameter', 'long_message' => 'ReturnURL: Required parameter missing', 'display_message' => ''), 
		'81103' => array('short_message' => 'Missing Parameter', 'long_message' => 'NotifyURL : Required parameter missing', 'display_message' => ''), 
		'81104' => array('short_message' => 'Missing Parameter', 'long_message' => 'CancelURL : Required parameter missing', 'display_message' => ''), 
		'81105' => array('short_message' => 'Missing Parameter', 'long_message' => 'ShipToStreet : Required parameter missing', 'display_message' => ''), 
		'81106' => array('short_message' => 'Missing Parameter', 'long_message' => 'ShipToStreet2 : Required parameter missing', 'display_message' => ''), 
		'81107' => array('short_message' => 'Missing Parameter', 'long_message' => 'ShipToCity : Required parameter missing', 'display_message' => ''), 
		'81108' => array('short_message' => 'Missing Parameter', 'long_message' => 'ShipToState : Required parameter missing', 'display_message' => ''), 
		'81109' => array('short_message' => 'Missing Parameter', 'long_message' => 'ShipToZip : Required parameter missing', 'display_message' => ''), 
		'81110' => array('short_message' => 'Missing Parameter', 'long_message' => 'Country : Required parameter missing', 'display_message' => ''), 
		'81111' => array('short_message' => 'Missing Parameter', 'long_message' => 'ReqConfirmShipping : Required parameter missing', 'display_message' => ''), 
		'81112' => array('short_message' => 'Missing Parameter', 'long_message' => 'NoShipping : Required parameter missing', 'display_message' => ''), 
		'81113' => array('short_message' => 'Missing Parameter', 'long_message' => 'AddrOverride : Required parameter missing', 'display_message' => ''), 
		'81114' => array('short_message' => 'Missing Parameter', 'long_message' => 'LocaleCode : Required parameter missing', 'display_message' => ''), 
		'81115' => array('short_message' => 'Missing Parameter', 'long_message' => 'PaymentAction : Required parameter missing', 'display_message' => ''), 
		'81116' => array('short_message' => 'Missing Parameter', 'long_message' => 'Email : Required parameter missing', 'display_message' => ''), 
		'81117' => array('short_message' => 'Missing Parameter', 'long_message' => 'Token : Required parameter missing', 'display_message' => ''), 
		'81118' => array('short_message' => 'Missing Parameter', 'long_message' => 'PayerID : Required parameter missing', 'display_message' => ''), 
		'81119' => array('short_message' => 'Missing Parameter', 'long_message' => 'ItemAmt : Required parameter missing', 'display_message' => ''), 
		'81120' => array('short_message' => 'Missing Parameter', 'long_message' => 'ShippingAmt : Required parameter missing', 'display_message' => ''), 
		'81121' => array('short_message' => 'Missing Parameter', 'long_message' => 'HandlingTotal Amt : Required parameter missing', 'display_message' => ''), 
		'81122' => array('short_message' => 'Missing Parameter', 'long_message' => 'TaxAmt : Required parameter missing', 'display_message' => ''), 
		'81123' => array('short_message' => 'Missing Parameter', 'long_message' => 'IPAddress : Required parameter missing', 'display_message' => ''), 
		'81124' => array('short_message' => 'Missing Parameter', 'long_message' => 'ShipToName : Required parameter missing', 'display_message' => ''), 
		'81125' => array('short_message' => 'Missing Parameter', 'long_message' => 'L_Amt : Required parameter missing', 'display_message' => ''), 
		'81126' => array('short_message' => 'Missing Parameter', 'long_message' => 'Amt : Required parameter missing', 'display_message' => ''), 
		'81127' => array('short_message' => 'Missing Parameter', 'long_message' => 'L_TaxAmt : Required parameter missing', 'display_message' => ''), 
		'81128' => array('short_message' => 'Missing Parameter', 'long_message' => 'AuthorizationID : Required parameter missing', 'display_message' => ''), 
		'81129' => array('short_message' => 'Missing Parameter', 'long_message' => 'CompleteType : Required parameter missing', 'display_message' => ''), 
		'81130' => array('short_message' => 'Missing Parameter', 'long_message' => 'CurrencyCode : Required parameter missing', 'display_message' => ''), 
		'81131' => array('short_message' => 'Missing Parameter', 'long_message' => 'TransactionID : Required parameter missing', 'display_message' => ''), 
		'81132' => array('short_message' => 'Missing Parameter', 'long_message' => 'TransactionEntity : Required parameter missing', 'display_message' => ''), 
		'81133' => array('short_message' => 'Missing Parameter', 'long_message' => 'Acct : Required parameter missing', 'display_message' => ''), 
		'81134' => array('short_message' => 'Missing Parameter', 'long_message' => 'ExpDate : Required parameter missing', 'display_message' => ''), 
		'81135' => array('short_message' => 'Missing Parameter', 'long_message' => 'FirstName : Required parameter missing', 'display_message' => ''), 
		'81136' => array('short_message' => 'Missing Parameter', 'long_message' => 'LastName : Required parameter missing', 'display_message' => ''), 
		'81137' => array('short_message' => 'Missing Parameter', 'long_message' => 'Street : Required parameter missing', 'display_message' => ''), 
		'81138' => array('short_message' => 'Missing Parameter', 'long_message' => 'Street2 : Required parameter missing', 'display_message' => ''), 
		'81139' => array('short_message' => 'Missing Parameter', 'long_message' => 'City : Required parameter missing', 'display_message' => ''), 
		'81140' => array('short_message' => 'Missing Parameter', 'long_message' => 'State : Required parameter missing', 'display_message' => ''), 
		'81141' => array('short_message' => 'Missing Parameter', 'long_message' => 'Zip : Required parameter missing', 'display_message' => ''), 
		'81142' => array('short_message' => 'Missing Parameter', 'long_message' => 'CountryCode : Required parameter missing', 'display_message' => ''), 
		'81143' => array('short_message' => 'Missing Parameter', 'long_message' => 'RefundType : Required parameter missing', 'display_message' => ''), 
		'81144' => array('short_message' => 'Missing Parameter', 'long_message' => 'StartDate : Required parameter missing', 'display_message' => ''), 
		'81145' => array('short_message' => 'Missing Parameter', 'long_message' => 'EndDate : Required parameter missing', 'display_message' => ''), 
		'81146' => array('short_message' => 'Missing Parameter', 'long_message' => 'MPID: Required parameter missing', 'display_message' => ''), 
		'81147' => array('short_message' => 'Missing Parameter', 'long_message' => 'CreditCardType : Required parameter missing', 'display_message' => ''), 
		'81148' => array('short_message' => 'Missing Parameter', 'long_message' => 'User : Required parameter missing', 'display_message' => ''), 
		'81149' => array('short_message' => 'Missing Parameter', 'long_message' => 'Pwd : Required parameter missing', 'display_message' => ''), 
		'81150' => array('short_message' => 'Missing Parameter', 'long_message' => 'Version : Required parameter missing', 'display_message' => ''), 
		'81200' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Amt : Invalid parameter', 'display_message' => ''), 
		'81201' => array('short_message' => 'Invalid Parameter', 'long_message' => 'MaxAmt : Invalid parameter', 'display_message' => ''), 
		'81203' => array('short_message' => 'Invalid Parameter', 'long_message' => 'NotifyURL : Invalid parameter', 'display_message' => ''), 
		'81205' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ShipToStreet : Invalid parameter', 'display_message' => ''), 
		'81206' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ShipToStreet2 : Invalid parameter', 'display_message' => ''), 
		'81207' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ShipToCity : Invalid parameter', 'display_message' => ''), 
		'81208' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ShipToState : Invalid parameter', 'display_message' => ''), 
		'81209' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ShipToZip : Invalid parameter', 'display_message' => ''), 
		'81210' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Country : Invalid parameter', 'display_message' => ''), 
		'81211' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ReqConfirmShipping : Invalid parameter', 'display_message' => ''), 
		'81212' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Noshipping : Invalid parameter', 'display_message' => ''), 
		'81213' => array('short_message' => 'Invalid Parameter', 'long_message' => 'AddrOverride : Invalid parameter', 'display_message' => ''), 
		'81214' => array('short_message' => 'Invalid Parameter', 'long_message' => 'LocaleCode : Invalid parameter', 'display_message' => ''), 
		'81215' => array('short_message' => 'Invalid Parameter', 'long_message' => 'PaymentAction : Invalid parameter', 'display_message' => ''), 
		'81219' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ItemAmt : Invalid parameter', 'display_message' => ''), 
		'81220' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ShippingAmt : Invalid parameter', 'display_message' => ''), 
		'81221' => array('short_message' => 'Invalid Parameter', 'long_message' => 'HandlingTotal Amt : Invalid parameter', 'display_message' => ''), 
		'81222' => array('short_message' => 'Invalid Parameter', 'long_message' => 'TaxAmt : Invalid parameter', 'display_message' => ''), 
		'81223' => array('short_message' => 'Invalid Parameter', 'long_message' => 'IPAddress : Invalid parameter', 'display_message' => ''), 
		'81224' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ShipToName : Invalid parameter', 'display_message' => ''), 
		'81225' => array('short_message' => 'Invalid Parameter', 'long_message' => 'L_Amt : Invalid parameter', 'display_message' => ''), 
		'81226' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Amt : Invalid parameter', 'display_message' => ''), 
		'81227' => array('short_message' => 'Invalid Parameter', 'long_message' => 'L_TaxAmt : Invalid parameter', 'display_message' => ''), 
		'81229' => array('short_message' => 'Invalid Parameter', 'long_message' => 'CompleteType : Invalid parameter', 'display_message' => ''), 
		'81230' => array('short_message' => 'Invalid Parameter', 'long_message' => 'CurrencyCode : Invalid parameter', 'display_message' => ''), 
		'81232' => array('short_message' => 'Invalid Parameter', 'long_message' => 'TransactionEntity : Invalid parameter', 'display_message' => ''), 
		'81234' => array('short_message' => 'Invalid Parameter', 'long_message' => 'ExpDate : Invalid parameter', 'display_message' => ''), 
		'81235' => array('short_message' => 'Invalid Parameter', 'long_message' => 'FirstName : Invalid parameter', 'display_message' => ''), 
		'81236' => array('short_message' => 'Invalid Parameter', 'long_message' => 'LastName : Invalid parameter', 'display_message' => ''), 
		'81237' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Street : Invalid parameter', 'display_message' => ''), 
		'81238' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Street2 : Invalid parameter', 'display_message' => ''), 
		'81239' => array('short_message' => 'Invalid Parameter', 'long_message' => 'City : Invalid parameter', 'display_message' => ''), 
		'81243' => array('short_message' => 'Invalid Parameter', 'long_message' => 'RefundType : Invalid parameter', 'display_message' => ''), 
		'81244' => array('short_message' => 'Invalid Parameter', 'long_message' => 'StartDate : Invalid parameter', 'display_message' => ''), 
		'81245' => array('short_message' => 'Invalid Parameter', 'long_message' => 'EndDate : Invalid parameter', 'display_message' => ''), 
		'81247' => array('short_message' => 'Invalid Parameter', 'long_message' => 'CreditCardType : Invalid parameter', 'display_message' => ''), 
		'81248' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Username : Invalid parameter', 'display_message' => ''), 
		'81249' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Password : Invalid parameter', 'display_message' => ''), 
		'81250' => array('short_message' => 'Invalid Parameter', 'long_message' => 'Version : Invalid parameter', 'display_message' => ''), 
		'81251' => array('short_message' => 'Internal Error', 'long_message' => 'Internal Service Error', 'display_message' => ''), 
		
		// ***********************************************
		// General API Errors
		// ***********************************************
		
		'10001' => array('short_message' => 'Internal Error', 'long_message' => 'Internal Error', 'display_message' => ''), 
		'10001' => array('short_message' => 'Internal Error', 'long_message' => 'Soap header is NULL', 'display_message' => ''), 
		'10001' => array('short_message' => 'Internal Error', 'long_message' => 'The transaction could not be loaded', 'display_message' => ''), 
		'10001' => array('short_message' => 'Internal Error', 'long_message' => 'Transaction failed due to internal error', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'Username/Password is incorrect', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'Account is locked or inactive', 'display_message' => ''), 
		'10002' => array('short_message' => 'Internal Error', 'long_message' => 'Internal Error', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'Internal Error', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'Account is not verified', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'This call is not defined in the database!', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'Token is not valid', 'display_message' => ''), 
		'10002' => array('short_message' => 'Restricted account', 'long_message' => 'Account is restricted', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'Token is not valid', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'API access is disabled for this account', 'display_message' => ''), 
		'10002' => array('short_message' => 'Restricted account', 'long_message' => 'Account is restricted', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'Client certificate is disabled', 'display_message' => ''), 
		'10002' => array('short_message' => 'Authentication/Authorization Failed', 'long_message' => 'You do not have permissions to make this API call', 'display_message' => ''), 
		'10006' => array('short_message' => 'Version error', 'long_message' => 'Version is not supported', 'display_message' => ''), 
		'10008' => array('short_message' => 'Security error', 'long_message' => 'Security header is not valid', 'display_message' => ''), 
		'10101' => array('short_message' => 'This API Temporarily Unavailable', 'long_message' => 'This API is temporarily unavailable. Please try later.', 'display_message' => ''), 
		
		// ***********************************************
		// Authorize / Capture API Errors
		// ***********************************************
		
		'10001' => array('short_message' => 'Internal Error', 'long_message' => 'Internal Error', 'corrective_action' => '', 'display_message' => ''), 
		'10001' => array('short_message' => 'Internal Error', 'long_message' => 'Transaction failed due to internal error', 'corrective_action' => '', 'display_message' => ''), 
		'10004' => array('short_message' => 'Internal Error', 'long_message' => 'Invalid argument', 'corrective_action' => '', 'display_message' => ''), 
		'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Currency is not supported', 'corrective_action' => 'Retry the request with USD.', 'display_message' => ''), 
		'10007' => array('short_message' => 'Permission denied', 'long_message' => 'You do not have permissions to make this API call', 'corrective_action' => '', 'display_message' => ''),  
		'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'Account is locked or inactive', 'corrective_action' => 'Retry the request at a later time or close order.', 'display_message' => ''),  
		'10010' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Invalid argument', 'corrective_action' => '', 'display_message' => ''),  
		'10600' => array('short_message' => 'Authorization voided', 'long_message' => 'Authorization is voided.', 'corrective_action' => 'Cancel the order.', 'display_message' => ''),  
		'10601' => array('short_message' => 'Authorization expired', 'long_message' => 'Authorization has expired.', 'corrective_action' => 'Cancel the order.', 'display_message' => ''),  
		'10602' => array('short_message' => 'Authorization completed', 'long_message' => 'Authorization has already been completed.', 'corrective_action' => ' Close the order.', 'display_message' => ''),  
		'10603' => array('short_message' => 'The buyer is restricted.', 'long_message' => 'The buyer account is restricted.', 'corrective_action' => 'Contact the buyer.', 'display_message' => ''),  
		'10604' => array('short_message' => 'Authorization must include both buyer and seller.', 'long_message' => 'Authorization transaction cannot be unilateral. It must include both buyer and seller to make an auth.', 'corrective_action' => 'Review the order to ensure customer is a PayPal member.', 'display_message' => ''),  
		'10605' => array('short_message' => 'Unsupported currency', 'long_message' => 'Currency is not supported.', 'corrective_action' => 'Retry the request with USD.', 'display_message' => ''),  
		'10606' => array('short_message' => 'Buyer cannot pay.', 'long_message' => 'Transaction rejected, please contact the buyer.', 'corrective_action' => '', 'display_message' => ''),  
		'10607' => array('short_message' => 'Auth &amp; Capture unavailable', 'long_message' => 'Authorization &amp; Capture feature unavailable.', 'corrective_action' => 'Contact PayPal Customer Service.', 'display_message' => ''),  
		'10608' => array('short_message' => 'Funding source missing', 'long_message' => 'The funding source is missing.', 'corrective_action' => 'Contact the buyer.', 'display_message' => ''),  
		'10609' => array('short_message' => 'Invalid TransactionID', 'long_message' => 'Transaction id is invalid.', 'corrective_action' => 'Review the transaction ID and reattempt the request.', 'display_message' => ''),  
		'10610' => array('short_message' => 'Amount limit exceeded', 'long_message' => 'Amount specified exceeds allowable limit.', 'corrective_action' => 'Reattempt the request with a lower amount.', 'display_message' => ''),  
		'10611' => array('short_message' => 'Not enabled', 'long_message' => 'Authorization &amp; Capture feature is not enabled for the merchant. Contact customer service.', 'corrective_action' => 'Contact PayPal Customer Service.', 'display_message' => ''),  
		'10612' => array('short_message' => 'No more settlement', 'long_message' => 'Maxmimum number of allowable settlements has been reached. No more settlement for the authorization.', 'corrective_action' => 'Close this order.', 'display_message' => ''),  
		'10613' => array('short_message' => 'Currency mismatch', 'long_message' => 'Currency of capture must be the same as currency of authorization.', 'corrective_action' => 'Reattempt the request, using the same currency as specified in the authorization.', 'display_message' => ''),  
		'10614' => array('short_message' => 'Cannot void reauth', 'long_message' => 'You can void only the original authorization, not a reauthorization.', 'corrective_action' => 'Void the authorization.', 'display_message' => ''),  
		'10615' => array('short_message' => 'Cannot reauth reauth', 'long_message' => 'You can reauthorize only the original authorization, not a reauthorization.', 'corrective_action' => 'Capture the reauthorization.', 'display_message' => ''),  
		'10616' => array('short_message' => 'Maximum number of reauthorization allowed for the auth is reached.', 'long_message' => 'Maximum number of reauthorization allowed for the auth is reached.', 'corrective_action' => 'Capture the order.', 'display_message' => ''),  
		'10617' => array('short_message' => 'Reauthorization not allowed', 'long_message' => 'Reauthorization is not allowed inside honor period.', 'corrective_action' => 'Capture the authorization.', 'display_message' => ''),  
		'10618' => array('short_message' => 'Transaction already voided or expired', 'long_message' => 'Transaction has already been voided or expired.', 'corrective_action' => 'Close the order.', 'display_message' => ''),  
		'10619' => array('short_message' => 'Invoice ID value exceeds maximum allowable length.', 'long_message' => 'Invoice ID value exceeds maximum allowable length.', 'corrective_action' => 'Check the length of the invoice ID and reattempt the request.', 'display_message' => ''),  
		'10620' => array('short_message' => 'Order has already been voided or expired.', 'long_message' => 'Order has already been voided or expired.', 'corrective_action' => 'Close this order.', 'display_message' => ''),  
		'10621' => array('short_message' => 'Order has expired.', 'long_message' => 'Order has expired.', 'corrective_action' => 'Close this order.', 'display_message' => ''),  
		'10622' => array('short_message' => 'Order is voided.', 'long_message' => 'Order is voided.', 'corrective_action' => 'Close this order.', 'display_message' => ''),  
		'10623' => array('short_message' => 'Maximum number of authorization allowed for the order is reached.', 'long_message' => 'Maximum number of authorization allowed for the order is reached.', 'corrective_action' => 'Capture this order.', 'display_message' => ''),  
		'10624' => array('short_message' => 'Duplicate invoice', 'long_message' => 'Payment has already been made for this InvoiceID.', 'corrective_action' => 'Review the invoice ID and reattempt the rquest.', 'display_message' => ''),  
		'10625' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'The amount exceeds the maximum amount for a single transaction.', 'corrective_action' => 'Reattempt the request with a lower amount.', 'display_message' => ''),  
		'10626' => array('short_message' => 'Risk', 'long_message' => 'Transaction refused due to risk model', 'corrective_action' => 'Contact the buyer.', 'display_message' => ''),  
		'10627' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'The invoice ID field is not supported for basic authorizations', 'corrective_action' => 'The Invoice ID field can only be used with order authorizations.', 'display_message' => ''),  
		'10628' => array('short_message' => 'This transaction cannot be processed at this time. Please try again later.', 'long_message' => 'This transaction cannot be processed at this time. Please try again later.', 'corrective_action' => '', 'display_message' => ''),  
		'10629' => array('short_message' => '<em>Reauthorization not allowed.', 'long_message' => '<em>Reauthorization is not allowed for this type of authorization.', 'corrective_action' => 'Use <em>DoAuthorization</em> to authorize the an order.', 'display_message' => ''),  
		'10630' => array('short_message' => 'Item amount is invalid.', 'long_message' => 'Item amount is invalid.', 'corrective_action' => '', 'display_message' => ''),  

		// ***********************************************
		// DoDirectPayment API Errors
		// ***********************************************
		
		'10102' => array('short_message' => 'PaymentAction of Order Temporarily Unavailable', 'long_message' => 'PaymentAction of Order is temporarily unavailable. Please try later or use other PaymentAction.', 'corrective_action' => '', 'display_message' => ''),  
		'10400' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Order total is missing', 'corrective_action' => '', 'display_message' => ''),  
		'10418' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details', 'long_message' => 'The currencies of the shopping cart amounts must be the same.', 'corrective_action' => '', 'display_message' => ''),  
		'10426' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Item total is invalid.', 'corrective_action' => '', 'display_message' => ''),  
		'10427' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Shipping total is invalid.', 'corrective_action' => '', 'display_message' => ''),  
		'10428' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Handling total is invalid.', 'corrective_action' => '', 'display_message' => ''),  
		'10429' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Tax total is invalid.', 'corrective_action' => '', 'display_message' => ''),  
		'10432' => array('short_message' => 'Invalid argument', 'long_message' => 'Invoice ID value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
		'10500' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed due to an invalid merchant configuration.', 'corrective_action' => '', 'display_message' => ''),  
		'10501' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed due to an invalid merchant configuration.', 'corrective_action' => '', 'display_message' => ''),  
		'10502' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please use a valid credit card.', 'corrective_action' => 'The credit card used is expired. The CVV provided is invalid.  The CVV is between 3-4 digits long.', 'display_message' => ''),  
		 
		'10504' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid Credit Card Verification Number.', 'corrective_action' => 'The CVV provided is invalid.  The CVV is between 3-4 digits long.', 'display_message' => ''),  
		 
		'10505' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was refused because the AVS response returned the value of  N, and the merchant account is not able to accept such transactions.  ', 'display_message' => ''),  
		 
		'10507' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed. Please contact PayPal Customer Service.,Your PayPal account is restricted - contact PayPal for more information.', 'corrective_action' => '', 'display_message' => ''),  
		'10508' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card expiration date.', 'corrective_action' => 'The expiration date must be a two-digit month and four-digit year.', 'display_message' => ''),  
		'10509' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed.,You must submit an IP address of the buyer with each API call.', 'corrective_action' => '', 'display_message' => ''),  
		'10510' => array('short_message' => 'Invalid Data', 'long_message' => 'The credit card type is not supported. Try another card type.,The credit card type entered is not currently supported by PayPal.', 'corrective_action' => '', 'display_message' => ''),  
		'10511' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed.,The merchant selected an value for the PaymentAction field that is not supported.', 'corrective_action' => '', 'display_message' => ''),  
		'10512' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a first name.,The first name of the buyer is required for this merchant.', 'corrective_action' => '', 'display_message' => ''),  
		'10513' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a last name.,The last name of the buyer is required for this merchant.', 'corrective_action' => '', 'display_message' => ''),  
		 
		'10519' => array('short_message' => 'Invalid Data', 'long_message' => 'Please enter a credit card.', 'corrective_action' => 'The credit card field was blank.', 'display_message' => ''),  
		 
		'10520' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The total amount and item amounts do not match.', 'display_message' => ''),  
		 
		'10521' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card.,The credit card entered is invalid.', 'corrective_action' => '', 'display_message' => ''),  
		 
		'10523' => array('short_message' => 'Internal Error', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => '', 'display_message' => ''),  
		'10525' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. The amount to be charged is zero.', 'corrective_action' => '', 'display_message' => ''),  
		'10526' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. The currency is not supported at this time.', 'corrective_action' => 'The currency code entered is not supported.', 'display_message' => ''),  
		 
		'10527' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card number and type.', 'corrective_action' => 'The credit card entered is invalid.', 'display_message' => ''),  
		 
		'10534' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card number and type.', 'corrective_action' => 'The credit card entered is currently restricted by PayPal.  Contact PayPal for more information.', 'display_message' => ''),  
		 
		'10535' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card number and type.', 'corrective_action' => 'The credit card entered is invalid.', 'display_message' => ''),  
		 
		'10536' => array('short_message' => 'Invalid Data', 'long_message' => 'The transaction was refused as a result of a duplicate invoice ID supplied.', 'corrective_action' => 'The merchant entered an invoice ID that is already associated with a transaction by the same merchant.  By default, the invoice ID must be unique for all transactions.  To change this setting, log into PayPal or contact customer service.', 'display_message' => ''),  
		 
		'10537' => array('short_message' => 'Filter Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined by the country filter managed by the merchant. To accept this transaction, change your risk settings on PayPal.', 'display_message' => ''),  
		'10538' => array('short_message' => 'Filter Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined by the maximum amount filter managed by the merchant.  To accept this transaction, change your risk settings on PayPal.', 'display_message' => ''),  
		 
		'10539' => array('short_message' => 'Filter Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined by PayPal.  Contact PayPal for more information.', 'display_message' => ''),  
		 
		'10540' => array('short_message' => 'Invalid Data', 'long_message' => 'The transaction cannot be processed due to an invalid address.', 'corrective_action' => 'The transaction was declined by PayPal because of an invalid address.', 'display_message' => ''),  
		 
		'10541' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card number and type.', 'corrective_action' => 'The credit card entered is currently restricted by PayPal.  Contact PayPal for more information.', 'display_message' => ''),  
		 
		'10542' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid email address.', 'corrective_action' => 'The email address provided by the buyer is in an invalid format.', 'display_message' => ''),  
		 
		'10544' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined by PayPal.  Contact PayPal for more information.', 'display_message' => ''),  
		 
		'10545' => array('short_message' => 'Gateway Decline', 'long_message' => 'The transaction was refused.', 'corrective_action' => 'The transaction was declined by PayPal because of possible fraudulent activity.  Contact PayPal for more information.', 'display_message' => ''),  
		 
		'10546' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined by PayPal because of possible fraudulent activity on the IP address.  Contact PayPal for more information.', 'display_message' => ''),  
		 
		'10547' => array('short_message' => 'Internal Error', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => '', 'display_message' => ''),  
		'10548' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed. The merchant\'s account is not able to process transactions.', 'corrective_action' => 'The merchant account attempting the transaction is not a business account at PayPal.  Check your account settings.', 'display_message' => ''),  
		 
		'10549' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed. The merchant\'s account is not able to process transactions.', 'corrective_action' => 'The merchant account attempting the transaction is not able to process Direct Payment transactions.  Contact PayPal for more information.', 'display_message' => ''),  
		 
		'10550' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'Access to Direct Payment was disabled for your account. Contact PayPal for more information.', 'display_message' => ''),  
		'10552' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The merchant account attempting the transaction does not have a confirmed email address with PayPal. Check your account settings', 'display_message' => ''),  
		'10553' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The merchant attempted a transaction where the amount exceeded the upper limit for that merchant', 'display_message' => ''),  
		'10554' => array('short_message' => 'Filter Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined because of a merchant risk filter for AVS. Specifically, the merchant has set to decline transaction when the AVS returned a no match (AVS = N)', 'display_message' => ''),  
		'10555' => array('short_message' => 'Filter Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined because of a merchant risk filter for AVS. Specifically, the merchant has set to decline transaction when the AVS returned a partial match', 'display_message' => ''),  
		'10556' => array('short_message' => 'Filter Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined because of a merchant risk filter for AVS. Specifically, the merchant has set to decline transaction when the AVS was unsupported', 'display_message' => ''),  
		'10561' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a complete billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10562' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card expiration year.', 'corrective_action' => '', 'display_message' => ''),  
		'10563' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card expiration month.', 'corrective_action' => '', 'display_message' => ''),  
		'10564' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => '', 'display_message' => ''),  
		'10565' => array('short_message' => 'Merchant country unsupported', 'long_message' => 'The merchant country is not supported.', 'corrective_action' => '', 'display_message' => ''),  
		'10566' => array('short_message' => 'Credit card type unsupported', 'long_message' => 'The credit card type is not supported.', 'corrective_action' => '', 'display_message' => ''),  
		'10567' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card number and type.', 'corrective_action' => '', 'display_message' => ''),  
		'10701' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10702' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid address1 in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10703' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid address2 in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10704' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid city in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10705' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid state in the billing address.', 'corrective_action' => 'Occurs when the country is the US but the state is not a valid U.S. state or when the province is not a valid province for the country. Ensure that you are requiring the customer to enter a valid two-character U.S. state code, preferable with a pull-down list.', 'display_message' => ''),  
		'10706' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your five digit postal code in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10707' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid country in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10708' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a complete billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10709' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter an address1 in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10710' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a city in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10711' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your state in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10712' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your five digit postal code in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10713' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a country in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10714' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10715' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid state in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10716' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your five digit postal code in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10717' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your five digit postal code in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10718' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid city and state in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10719' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10720' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid address1 in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10721' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid address2 in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10722' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid city in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10723' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid state in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10724' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your five digit postal code in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10725' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid country in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10726' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a complete shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10727' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter an address1 in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10728' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a city in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10729' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your state in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10730' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your five digit postal code in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10731' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a country in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10732' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10733' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid state in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10734' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your five digit postal code in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10735' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter your five digit postal code in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10736' => array('short_message' => 'Invalid Data', 'long_message' => 'There is an error with this transaction. Please enter a valid city and state in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10744' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid country code in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10745' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please enter a valid country code in the shipping address.', 'corrective_action' => '', 'display_message' => ''),  
		'10746' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. Please use a valid country on the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10747' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The merchant entered an IP address that was in an invalid format.  The IP address must be in a format such as 123.456.123.456.', 'display_message' => ''),  
		 
		'10748' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed without a Credit Card Verification number.', 'corrective_action' => 'The merchant\'s configuration requires a CVV to be entered, but no CVV was provided with this transaction.  Contact PayPal if you wish to change this setting.', 'display_message' => ''),  
		'10750' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed without a Credit Card Verification number.', 'corrective_action' => '', 'display_message' => ''),  
		'10751' => array('short_message' => 'Invalid Data', 'corrective_action' => 'There is an error with this transaction. Please enter a valid state in the billing address.', 'corrective_action' => '', 'display_message' => ''),  
		'10752' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'Possible causes of 10752 include:
			<ul>
				<li>There was a problem with the CVV2 or AVS on the card.</li>
				<li>There is a problem with the buyer.</li>
				<li>The transaction was denied by the credit card\'s issuing bank.</li>
				<li>The transaction was considered to be of too high risk. </li></ul>
		The best way to deal with the error is to inspect the CVV2 and AVS codes that are returned along with the 10752 error. If the buyer\'s transaction has been denied, the buyer may still be able to perform the transaction by using a different credit card.', 'display_message' => ''),  
		 
		'10754' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => '', 'display_message' => ''),  
		'10755' => array('short_message' => 'Invalid data ', 'long_message' => 'This transaction cannot be processed due to an unsupported currency.', 'corrective_action' => '', 'display_message' => ''),  
		'10756' => array('short_message' => 'Gateway Decline', 'long_message' => 'The transaction cannot be processed. The country and billing address associated with this credit card do not match.', 'corrective_action' => '', 'display_message' => ''),  
		'10758' => array('short_message' => 'Invalid Configuration', 'long_message' => 'There is been an error due to invalid API username and/or password.', 'corrective_action' => '', 'display_message' => ''),  
		'10759' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card number and type.', 'corrective_action' => '', 'display_message' => ''),  
		'10760' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed. The country listed for your business address is not currently supported.', 'corrective_action' => '', 'display_message' => ''),  
		'10761' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed. Please check the status of your first transaction before placing another order.', 'corrective_action' => 'The transaction was declined because PayPal is currently processing a transaction by the same buyer for the same amount.  Can occur when a buyer submits multiple, identical transactions in quick succession.', 'display_message' => ''),  
		 
		'10762' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'Can occur when the CVV2 code is less than or greater than four digits but the card is American Express, or when the CVV code is less than or greater than three digits but the card is Visa, MasterCard, or Discover. Ensure that your program enforces the proper restrictions on the length of the CVV2 code and card type.', 'display_message' => ''),  
		 
		'10763' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => '', 'display_message' => ''),  
		'15001' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was rejected by PayPal because of excessive failures over a short period of time for this credit card. Contact PayPal for more information', 'display_message' => ''),  
		'15002' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined by PayPal. Contact PayPal for more information', 'display_message' => ''),  
		'15003' => array('short_message' => 'Invalid Configuration', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined because the merchant does not have a valid commercial entity agreement on file with PayPal. Contact PayPal for more information.', 'display_message' => ''),  
		'15004' => array('short_message' => 'Gateway Decline', 'long_message' => 'This transaction cannot be processed. Please enter a valid Credit Card Verification Number.', 'corrective_action' => 'The transaction was declined because the CVV entered does not match the credit card.', 'display_message' => ''),  
		'15005' => array('short_message' => 'Processor Decline', 'long_message' => 'This transaction cannot be processed.', 'corrective_action' => 'The transaction was declined by the issuing bank,not PayPal. The merchant should attempt another card', 'display_message' => ''),  
		'15006' => array('short_message' => 'Processor Decline', 'long_message' => 'This transaction cannot be processed. Please enter a valid credit card number and type.', 'corrective_action' => 'The transaction was declined by the issuing bank,not PayPal. The merchant should attempt another card', 'display_message' => ''),  
		'15007' => array('short_message' => 'Processor Decline', 'long_message' => 'This transaction cannot be processed. Please use a valid credit card.', 'corrective_action' => 'The transaction was declined by the issuing bank because of an expired credit card. The merchant should attempt another card', 'display_message' => ''),  
		'15008' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction has been completed,but the total of items in the cart did not match the total of all items.', 'corrective_action' => '', 'display_message' => ''),  
		
		// ***********************************************
		// Express Checkout API Errors
		// ***********************************************
		
'10001' => array('short_message' => 'ButtonSource value truncated. ', 'long_message' => 'The transaction could not be loaded', 'corrective_action' => '', 'display_message' => ''),  
'10001' => array('short_message' => 'Internal Error ', 'long_message' => 'Transaction failed due to internal error', 'corrective_action' => '', 'display_message' => ''),  
'10001' => array('short_message' => 'Internal Error ', 'long_message' => 'Warning an internal error has occurred. The transaction id may not be correct', 'corrective_action' => '', 'display_message' => ''),  
'10001' => array('short_message' => 'Internal Error ', 'long_message' => 'Internal Error', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Invalid transaction type ', 'long_message' => 'You can not get the details for this type of transaction', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'The transaction could not be loaded', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'The transaction id is not valid', 'corrective_action' => '', 'display_message' => ''),  
'10007' => array('short_message' => 'Permission denied ', 'long_message' => 'You do not have permissions to make this API call', 'corrective_action' => '10007', 'display_message' => ''),  
'10102' => array('short_message' => 'PaymentAction of Order Temporarily Unavailable ', 'long_message' => 'PaymentAction of Order is temporarily unavailable. Please try later or use other PaymentAction.', 'corrective_action' => '10102', 'display_message' => ''),  
'10103' => array('short_message' => 'Please use another Solution Type.', 'long_message' => 'Your Solution Type is temporarily unavailable. If possible,please use another Solution Type.', 'corrective_action' => '10103', 'display_message' => ''),  
'10402' => array('short_message' => 'Authorization only is not allowed for merchant.', 'long_message' => 'This merchant account is not permitted to set PaymentAction to Authorization. Please contact Customer Service.', 'corrective_action' => '', 'display_message' => ''),  
'10404' => array('short_message' => 'Invalid argument', 'long_message' => 'ReturnURL is missing.', 'corrective_action' => '', 'display_message' => ''),  
'10405' => array('short_message' => 'Invalid argument', 'long_message' => 'CancelURL is missing.', 'corrective_action' => '', 'display_message' => ''),  
'10406' => array('short_message' => 'Invalid argument', 'long_message' => 'The PayerID value is invalid.', 'corrective_action' => '', 'display_message' => ''),  
'10407' => array('short_message' => 'Invalid argument', 'long_message' => 'Invalid buyer email address (BuyerEmail).', 'corrective_action' => '', 'display_message' => ''),  
'10408' => array('short_message' => 'Express Checkout token is missing.', 'long_message' => 'Express Checkout token is missing.', 'corrective_action' => '', 'display_message' => ''),  
'10409' => array('short_message' => 'You are not authorized to access this info.', 'long_message' => 'Express Checkout token was issued for a merchant account other than yours.', 'corrective_action' => '', 'display_message' => ''),  
'10410' => array('short_message' => 'Invalid token', 'long_message' => 'Invalid token.', 'corrective_action' => '', 'display_message' => ''),  
'10411' => array('short_message' => 'This Express Checkout session has expired.', 'long_message' => 'This Express Checkout session has expired. Token value is no longer valid.', 'corrective_action' => 'If you receive this error,you must return your customer to PayPal to approve the use of PayPal again. Display an error message to inform the customer that the transaction expired,and provide a button to return to PayPal. In this situation,you are effectively restarting the entire checkout process. (Do not reuse the expired token value on <em>SetExpressCheckoutRequest</em>.) However,because you already know the final <em>OrderTotal</em> ,be sure to update the value for that element if appropriate. You might also want to update the values for <em>ReturnURL</em> and <em>CancelURL</em>,if necessary.', 'display_message' => ''),  
'10412' => array('short_message' => 'Duplicate invoice', 'long_message' => 'Payment has already been made for this InvoiceID.', 'corrective_action' => 'PayPal checks that <em>InvoiceID</em> values are unique for any particular merchant. If you send an <em>InvoiceID<em> value already associated with another transaction in the PayPal system,PayPal returns error code 10412. You might not be able to correct this error during an actual checkout. If you get this error,research why might occur and modify your implementation of Express Checkout to ensure that you generate unique invoice identification numbers.', 'display_message' => ''),  
'10413' => array('short_message' => 'Invalid argument', 'long_message' => 'The totals of the cart item amounts do not match order amounts.', 'corrective_action' => 'If you include any of the following element values with
	  <em>DoExpress Checkout Payment</em> , the sum of their values must equal the
	  value of <em>OrderTotal</em> .
	<ul>
		<li><em>ItemTotal</em></li>
		<li><em>ShippingTotal</em></li>
		<li><em>HandlingTotal</em></li>
		<li><em>TaxTotal</em> </li>
	</ul>
If you get this error, research why it might have occurred and modify your implementation of Express Checkout to ensure proper addition of the values. For the rules of this calculation, see the <em>PayPal Express Checkout Integration Guide</em>.', 'display_message' => ''),  
'10414' => array('short_message' => 'Invalid argument', 'long_message' => 'The amount exceeds the maximum amount for a single transaction.', 'corrective_action' => '', 'display_message' => ''),  
'10415' => array('short_message' => 'Invalid argument', 'long_message' => 'A successful transaction has already been completed for this token.', 'corrective_action' => 'PayPal allows a token only once for a successful transaction. Handling this error If you determine that your customers are clicking your ""Place Order"" button twice,PayPal recommends that you disable the button after your customer has clicked it.', 'display_message' => ''),  
'10416' => array('short_message' => 'Invalid argument', 'long_message' => 'You have exceeded the maximum number of payment attempts for this
	  token.', 'corrective_action' => 'You can send a maximum of 10 <em>DoExpress Checkout Payment</em> API
	  calls for any single token value, after which the token becomes invalid.', 'display_message' => ''),  
'10417' => array('short_message' => 'Transaction cannot complete.', 'long_message' => 'The transaction cannot complete successfully. Instruct the customer to
	  use an alternative payment method.', 'corrective_action' => 'It is possible that the payment method the customer chooses on PayPal might not succeed when you send <em>DoExpress Checkout Payment</em>. The most likely cause is that the customer\'s credit card failed bank authorization. Another possible, though rare, cause is that the final <em>OrderTotal</em> is significantly higher than the original estimated<em>OrderTotal</em> you sent with <em>SetExpress Checkout</em> at Integration Point 1, and the final <em>OrderTotal</em> does not pass PayPal\'s risk model analysis. If the customer has no other PayPal funding source that is likely to succeed, <em>DoExpress Checkout Payment Response</em> returns error code 10417. Instruct the customer that PayPal is unable to process the payment and redisplay alternative payment methods with which the customer can pay.', 'display_message' => ''),  
'10418' => array('short_message' => 'Invalid argument', 'long_message' => 'The currencies of the shopping cart amounts must be the same.', 'corrective_action' => '', 'display_message' => ''),  
'10419' => array('short_message' => 'Express checkout PayerID is missing.', 'long_message' => 'Express Checkout PayerID is missing.', 'corrective_action' => '', 'display_message' => ''),  
'10420' => array('short_message' => 'Invalid argument', 'long_message' => 'Express Checkout PaymentAction is missing.', 'corrective_action' => '', 'display_message' => ''),  
'10421' => array('short_message' => 'This express checkout session belongs to a different customer.', 'long_message' => 'This Express Checkout session belongs to a different customer. Token
	  value mismatch.', 'corrective_action' => 'When your customer logs into PayPal, the PayPal <em>PayerID</em> is associated with the Express Checkout token. This error is caused by mixing tokens for two different <em>PayerID</em> s. The <em>Token</em> and <em>PayerID</em> returned for any particular customer by <em>GetExpress Checkout Details Response</em> must be the same ones you send with <em>DoExpress Checkout Payment</em>.Verify that your programs are properly associating the <em>Tokens</em> and <em>PayerIDs</em>.', 'display_message' => ''),  
'10422' => array('short_message' => 'Customer must choose new funding sources.', 'long_message' => 'The customer must return to PayPal to select new funding
sources.', 'corrective_action' => 'It is possible that the payment method the customer chooses on PayPal might not succeed when you send <em>DoExpress Checkout Payment Request</em>. If the customer has a different PayPal funding source that is likely to succeed, <em>DoExpress Checkout Payment Response</em> returns error code 10422 so you can redirect the customer back to PayPal. If you receive this error message, PayPal recommends that you return your customer to PayPal to review and approve new valid funding sources. Although this error is rare, you should consider trapping the error to display a message to the customer describing what happened, along with a button or hyperlink to return to PayPal. For the rules of this calculation, see the chapter about best practices in the <em>PayPal Express Checkout Integration Guide</em>.', 'display_message' => ''),  
'10423' => array('short_message' => 'Invalid argument', 'long_message' => 'This transaction cannot be completed with PaymentAction of
	  Authorization.', 'corrective_action' => 'This error occurs if at Integration Point 1, you set <em>PaymentAction</em> to <em>Sale</em> with <em>SetExpressCheckoutRequest</em> but at Integration Point 3, you set <em>PaymentAction</em> to <em>Authorization</em> with <em>DoExpress Checkout Payment</em>. PayPal does not allow this switch from <em>Sale</em> to <em>Authorization</em> in a single checkout session. PayPal does allow the reverse, however. You can set <em>PaymentAction</em> to <em>Authorization</em> with <em>SetExpress Checkout</em> at Integration Point 1 and switch <em>PaymentAction</em> to <em>Sale</em> with <em>DoExpress Checkout Payment</em> at Integration Point 3.', 'display_message' => ''),  
'10424' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Shipping address is invalid.', 'corrective_action' => '', 'display_message' => ''),  
'10425' => array('short_message' => 'Express Checkout has been disabled for this merchant.', 'long_message' => 'Express Checkout has been disabled for this merchant.', 'corrective_action' => '', 'display_message' => ''),  
'10426' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Item total is invalid.', 'corrective_action' => '', 'display_message' => ''),  
'10427' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'Shipping total is invalid.', 'corrective_action' => '', 'display_message' => ''),  
'10428' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'Handling total is invalid.', 'corrective_action' => '', 'display_message' => ''),  
'10429' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'Tax total is invalid.', 'corrective_action' => '', 'display_message' => ''),  
'10431' => array('short_message' => 'Item amount is invalid. ', 'long_message' => 'Item amount is invalid.', 'corrective_action' => '', 'display_message' => ''),  
'10432' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'Invoice ID value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
'10433' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'Value of OrderDescription element has been truncated.', 'corrective_action' => '', 'display_message' => ''),  
'10434' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'Value of Custom element has been truncated.,Transaction refused because of an invalid argument.', 'corrective_action' => '', 'display_message' => ''),  
'10436' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'PageStyle value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
'10437' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'cpp-header-image value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
'10438' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'cpp-header-border-color value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
'10439' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'cpp-header-back-color value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
'10440' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'cpp-payflow-color value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
'10441' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'The NotifyURL element value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
'10442' => array('short_message' => 'ButtonSource value truncated. ', 'long_message' => 'The ButtonSource element value exceeds maximum allowable length.', 'corrective_action' => '', 'display_message' => ''),  
'10443' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'This transaction cannot be completed with PaymentAction of Order.', 'corrective_action' => '', 'display_message' => ''),  
'10444' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'The transaction currency specified must be the same as previously specified.', 'corrective_action' => '', 'display_message' => ''),  
'10445' => array('short_message' => 'This transaction cannot be processed at this time. Please try again later. ', 'long_message' => 'This transaction cannot be processed at this time. Please try again later.', 'corrective_action' => '', 'display_message' => ''),  
'10446' => array('short_message' => 'Unconfirmed email ', 'long_message' => 'A confirmed email is required to make this API call.', 'corrective_action' => '', 'display_message' => ''),  
'10471' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'ReturnURL: Invalid parameter', 'corrective_action' => '', 'display_message' => ''),  
'10472' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'CancelURL is invalid.', 'corrective_action' => '', 'display_message' => ''),  
'10474' => array('short_message' => 'Invalid Data', 'long_message' => 'This transaction cannot be processed. The country code in the shipping address must match the buyer\'s country of residence.', 'corrective_action' => 'The buyer selects the country of residence when they sign up for their PayPal account. The country of residence is displayed after the dash in the title on the Account Overview page.', 'display_message' => ''),  
'10537' => array('short_message' => 'Risk Control Country Filter Failure', 'long_message' => 'The transaction was refused because the country was prohibited as a result of your Country Monitor Risk Control Settings.', 'corrective_action' => '', 'display_message' => ''),  
'10538' => array('short_message' => 'Risk Control Max Amount Failure', 'corrective_action' => 'The transaction was refused because the maximum amount was excceeded as a result of your Maximum Amount Risk Control Settings.', 'corrective_action' => '', 'display_message' => ''),  
'10539' => array('short_message' => 'Payment declined by your Risk Controls settings: PayPal Risk Model. ', 'long_message' => 'Payment declined by your Risk Controls settings: PayPal Risk Model.', 'corrective_action' => '', 'display_message' => ''),  
'10725' => array('short_message' => 'Shipping Address Country Error ', 'long_message' => 'There was an error in the Shipping Address Country field', 'corrective_action' => '', 'display_message' => ''),  
'10727' => array('short_message' => 'Shipping Address1 Empty ', 'long_message' => 'The field Shipping Address1 is required', 'corrective_action' => '', 'display_message' => ''),  
'10728' => array('short_message' => 'Shipping Address City Empty ', 'long_message' => 'The field Shipping Address City is required', 'corrective_action' => '', 'display_message' => ''),  
'10729' => array('short_message' => 'Shipping Address State Empty ', 'long_message' => 'The field Shipping Address State is required', 'corrective_action' => '', 'display_message' => ''),  
'10730' => array('short_message' => 'Shipping Address Postal Code Empty ', 'long_message' => 'The field Shipping Address Postal Code is required', 'corrective_action' => '', 'display_message' => ''),  
'10731' => array('short_message' => 'Shipping Address Country Empty ', 'long_message' => 'The field Shipping Address Country is required', 'corrective_action' => '', 'display_message' => ''),  
'10736' => array('short_message' => 'Shipping Address Invalid City State Postal Code ', 'long_message' => 'A match of the Shipping Address City,State,and Postal Code failed.', 'corrective_action' => '', 'display_message' => ''),  
		
		// ***********************************************
		// RefundTransaction API Errors
		// ***********************************************
		
'10001' => array('short_message' => 'Internal Error ', 'long_message' => 'Internal Error', 'corrective_action' => '', 'display_message' => ''),  
'10001' => array('short_message' => 'Internal Error ', 'long_message' => 'Warning an internal error has occurred. The transaction id may not be correct', 'corrective_action' => '', 'display_message' => ''),  
'10001' => array('short_message' => 'ButtonSource value truncated. ', 'long_message' => 'The transaction could not be loaded', 'corrective_action' => '', 'display_message' => ''),  
'10001' => array('short_message' => 'Internal Error ', 'long_message' => 'Internal Error', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'A transaction id is required ', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'The Memo field contains invalid characters', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'The partial refund amount is not valid', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'The partial refund amount must be a positive amount ', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details.', 'long_message' => 'You can not specify a partial amount with a full refund', 'corrective_action' => '', 'display_message' => ''),  
'10004' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'Transaction class is not supported', 'corrective_action' => '', 'display_message' => ''),  
'10007' => array('short_message' => 'Permission denied', 'long_message' => 'You do not have permission to refund this transaction', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'Can not do a full refund after a partial refund', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'The account for the counterparty is locked or inactive', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'The partial refund amount is not valid', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'The partial refund amount must be less than or equal to the original transaction amount', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'The partial refund amount must be less than or equal to the remaining amount', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'The partial refund must be the same currency as the original transaction ', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'This transaction has already been fully refunded', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'You are over the time limit to perform a refund on this transaction', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'You can not do a partial refund on this transaction ', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'You can not refund this type of transaction', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused', 'long_message' => 'You do not have a verified ACH', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused ', 'long_message' => 'Because a complaint case exists on this transaction,only a refund of the full or full remaining amount of the transaction can be issued', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused ', 'long_message' => 'Account is locked or inactive', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused ', 'long_message' => 'Account is restricted', 'corrective_action' => '', 'display_message' => ''),  
'10009' => array('short_message' => 'Transaction refused ', 'long_message' => 'The account for the counterparty is locked or inactive', 'corrective_action' => '', 'display_message' => ''),  
'10011' => array('short_message' => 'Invalid transaction id value ', 'long_message' => 'Transaction refused because of an invalid transaction id value', 'corrective_action' => ''), 
'11001' => array('short_message' => 'Transaction refused because of an invalid argument. See additional error messages for details. ', 'long_message' => 'Transaction class is not supported', 'corrective_action' => '', 'display_message' => '')		
		
		// ***********************************************
		// TransactionSearch API Errors
		// ***********************************************
		
		
		// ***********************************************
		// Recurring Payments API Errors
		// ***********************************************
		
		// ***********************************************
		// MassPay API Errors
		// ***********************************************
		
		// ***********************************************
		// Reference Transaction API Errors
		// ***********************************************
		
		

	);
	
	
	


			
	// Private VARIABLES
	
	
	/****************************************************
	PayPal includes the following API Signature for making API
	calls to the PayPal sandbox:
	
	API Username 	sdk-three_api1.sdk.com
	API Password 	QFZCWN5HZM8VBG7Q
	API Signature 	A-IzJhZZjhg29XQ2qnhapuwxIDzyAZQ92FRP5dqBzVesOkzbdUONzmOU
	****************************************************/
	
	/**
	# API user: The user that is identified as making the call. you can
	# also use your own API username that you created on PayPal’s sandbox
	# or the PayPal live site
	*/
	
	//	LIVE
	private $API_USERNAME = 'store_api1.yipmedia.com';
	//	SANDBOX
	// private $API_USERNAME = 'store_api1.yipmedia.com';
	
	/**
	# API_password: The password associated with the API user
	# If you are using your own API username, enter the API password that
	# was generated by PayPal below
	# IMPORTANT - HAVING YOUR API PASSWORD INCLUDED IN THE MANNER IS NOT
	# SECURE, AND ITS ONLY BEING SHOWN THIS WAY FOR TESTING PURPOSES
	*/
	
	//	LIVE
	private $API_PASSWORD = 'XQ29YUPEA3R68SB2';
	//	SANDBOX
	// private $API_PASSWORD = 'XQ29YUPEA3R68SB2';
	
	/**
	# API_Signature:The Signature associated with the API user. which is generated by paypal.
	*/
	
	//	LIVE
	private $API_SIGNATURE = 'AOF4dZz.f4fo3FSyopw-i3Ein-zNATgTRAv-taM5osM7XfOi2C00fg21';
	//	SANDBOX
	// private $API_SIGNATURE = 'AOF4dZz.f4fo3FSyopw-i3Ein-zNATgTRAv-taM5osM7XfOi2C00fg21';
	
	/**
	# Endpoint: this is the server URL which you have to connect for submitting your API request.
	*/
	
	//	LIVE
	private $API_ENDPOINT = 'https://api-3t.sandbox.paypal.com/nvp';
	//	SANDBOX
	//private $API_ENDPOINT = 'https://api-3t.sandbox.paypal.com/nvp';
	
	/**
	USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.
	like define('USE_PROXY',TRUE);
	
	We don't appear to be using this in phpPayPal
	*/
	private $USE_PROXY = FALSE;
	/**
	PROXY_HOST: Set the host name or the IP address of proxy server.
	PROXY_PORT: Set proxy port.
	
	PROXY_HOST and PROXY_PORT will be read only if USE_PROXY is set to TRUE
	*/
	private $PROXY_HOST = '127.0.0.1';
	private $PROXY_PORT = '808';
	
	/* Define the PayPal URL. This is the URL that the buyer is
	   first sent to to authorize payment with their paypal account
	   change the URL depending if you are testing on the sandbox
	   or going to the live PayPal site
	   For the sandbox, the URL is
	   https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
	   For the live site, the URL is
	   https://www.paypal.com/webscr&cmd=_express-checkout&token=
	   */
	//	LIVE
	private $PAYPAL_URL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
	//	SANDBOX
	// private $PAYPAL_URL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
	
	/* Define the Reutrn and Cancel URLs. 
	   The returnURL is the location where buyers return when a
	   payment has been succesfully authorized.
	   The cancelURL is the location buyers are sent to when they hit the
	   cancel button during authorization of payment during the PayPal flow
	   */
	private $RETURN_URL = 'http://www.hihowareyou.com/store2/receiver.php';
	private $CANCEL_URL = 'http://www.hihowareyou.com/store2/backend';
	
	/**
	# Version: this is the API version in the request.
	# It is a mandatory parameter for each API request.
	# The only supported value at this time is 2.3
	*/
	
	private $VERSION = '3.0';
	
	
	
	
	
	
	
	// CONSTRUCT
	function __construct()
		{ }	
	
	
	
	
	
	
	public function DoDirectPayment()
		{
		// urlencode the needed variables
		$this->urlencodeVariables();
		
		/* Construct the request string that will be sent to PayPal.
		   The variable $nvpstr contains all the variables and is a
		   name value pair string with & as a delimiter */
		$nvpstr = $this->generateNVPString('DoDirectPayment');
		
		/* Construct and add any items found in this instance */
		if(!empty($this->ItemsArray))
			{
			// Counter for the total of all the items put together
			$total_items_amount = 0;
			// Go through the items array
			foreach($this->ItemsArray as $key => $value)
				{
				// Get the array of the current item from the main array
				$current_item = $this->ItemsArray[$key];
				// Add it to the request string
				$nvpstr .= "&L_NAME".$key."=".$current_item['name'].
							"&L_NUMBER".$key."=".$current_item['number'].
							"&L_QTY".$key."=".$current_item['quantity'].
							"&L_TAXAMT".$key."=".$current_item['amount_tax'].
							"&L_AMT".$key."=".$current_item['amount'];
				// Add this item's amount to the total current count
				$total_items_amount += ($current_item['amount'] * $current_item['quantity']);
				}
			// Set the amount_items for this instance and ITEMAMT added to the request string
			$this->amount_items = $total_items_amount;
			$nvpstr .= "&ITEMAMT=".urlencode($total_items_amount);
			}
		
		// decode the variables incase we still require access to them in our program
		$this->urldecodeVariables();
		
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $this->Response */
		$this->Response = $this->hash_call("DoDirectPayment", $nvpstr);
		
		// TODO: Add error handling for the hash_call
		
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		
		/*
			*************
			if NO SUCCESS
			*************
			*/
		if(strtoupper($this->Response["ACK"]) != "SUCCESS" AND strtoupper($this->Response["ACK"]) != "SUCCESSWITHWARNING")
			{
			$this->Error['TIMESTAMP']		= @$this->Response['TIMESTAMP'];
			$this->Error['CORRELATIONID']	= @$this->Response['CORRELATIONID'];
			$this->Error['ACK']				= $this->Response['ACK'];
			$this->Error['ERRORCODE']		= $this->Response['L_ERRORCODE0'];
			$this->Error['SHORTMESSAGE']	= $this->Response['L_SHORTMESSAGE0'];
			$this->Error['LONGMESSAGE']		= $this->Response['L_LONGMESSAGE0'];
			$this->Error['SEVERITYCODE']	= $this->Response['L_SEVERITYCODE0'];
			$this->Error['VERSION']			= @$this->Response['VERSION'];
			$this->Error['BUILD']			= @$this->Response['BUILD'];
			
			// TODO: Error codes for AVSCODE and CVV@MATCH
			
			$this->_error				= true;
			$this->_error_ack			= $this->Response['ACK'];
			$this->ack					= 'Failure';
			$this->_error_type			= 'paypal';
			$this->_error_date			= $this->Response['TIMESTAMP'];
			$this->_error_code			= $this->Response['L_ERRORCODE0'];
			$this->_error_short_message	= $this->Response['L_SHORTMESSAGE0'];
			$this->_error_long_message	= $this->Response['L_LONGMESSAGE0'];
			$this->_error_severity_code	= $this->Response['L_SEVERITYCODE0'];
			$this->_error_version		= @$this->Response['VERSION'];
			$this->_error_build			= @$this->Response['BUILD']; 
			
			return false;
			}
			/*
			*************
			if SUCCESS
			*************
			*/
		elseif(strtoupper($this->Response["ACK"]) == 'SUCCESS' OR strtoupper($this->Response["ACK"]) == 'SUCCESSWITHWARNING')
			{
			/*
			Take the response variables and put them into the local class variables
			*/
			foreach($this->ResponseFieldsArray['DoDirectPayment'] as $key => $value)
				$this->$key = $this->Response[$value];
			
			return true;
			}
		}
	
	
	
	
	
	function SetExpressCheckout()
		{
		// TODO: Add error handling prior to trying to make PayPal calls. ie: missing amount_total or RETURN_URL
		
		// urlencode the needed variables
		$this->urlencodeVariables();
		
		/* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
		$nvpstr = $this->generateNVPString('SetExpressCheckout');
				
		// decode the variables incase we still require access to them in our program
		$this->urldecodeVariables();
		
		/* Make the call to PayPal to set the Express Checkout token
			If the API call succeded, then redirect the buyer to PayPal
			to begin to authorize payment.  If an error occured, show the
			resulting errors
			*/
		$this->Response = $this->hash_call("SetExpressCheckout", $nvpstr);
		
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */		
		/*
			*************
			if NO SUCCESS
			*************
			*/
		if(strtoupper($this->Response["ACK"]) != "SUCCESS")
			{
			$this->Error['TIMESTAMP']		= @$this->Response['TIMESTAMP'];
			$this->Error['CORRELATIONID']	= @$this->Response['CORRELATIONID'];
			$this->Error['ACK']				= $this->Response['ACK'];
			$this->Error['ERRORCODE']		= $this->Response['L_ERRORCODE0'];
			$this->Error['SHORTMESSAGE']	= $this->Response['L_SHORTMESSAGE0'];
			$this->Error['LONGMESSAGE']		= $this->Response['L_LONGMESSAGE0'];
			$this->Error['SEVERITYCODE']	= $this->Response['L_SEVERITYCODE0'];
			$this->Error['VERSION']			= @$this->Response['VERSION'];
			$this->Error['BUILD']			= @$this->Response['BUILD'];
			
			$this->_error				= true;
			$this->_error_ack			= $this->Response['ACK'];
			$this->ack					= 'Failure';
			$this->_error_type			= 'paypal';
			$this->_error_date			= $this->Response['TIMESTAMP'];
			$this->_error_code			= $this->Response['L_ERRORCODE0'];
			$this->_error_short_message	= $this->Response['L_SHORTMESSAGE0'];
			$this->_error_long_message	= $this->Response['L_LONGMESSAGE0'];
			$this->_error_severity_code	= $this->Response['L_SEVERITYCODE0'];
			$this->_error_version		= @$this->Response['VERSION'];
			$this->_error_build			= @$this->Response['BUILD']; 
			
			return false;
			/*
			$_SESSION['reshash']=$this->Response;
			$location = "APIError.php";
			header("Location: $location");
			*/
			}
		/*
			*************
			if SUCCESS
			*************
			*/
		elseif(strtoupper($this->Response["ACK"]) == 'SUCCESS')
			{
			/*
			Take the response variables and put them into the local class variables
			*/
			foreach($this->ResponseFieldsArray['SetExpressCheckout'] as $key => $value)
				$this->$key = $this->Response[$value];
			
			return true;
			}
		}
	
	function SetExpressCheckoutSuccessfulRedirect()
		{
		// Redirect to paypal.com here
		$token = urlencode($this->Response["TOKEN"]);
		$paypal_url = $this->PAYPAL_URL.$token;
		header("Location: ".$paypal_url);
		}
	
	
	
	
	function GetExpressCheckoutDetails()
		{
		// TODO: Add error handling prior to PayPal calls. ie: missing TOKEN
		
		/* At this point, the buyer has completed in authorizing payment
			at PayPal.  The script will now call PayPal with the details
			of the authorization, incuding any shipping information of the
			buyer.  Remember, the authorization is not a completed transaction
			at this state - the buyer still needs an additional step to finalize
			the transaction
			*/

		 /* Build a second API request to PayPal, using the token as the
			ID to get the details on the payment authorization
			*/
		/* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
		$nvpstr = $this->generateNVPString('GetExpressCheckoutDetails');

		 /* Make the API call and store the results in an array.  If the
			call was a success, show the authorization details, and provide
			an action to complete the payment.  If failed, show the error
			*/
		$this->Response = $this->hash_call("GetExpressCheckoutDetails", $nvpstr);
		
		/*
			*************
			if NO SUCCESS
			*************
			*/
		if(strtoupper($this->Response["ACK"]) != "SUCCESS")
			{
			$this->Error['TIMESTAMP']		= @$this->Response['TIMESTAMP'];
			$this->Error['CORRELATIONID']	= @$this->Response['CORRELATIONID'];
			$this->Error['ACK']				= $this->Response['ACK'];
			$this->Error['ERRORCODE']		= $this->Response['L_ERRORCODE0'];
			$this->Error['SHORTMESSAGE']	= $this->Response['L_SHORTMESSAGE0'];
			$this->Error['LONGMESSAGE']		= $this->Response['L_LONGMESSAGE0'];
			$this->Error['SEVERITYCODE']	= $this->Response['L_SEVERITYCODE0'];
			$this->Error['VERSION']			= @$this->Response['VERSION'];
			$this->Error['BUILD']			= @$this->Response['BUILD'];
			
			$this->_error				= true;
			$this->_error_ack			= $this->Response['ACK'];
			$this->ack					= 'Failure';
			$this->_error_type			= 'paypal';
			$this->_error_date			= $this->Response['TIMESTAMP'];
			$this->_error_code			= $this->Response['L_ERRORCODE0'];
			$this->_error_short_message	= $this->Response['L_SHORTMESSAGE0'];
			$this->_error_long_message	= $this->Response['L_LONGMESSAGE0'];
			$this->_error_severity_code	= $this->Response['L_SEVERITYCODE0'];
			$this->_error_version		= @$this->Response['VERSION'];
			$this->_error_build			= @$this->Response['BUILD']; 
			
			return false;
			/*
			$_SESSION['reshash']=$this->Response;
			$location = "APIError.php";
			header("Location: $location");
			*/
			}
		/*
			***********
			if SUCCESS
			***********
			*/
		elseif(strtoupper($this->Response["ACK"]) == 'SUCCESS')
			{
			/*
			Take the response variables and put them into the local class variables
			*/
			foreach($this->ResponseFieldsArray['GetExpressCheckoutDetails'] as $key => $value)
				$this->$key = $this->Response[$value];
			
			return true;
			}
		
		}
	
	
	
	
	function DoExpressCheckoutPayment()
		{
		// TODO: Error checking. ie: we require a token and payer_id here
		
		// urlencode the needed variables
		$this->urlencodeVariables();
		
		/* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
		$nvpstr = $this->generateNVPString('DoExpressCheckoutPayment');
		
		/* Construct and add any items found in this instance */
		if(!empty($this->ItemsArray))
			{
			// Counter for the total of all the items put together
			$total_items_amount = 0;
			// Go through the items array
			foreach($this->ItemsArray as $key => $value)
				{
				// Get the array of the current item from the main array
				$current_item = $this->ItemsArray[$key];
				// Add it to the request string
				$nvpstr .= "&L_NAME".$key."=".$current_item['name'].
							"&L_NUMBER".$key."=".$current_item['number'].
							"&L_QTY".$key."=".$current_item['quantity'].
							"&L_TAXAMT".$key."=".$current_item['amount_tax'].
							"&L_AMT".$key."=".$current_item['amount'];
				// Add this item's amount to the total current count
				$total_items_amount += ($current_item['amount'] * $current_item['quantity']);
				}
			// Set the amount_items for this instance and ITEMAMT added to the request string
			$this->amount_items = $total_items_amount;
			$nvpstr .= "&ITEMAMT=".$total_items_amount;
			}

		 /* Make the call to PayPal to finalize payment
			If an error occured, show the resulting errors
			*/
		$this->Response = $this->hash_call("DoExpressCheckoutPayment", $nvpstr);
		
		// decode the variables incase we still require access to them in our program
		$this->urldecodeVariables();
		
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		
		/*
			*************
			if NO SUCCESS
			*************
			*/
		if(strtoupper($this->Response["ACK"]) != "SUCCESS")
			{
			$this->Error['TIMESTAMP']		= @$this->Response['TIMESTAMP'];
			$this->Error['CORRELATIONID']	= @$this->Response['CORRELATIONID'];
			$this->Error['ACK']				= $this->Response['ACK'];
			$this->Error['ERRORCODE']		= $this->Response['L_ERRORCODE0'];
			$this->Error['SHORTMESSAGE']	= $this->Response['L_SHORTMESSAGE0'];
			$this->Error['LONGMESSAGE']		= $this->Response['L_LONGMESSAGE0'];
			$this->Error['SEVERITYCODE']	= $this->Response['L_SEVERITYCODE0'];
			$this->Error['VERSION']			= @$this->Response['VERSION'];
			$this->Error['BUILD']			= @$this->Response['BUILD'];
			
			$this->_error				= true;
			$this->_error_ack			= $this->Response['ACK'];
			$this->ack					= 'Failure';
			$this->_error_type			= 'paypal';
			$this->_error_date			= $this->Response['TIMESTAMP'];
			$this->_error_code			= $this->Response['L_ERRORCODE0'];
			$this->_error_short_message	= $this->Response['L_SHORTMESSAGE0'];
			$this->_error_long_message	= $this->Response['L_LONGMESSAGE0'];
			$this->_error_severity_code	= $this->Response['L_SEVERITYCODE0'];
			$this->_error_version		= @$this->Response['VERSION'];
			$this->_error_build			= @$this->Response['BUILD']; 
			
			return false;
			/*
			$_SESSION['reshash']=$this->Response;
			$location = "APIError.php";
			header("Location: $location");
			*/
			}
		/*
			*************
			if SUCCESS
			*************
			*/
		elseif(strtoupper($this->Response["ACK"]) == 'SUCCESS')
			{
			/*
			Take the response variables and put them into the local class variables
			*/
			foreach($this->ResponseFieldsArray['DoExpressCheckoutPayment'] as $key => $value)
				$this->$key = $this->Response[$value];
			
			return true;
			}
		}
	
	
	
	
	function GetTransactionDetails()
		{
		/* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
		$nvpstr = $this->generateNVPString('GetTransactionDetails');
		
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		$this->Response = $this->hash_call("GetTransactionDetails", $nvpstr);
		
		/* Next, collect the API request in the associative array $reqArray
		   as well to display back to the browser.
		   Normally you wouldnt not need to do this, but its shown for testing */
		
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		
		/*
			*************
			if NO SUCCESS
			*************
			*/
		if(strtoupper($this->Response["ACK"]) != "SUCCESS")
			{
			$this->Error['TIMESTAMP']		= @$this->Response['TIMESTAMP'];
			$this->Error['CORRELATIONID']	= @$this->Response['CORRELATIONID'];
			$this->Error['ACK']				= $this->Response['ACK'];
			$this->Error['ERRORCODE']		= $this->Response['L_ERRORCODE0'];
			$this->Error['SHORTMESSAGE']	= $this->Response['L_SHORTMESSAGE0'];
			$this->Error['LONGMESSAGE']		= $this->Response['L_LONGMESSAGE0'];
			$this->Error['SEVERITYCODE']	= $this->Response['L_SEVERITYCODE0'];
			$this->Error['VERSION']			= @$this->Response['VERSION'];
			$this->Error['BUILD']			= @$this->Response['BUILD'];
			
			$this->_error				= true;
			$this->_error_ack			= $this->Response['ACK'];
			$this->ack					= 'Failure';
			$this->_error_type			= 'paypal';
			$this->_error_date			= $this->Response['TIMESTAMP'];
			$this->_error_code			= $this->Response['L_ERRORCODE0'];
			$this->_error_short_message	= $this->Response['L_SHORTMESSAGE0'];
			$this->_error_long_message	= $this->Response['L_LONGMESSAGE0'];
			$this->_error_severity_code	= $this->Response['L_SEVERITYCODE0'];
			$this->_error_version		= @$this->Response['VERSION'];
			$this->_error_build			= @$this->Response['BUILD']; 
			
			return false;
			/*
			$_SESSION['reshash']=$this->Response;
			$location = "APIError.php";
			header("Location: $location");
			*/
			}
		/*
			*************
			if SUCCESS
			*************
			*/
		elseif(strtoupper($this->Response["ACK"]) == 'SUCCESS')
			{
			/*
			Take the response variables and put them into the local class variables
			*/
			foreach($this->ResponseFieldsArray['GetTransactionDetails'] as $key => $value)
				$this->$key = $this->Response[$value];
			
			$this->getItems($this->Response);
			
			return true;
			}
		}
	
	
	
	
	function RefundTransaction()
		{
		/* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
		$nvpstr = $this->generateNVPString('RefundTransaction');
		
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		$this->Response = $this->hash_call("RefundTransaction", $nvpstr);
		
		/* Next, collect the API request in the associative array $reqArray
		   as well to display back to the browser.
		   Normally you wouldnt not need to do this, but its shown for testing */
		
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		
		/*
			*************
			if NO SUCCESS
			*************
			*/
		if(strtoupper($this->Response["ACK"]) != "SUCCESS")
			{
			$this->Error['TIMESTAMP']		= @$this->Response['TIMESTAMP'];
			$this->Error['CORRELATIONID']	= @$this->Response['CORRELATIONID'];
			$this->Error['ACK']				= $this->Response['ACK'];
			$this->Error['ERRORCODE']		= $this->Response['L_ERRORCODE0'];
			$this->Error['SHORTMESSAGE']	= $this->Response['L_SHORTMESSAGE0'];
			$this->Error['LONGMESSAGE']		= $this->Response['L_LONGMESSAGE0'];
			$this->Error['SEVERITYCODE']	= $this->Response['L_SEVERITYCODE0'];
			$this->Error['VERSION']			= @$this->Response['VERSION'];
			$this->Error['BUILD']			= @$this->Response['BUILD'];
			
			$this->_error				= true;
			$this->_error_ack			= $this->Response['ACK'];
			$this->ack					= 'Failure';
			$this->_error_type			= 'paypal';
			$this->_error_date			= $this->Response['TIMESTAMP'];
			$this->_error_code			= $this->Response['L_ERRORCODE0'];
			$this->_error_short_message	= $this->Response['L_SHORTMESSAGE0'];
			$this->_error_long_message	= $this->Response['L_LONGMESSAGE0'];
			$this->_error_severity_code	= $this->Response['L_SEVERITYCODE0'];
			$this->_error_version		= @$this->Response['VERSION'];
			$this->_error_build			= @$this->Response['BUILD']; 
			
			return false;
			/*
			$_SESSION['reshash']=$this->Response;
			$location = "APIError.php";
			header("Location: $location");
			*/
			}
		/*
			*************
			if SUCCESS
			*************
			*/
		elseif(strtoupper($this->Response["ACK"]) == 'SUCCESS')
			{
			/*
			Take the response variables and put them into the local class variables
			*/
			foreach($this->ResponseFieldsArray['RefundTransaction'] as $key => $value)
				$this->$key = $this->Response[$value];
			
			$this->getItems($this->Response);
			
			return true;
			}
		}
	
	

	
		
	/**
	  * hash_call: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
	  * returns an associtive array containing the response from the server.
	*/
	private function hash_call($methodName, $nvpStr)
		{
		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		if($this->USE_PROXY)
			curl_setopt ($ch, CURLOPT_PROXY, $this->PROXY_HOST.":".$this->PROXY_PORT); 
	
		//NVPRequest for submitting to server
		$nvpreq = "METHOD=".urlencode($methodName)."&VERSION=".urlencode($this->VERSION)."&PWD=".urlencode($this->API_PASSWORD).
				"&USER=".urlencode($this->API_USERNAME)."&SIGNATURE=".urlencode($this->API_SIGNATURE).$nvpStr;
		
		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);
	
		//getting response from server
		$response = curl_exec($ch);
	
		//convrting NVPResponse to an Associative Array
		$nvpResArray = $this->deformatNVP($response);
		$nvpReqArray = $this->deformatNVP($nvpreq);
		$_SESSION['nvpReqArray'] = $nvpReqArray;
		
		/*
			*************
			if NO SUCCESS
			*************
			*/
		if (curl_errno($ch)) 
			{
			// moving to display page to display curl errors

			$_SESSION['curl_error_no'] = curl_errno($ch) ;
			$_SESSION['curl_error_msg'] = curl_error($ch);
			// TEMP
			/*echo '<pre>';
			echo $nvpreq.'<br>';
			echo curl_error($ch);
			echo curl_errno($ch);
			exit; */
			// /TEMP
			$location = "APIError.php";
			header("Location: $location");
			} 
		/*
			*************
			if SUCCESS
			*************
			*/
		else 
			{
			//closing the curl
			curl_close($ch);
			}
		
		return $nvpResArray;
		}
		
		
		
		/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
		  * It is usefull to search for a particular key and displaying arrays.
		  * @nvpstr is NVPString.
		  * @nvpArray is Associative Array.
		  */
		private function deformatNVP($nvpstr)
			{
			$intial=0;
			$nvpArray = array();
			
			while(strlen($nvpstr))
				{
				//postion of Key
				$keypos= strpos($nvpstr,'=');
				//position of value
				$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
		
				/*getting the Key and Value values and storing in a Associative Array*/
				$keyval=substr($nvpstr,$intial,$keypos);
				$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
				//decoding the respose
				$nvpArray[urldecode($keyval)] =urldecode( $valval);
				$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
				}
				
			return $nvpArray;
			}
		
		
		
		
		/** This function will add an item to the itemArray for use in doDirectPayment and doExpressCheckoutPayment
		  */
		public function addItem($name, $number, $quantity, $amount_tax, $amount)
			{
			$new_item =  array(
					'name' => $name, 
					'number' => $number, 
					'quantity' => $quantity, 
					'amount_tax' => $amount_tax, 
					'amount' => $amount);
			
			$this->ItemsArray[] = $new_item;
			
			// TODO: Should recalculate and set $this->amount_items after every new item is added. Or is this done on each request?
			}
		
		
		
		private function getItems($passed_response)
			{
			// Clear any current items
			$this->ItemsArray = '';
			
			// Get the items if there are any
			// Start this off by checking for a first item
			if(!empty($passed_response['L_NAME0']) OR !empty($passed_response['L_NUMBER0']) OR !empty($passed_response['L_QTY0']))
				{
				$i = 0;
				// Start a loop to get all the items (up to 200)
				// We'll break out of it if we stop finding items
				while($i < 200)
					{
					// One of the Name, Number, and Qty fields may be empty, so check all of them
					//   and if any of them are filled, then we have an item
					if(!empty($passed_response['L_NAME'.$i]) OR !empty($passed_response['L_NUMBER'.$i]) OR !empty($passed_response['L_QTY'.$i]))
						{
						$new_item =  array(
								'name' => $passed_response['L_NAME'.$i], 
								'number' => $passed_response['L_NUMBER'.$i], 
								'quantity' => $passed_response['L_QTY'.$i], 
								'amount_tax' => $passed_response['L_TAXAMT'.$i], 
								'amount' => $passed_response['L_AMT'.$i]);
						
						$this->ItemsArray[] = $new_item;
						$i++;
						}
					else
						break;
					}
				}
			}
		
		
		
		private function generateNVPString($type)
			{
			$temp_nvp_str = '';
			// Go through the selected RequestFieldsArray and create the request string
			//    based on whether the field is required or filled
			// TODO: return error if required field is empty?
			foreach($this->RequestFieldsArray[$type] as $key => $value)
				{
				if($value['required'] == 'yes')
					$temp_nvp_str .= '&'.$value['name'].'='.$this->$key;
				elseif(!empty($this->$key))
					$temp_nvp_str .= '&'.$value['name'].'='.$this->$key;
				}
			return $temp_nvp_str;
			}
		
		
		
		/** This function encodes all applicable variables for transport to PayPal
		  */
		private function urlencodeVariables()
			{
			// Decode all specified variables
			$this->payment_type			= urlencode($this->payment_type);
			
			$this->email		= urlencode($this->email);
			$this->first_name			= urlencode($this->first_name);
			$this->last_name			= urlencode($this->last_name);
			$this->credit_card_type		= urlencode($this->credit_card_type);
			$this->credit_card_number	= urlencode($this->credit_card_number);
			$this->expire_date_month		= urlencode($this->expire_date_month);
			
			// Month must be padded with leading zero
			$this->expire_date_month	= urlencode(str_pad($this->expire_date_month, 2, '0', STR_PAD_LEFT));
			
			$this->expire_date_year	= urlencode($this->expire_date_year);
			$this->cvv2_code		= urlencode($this->cvv2_code);
			$this->address1			= urlencode($this->address1);
			$this->address2			= urlencode($this->address2);
			$this->city				= urlencode($this->city);
			$this->state			= urlencode($this->state);
			$this->postal_code		= urlencode($this->postal_code);
			$this->country_code		= urlencode($this->country_code);
			
			$this->currency_code	= urlencode($this->currency_code);
			$this->ip_address		= urlencode($this->ip_address);
			
			$this->shipping_name			= urlencode($this->shipping_name);
			$this->shipping_address1		= urlencode($this->shipping_address1);
			$this->shipping_address2		= urlencode($this->shipping_address2);
			$this->shipping_city			= urlencode($this->shipping_city);
			$this->shipping_state			= urlencode($this->shipping_state);
			$this->shipping_postal_code		= urlencode($this->shipping_postal_code);
			$this->shipping_country_code	= urlencode($this->shipping_country_code);
			$this->shipping_phone_number			= urlencode($this->shipping_phone_number);
			
			$this->amount_total		= urlencode($this->amount_total);
			$this->amount_shipping	= urlencode($this->amount_shipping);
			$this->amount_tax		= urlencode($this->amount_tax);
			$this->amount_handling	= urlencode($this->amount_handling);
			$this->amount_items		= urlencode($this->amount_items);
			
			$this->token		= urlencode($this->token);
			$this->payer_id		= urlencode($this->payer_id);
			
	
			if(!empty($this->ItemsArray))
				{
				// Go through the items array
				foreach($this->ItemsArray as $key => $value)
					{
					// Get the array of the current item from the main array
					$current_item = $this->ItemsArray[$key];
					// Encode everything
					// TODO: use a foreach loop instead
					$current_item['name'] = urlencode($current_item['name']);
					$current_item['number'] = urlencode($current_item['number']);
					$current_item['quantity'] = urlencode($current_item['quantity']);
					$current_item['amount_tax'] = urlencode($current_item['amount_tax']);
					$current_item['amount'] = urlencode($current_item['amount']);
					// Put the encoded array back in the item array (replaces previous array)
					$this->ItemsArray[$key] = $current_item;
					}
				}
			}
		
		/** This function DEcodes all applicable variables for use in application/database
		  */
		private function urldecodeVariables()
			{
			// Decode all specified variables
			$this->payment_type			= urldecode($this->payment_type);
			
			$this->email		= urldecode($this->email);
			$this->first_name			= urldecode($this->first_name);
			$this->last_name			= urldecode($this->last_name);
			$this->credit_card_type		= urldecode($this->credit_card_type);
			$this->credit_card_number	= urldecode($this->credit_card_number);
			$this->expire_date_month		= urldecode($this->expire_date_month);
			
			// Month must be padded with leading zero
			$this->expire_date_month	= urldecode(str_pad($this->expire_date_month, 2, '0', STR_PAD_LEFT));
			
			$this->expire_date_year	= urldecode($this->expire_date_year);
			$this->cvv2_code		= urldecode($this->cvv2_code);
			$this->address1			= urldecode($this->address1);
			$this->address2			= urldecode($this->address2);
			$this->city				= urldecode($this->city);
			$this->state			= urldecode($this->state);
			$this->postal_code		= urldecode($this->postal_code);
			$this->country_code		= urldecode($this->country_code);
			
			$this->currency_code	= urldecode($this->currency_code);
			$this->ip_address		= urldecode($this->ip_address);
			
			$this->shipping_name				= urldecode($this->shipping_name);
			$this->shipping_address1			= urldecode($this->shipping_address1);
			$this->shipping_address2			= urldecode($this->shipping_address2);
			$this->shipping_city				= urldecode($this->shipping_city);
			$this->shipping_state				= urldecode($this->shipping_state);
			$this->shipping_postal_code			= urldecode($this->shipping_postal_code);
			$this->shipping_country_code		= urldecode($this->shipping_country_code);
			$this->shipping_phone_number	= urldecode($this->shipping_phone_number);
			
			$this->amount_total		= urldecode($this->amount_total);
			$this->amount_shipping	= urldecode($this->amount_shipping);
			$this->amount_tax		= urldecode($this->amount_tax);
			$this->amount_handling	= urldecode($this->amount_handling);
			$this->amount_items		= urldecode($this->amount_items);
			
			$this->token		= urldecode($this->token);
			$this->payer_id		= urldecode($this->payer_id);
			
			
			if(!empty($this->ItemsArray))
				{
				// Go through the items array
				foreach($this->ItemsArray as $key => $value)
					{
					// Get the array of the current item from the main array
					$current_item = $this->ItemsArray[$key];
					// Decode everything
					// TODO: use a foreach loop instead
					$current_item['name'] = urldecode($current_item['name']);
					$current_item['number'] = urldecode($current_item['number']);
					$current_item['quantity'] = urldecode($current_item['quantity']);
					$current_item['amount_tax'] = urldecode($current_item['amount_tax']);
					$current_item['amount'] = urldecode($current_item['amount']);
					// Put the decoded array back in the item array (replaces previous array)
					$this->ItemsArray[$key] = $current_item;
					}
				}
			}




// END CLASS
}




?>