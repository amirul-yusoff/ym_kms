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
JMS ID: {{$jms['id']}}
<br/>
JMS Submission Date: {{$jms['submissionDate']}}
<br/>
Work Order Number: <b>{{$jms['woNumber']}}</b>
<br/>
Major Item: <b>{{$jms['majorItem']}}</b>
<br/>
JMS Submission: <b>{{$jms['status']}}</b>
<br/>
Reason: <b>{{$jms['reason']}}</b>
<br/>
@if($jms['status'] == 'Rejected')
Please resubmit your JMS with required supporting documents.
@else
   Our Project Engineer will send you an Interim Payment Certificate within 3 business days, please proceed to submit your invoice as per the payment certificate details.
@endif
<br/><br/>
Thank you 
</td>
</tr>
</table>
</body>
</html>
