<html>
<head></head>
<body>
<h1> Contact created</h1>
<p> Your contact has been created successfully</p>
<br>
<p> Contact details</p>
<hr>

<h4> Name:{{$singleData['fname'].' '.$singleData['lname']}}</h4>
<h4> Email:{{$singleData['email']}}</h4>
<a href="{{ $singleData['optin_url'] }}">Confirm double Opt-in</a>


</body>
</html>
