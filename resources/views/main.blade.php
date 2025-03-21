<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<h1>Hello, world!</h1>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->


<form class="mb-3 row g-3 align-items-center" action="{{ route('upload.table') }}" method="post">
    @csrf
    <div class="col-sm-7">
        <label for="urlSheet" class="visually-hidden">Укажите ссылку на Google таблицу</label>
        <input name="urlSheet" type="text" class="form-control" id="urlSheet"
               placeholder="Сюда ссылка на Google таблицу">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </div>
    @error('name')
    <div class="alert alert-danger">Сюда ссылка на Google таблицу</div>
    @enderror
</form>

<form action="{{ route('dataitem.generate') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary mb-3">Создать 1000 записей</button>
</form>
<div>
    <a class="btn btn-danger mb-3" href="{{ route('clear-dataitem') }}"
       onclick="return confirm('Вы уверены, что хотите очистить базу данных?')">Очистить базу данных</a>
    <a class="btn btn-danger mb-3" href="{{ route('clear.sheet') }}"
       onclick="return confirm('Вы уверены, что хотите очистить таблицу?')">Очистить таблицу</a>
</div>
<form action="{{ route('export.sheet') }}" method="POST">
    @csrf
    <label for="name">Name>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <button type="submit" class="btn btn-primary mb-3">Выгрузка в Google Sheets</button>
    </label>
</form>

<div>
    @yield('content')
</div>
</body>
</html>





