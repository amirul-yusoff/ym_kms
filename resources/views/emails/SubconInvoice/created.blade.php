<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.footer {
width: 100% !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="left">
Hi {{$subconInvoice['Vendor']}}, <br>
This email is sent in acknowledgement of receiving your invoice as per the following details:
<br/>
Invoice ID: {{$subconInvoice['CreditorInvoiceID']}}
<br/>
Invoice Submission Date: <b>{{$subconInvoice['DateReceived']->format('d-m-Y')}}</b>
<br/>
<b>*Note the payment term date calculation begins from the cut-off date (16th & 30th) + 45 days when we receive your ORIGINAL hard copy invoice.</b>
<br/>
Your Invoice Number: {{$subconInvoice['InvoiceNum']}}
<br/>
Invoice Date: {{$subconInvoice['CreditorInvoiceDate']->format('d-m-Y')}}
<br/>
Amount: {{$subconInvoice['InvAmount']}}
<br/>
Work Order Number: <b>{{$subconInvoice['WorkOrderNumber']}}</b>
<br/>
Your invoice has been received as per above, and will be processed accordingly, you will receive another email to notify you of the updates
<br/><br/>
Thank you 
</td>
</tr>
</table>
</body>
</html>
