@extends('main')
@section('content')
    <div>
        <table class="table table-success table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Текст</th>
                <th scope="col">статус</th>
                <th scope="col">Комментарии</th>
                <th scope="col">Изменить/удалить</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dataItems as $item)
                <tr>
                    <th scope="row">{{ $item->id }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->comment }}</td>
                    <td><a href="{{ route('dataitem.show', $item->id) }}">Смотреть</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mb-3">{{ $dataItems->withQueryString()->onEachSide(3)->links() }}</div>
    </div>
    <a class="btn btn-primary mb-3" href="{{ route('dataitem.create') }}">Создать запись</a>
@endsection

