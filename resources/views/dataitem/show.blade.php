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
            <tr>
                <th scope="row">{{ $dataitem->id }}</th>
                <td>{{ $dataitem->name }}</td>
                <td>{{ $dataitem->description }}</td>
                <td>{{ $dataitem->status }}</td>
                <td>{{ $dataitem->comment }}</td>
                <td><a class="btn btn-primary" href="{{ route('dataitem.edit', $dataitem->id) }}">изменить</a>
                    <form action="{{ route('dataitem.destroy', $dataitem->id) }}" method="post" class="btn btn-primary">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">удалить</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <a class="btn btn-primary" href="{{ url('dataitem') }}">Вернуться к блогам</a>

@endsection

