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
This email served as a reminder. Please prepare your Interim Payment Certificate (IPC) within <b>3 working days</b>. The details are as follow:
<br/>
JMS ID: {{$jms['id']}}
<br/>
JMS Submission Date: {{$jms['submissionDate']}}
<br/>
JMS Approved Date: {{$jms['approvedDate']}}
<br/>
Work Order Number: <b>{{$jms['woNumber']}}</b>
<br/>
Major Item: <b>{{$jms['majorItem']}}</b>
<br/><br/>
Thank you 
</td>
</tr>
</table>
</body>
</html>
