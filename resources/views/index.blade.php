<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nasa events</title>
</head>
<body>
    @foreach($data as $event)
        <div>
            <h2>{{$event->id}}: {{$event->title}}</h2>
            <p>Date: {{$event->date}}</p>
            <p>Category: {{$event->category->title}}</p>
        </div>
    @endforeach
</body>
</html>
