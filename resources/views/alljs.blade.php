<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All JS</title>
</head>
<body>
    <div id="size">{{sizeof($alljs)}}</div>
    @foreach($alljs as $js)
        <div class="id">{{$js->id}}</div>
        <div class="row">{{$js->title}}</div>
    @endforeach
</body>
</html>