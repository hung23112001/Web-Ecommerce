@extends('layout')

@section('content')
    <div class="container col-4" style="margin-top: 100px;">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <h2 class='text-center'>Đăng nhập</h2>
            </div>
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-error">
                        {{Session::get('message')}}
                    </div>
                @endif

                @if (Session::has('usersID'))
                    <h2>Còn session nè</h2>
                @endif

                <form action="{{route('users.login')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tài khoản:</label>
                        <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập tài khoản:">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mật khẩu:</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Nhập mật khẩu">
                    </div>
                    <br>
                    <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
