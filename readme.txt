

Version 0.7

 SHOW STOPPERS
	- I change $invoice to $invoice_number to be more consistent with PayPal terminology.  If you use this field, please be sure to update your code!
	- expire_date is in MMYYYY format
 
 CHANGES
	- Moved API credentials up to the top and simplified.
	- Updated license
	- Added get transaction details function
	- Added refund transaction function
	- Added create, update, get recurring payments
	- Lots of code clean-up