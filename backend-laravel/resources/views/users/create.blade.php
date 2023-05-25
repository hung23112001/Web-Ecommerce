@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Tạo mới tài khoản Admin</h3>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('users.index')}}" class="btn btn-primary float-end">Quay lại</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('users.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Tên tài khoản: </strong>
                                <input type="text" name="username" class="form-control" placeholder="Nhập tên tài khoản">
                            </div>
                            <div class="form-group">
                                <strong>Email: </strong>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <strong>Mật khẩu: </strong>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="form-group">
                                <strong>Xác nhận mật khẩu: </strong>
                                <input type="password" name="password_confimation" class="form-control" placeholder="Xác nhận mật khẩu">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection