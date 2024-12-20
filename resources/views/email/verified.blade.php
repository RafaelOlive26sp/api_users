<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>


</head>
<body class="bg-dark">


<div class="container my-5">
    @if($status === 200)


        <div class="position-relative p-5 text-center text-muted border border-success border-opacity-0 rounded-5">

            <img src="{{asset('icons/verify.svg')}}" alt="" width="70" height="70" >
            <h1 class="text-body-emphasis my-2">You have successfully verified your email address.</h1>


        </div>
    @elseif($status === 401)
        <div class="position-relative p-5 text-center text-muted border border-danger border-opacity-0 rounded-5">

            <img src="{{asset('icons/error-svgrepo-com.svg')}}" alt="" width="70" height="70" >
            <h1 class="text-body-emphasis my-2"> {{$message}}</h1>


        </div>
    @else
        <div class="position-relative p-5 text-center text-muted border border-warning border-opacity-0 rounded-5">

            <img src="{{asset('icons/mail-check.svg')}}" alt="" width="70" height="70" >
            <h1 class="text-body-emphasis my-2"> {{$message}}</h1>


        </div>
    @endif
</div>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
