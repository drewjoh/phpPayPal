

Version 0.6

 SHOW STOPPERS
  - I change $invoice to $invoice_number to be more consistent with PayPal terminology.  
    If you use this field, please be sure to update your code!
 
 CHANGES
  - I added a $return_fmf_details variable to enable the returning of the results returned 
    by Fraud Management Filters.  The information is only available in the raw $Response array.
  - I changed the $CANCEL_URL and $RETURN_URL strings to be public and lowercase.