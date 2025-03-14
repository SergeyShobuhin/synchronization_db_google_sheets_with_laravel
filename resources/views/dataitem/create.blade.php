@extends('main')
@section('content')
    <form action="{{ route('dataitem.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="Имя">
            @error('name')
            <div class="alert alert-danger">Укажи имя</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Содержимое</label>
            <textarea name="description" class="form-control" id="description" rows="3" >{{ old('description') }}</textarea>
            @error('description')
            <div class="alert alert-danger">Укажи Содержимое</div>
            @enderror
        </div>
        <div class="mb-3">
            <select name="status" class="form-select form-select-sm" aria-label=".form-select-sm example" >
                <option selected>Allowed</option>
                <option value="Prohibited">Prohibited</option>
            </select>
            @error('status')
            <div class="alert alert-danger">Укажите статус </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


@endsection
