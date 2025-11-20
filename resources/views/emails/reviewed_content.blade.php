<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <p>Hi...</p>
  <p>Please find the reviewed content details.</p>

  <p>NID / name: {{  $data['name']}}</p>
  <p>Language : {{ $data['lang']}}</p> 
  <p>Editor Email : {{$data['editor']}}</p>

  
  <label>Please login to <a href="{{$data['link']}}/view-translation/{{$data['content_id']}}">ujjivan.com</a></label>
</body>
</html>