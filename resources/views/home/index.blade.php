<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Test</title>
</head>

<body>
    <p>
        @foreach (\Session::get('cart') as $key => $value)
            <strong>{{ $key }}</strong>: {{ $value }} <br>
        @endforeach
    </p>

    <form action="{{ route('webpay.init') }}" method="post">
        {{ csrf_field() }}
        <button type="submit">Comprar</button>
    </form>
</body>

</html>
