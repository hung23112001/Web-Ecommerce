@extends('layout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Quản lý tài khoản</h3>
                    </div>
                    
                    <div class="col-md-6">
                        @if (Session::has('usersID'))
                            <a href="{{route('users.logout')}}" class="btn btn-primary float-end ">Đăng xuất</a>
                        @endif
                        {{-- <a href="{{route('users.create')}}" class="btn btn-primary float-end">Đăng ký tài khoản</a> --}}
                        <a href="{{route('users.show', Session('usersID') )}}" class="btn btn-primary float-end">Thông tin cá nhân</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{Session::get('message')}}
                    </div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{Session::get('message')}}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Quyền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->department }}</td>
                                <td>
                                    <form action="{{route('users.destroy', $item->id)}}" method="POST">
                                        <a href="{{route('users.edit', $item->id)}}" class="btn btn-info">Sửa</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type='submit' class="btn btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection