@extends('layout')

@section('content')
    {{-- <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Thông tin tài khoản</h3>
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
                            
                        </div>
                    </div>
                        <a href="{{route('users.edit', $item->id)}}" class="btn btn-info">Sửa</a>
                    <button type="submit" class="btn btn-success mt-2">Cập nhật</button>
                </form>
            </div>
        </div>
    </div> --}}
    @if (Session::has('message'))
        <div class="alert alert-success">
            {{Session::get('message')}}
        </div>
    @endif
    <h1>Tài khoản: {{ $users->username}} </h1>
@endsection