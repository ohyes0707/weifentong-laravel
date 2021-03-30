<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>test</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


</head>
<body>
@if (session('msg'))
    <script type="text/javascript">
        var msg = "{{ session('msg') }}";
        alert(msg);
    </script>
@endif
<div class="flex-center position-ref full-height">
    @if (isset($messages))
        <p>输入错误：</p>
        <ul>
            @foreach($messages->all() as $item)
                <li style="color: red;">{{$item}}</li>
            @endforeach
        </ul>
        <hr/>
    @endif
    <div class="content">
        <div class="title m-b-md">
            <form method="POST" action="">
                {!! csrf_field() !!}

                <div>
                    Email
                    <input type="text" name="username" value="{{ old('email') }}">
                    <span></span>
                </div>

                <div>
                    Password
                    <input type="text" name="password" id="password">
                </div>
                <div>
                    验证码
                    <input class="tt-text" name="captcha">
                    <img src="{{ url('/captcha') }}" onclick="this.src='{{ url('/captcha') }}?r='+Math.random();" alt="">
                </div>

                <div>
                    <button type="submit">Login</button>
                </div>
                </form>
        </div>
    </div>
</div>
</body>
</html>
