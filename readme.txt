phpPayPal
=======================

PHP class to help make the interaction between your web app and PayPal easy.  Current supported functions are:

    * DoDirectPayment
    * SetExpressCheckout
    * GetExpressCheckoutDetails
    * DoExpressCheckoutPayment
    * GetTransactionDetails
    * RefundTransaction
    * DoAuthorization
    * DoCapture
    * DoReauthorization
    * DoVoid
    * CreateRecurringPaymentsProfile
    * GetRecurringPaymentsProfileDetails
    * UpdateRecurringPaymentsProfile
    * DoReferenceTransaction


Version 0.85
---------------------
	- Added do_reference_transaction() function
	- Changed "CL_ID" to "profile_reference" as it should have been.
	- Changed "multiitem" to "multi_item"
	- Some formatting updates
	- Fixed misspelling of "profile_reference"
	- Moved API credentials to the __construct()

Version 0.8
---------------------
	NOTE: v0.8 changed function names from ThisFormat() to this_format() to keep in line with common PHP programming techniques.  If your app was written for an earlier version, stick with v0.7, as they are currently identical except for the function name formatting.
	
Version 0.7
---------------------
	- I changed $invoice to $invoice_number to be more consistent with PayPal terminology.  If you use this field, please be sure to update your code!
	- expire_date is in MMYYYY format
	- Added create_recurring_payments_profile() function
	- Added update_recurring_payments_profile() function
	- Added get_recurring_payments_profile_details() function
	


Licensed under the Apache License, Version 2.0