@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Cập nhật thông tin</h3>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('users.index')}}" class="btn btn-primary float-end">Quay lại</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('users.update', $users->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Tên tài khoản: </strong>
                                <input type="text" value="{{$users->username}}" name="username" class="form-control" placeholder="Nhập tên tài khoản">
                            </div>
                            <div class="form-group">
                                <strong>Email: </strong>
                                <input type="email" value="{{$users->email}}" name="email" class="form-control" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <strong>Quyền sử dụng: </strong>
                                <select class="form-select" name="department_id" id="">
                                    @foreach ($departments as $item)
                                        @if ($item->id === $users->department_id)
                                            <option selected value="{{$item->id}}">{{$item->name}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <strong>Tình trạng tài khoản: </strong>
                                <select class="form-select" name="status_id" id="">
                                    @foreach ($users_status as $item)
                                        @if ($item->id === $users->status_id)
                                            <option selected value="{{$item->id}}">{{$item->name}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
    
@endsection