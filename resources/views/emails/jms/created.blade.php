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
This email is sent in acknowledgement of receiving your JMS submission as per the following details:
<br/>
JMS ID: {{$jms['id']}}
<br/>
JMS Submission Date: {{$jms['submissionDate']}}
<br/>
Work Order Number: <b>{{$jms['woNumber']}}</b>
<br/>
Major Item: <b>{{$jms['majorItem']}}</b>
<br/>
JMS approval/rejection to be completed by: <b>{{$jms['reviewByPEDate']}}</b>
<br/>
You will receive a new email notification upon approval or rejection of your JMS submission.
<br/>
If your JMS is Approved, our Project Engineer will issue a Interim Payment Certificate to you within 3 business days and you can proceed with invoice submission in the system.
<br/>
Rejected submission will be notified for resubmission
<br/><br/>
Thank you 
</td>
</tr>
</table>
</body>
</html>
