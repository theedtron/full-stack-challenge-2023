@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Users</h1></div>

                <div class="panel-body">
                    <div>
                        <a href="/users/create" class="btn btn-success pull-right">Add User</a>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <table class="table" id="user-table">
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </thead>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }} </td>
                            <td>{{ $user->name }} </td>
                            <td>{{ $user->email }} </td>
                            <td>{{ $user->roles[0]->role_name }} </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                      Dropdown button
                                    </button>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li>
                                                @if($user->is_banned)
                                                    <a class="dropdown-item" href="{{url('users/unban/'.$user->id)}}">UnBan</a>
                                                @else
                                                    <a class="dropdown-item" href="{{url('users/ban/'.$user->id)}}">Ban</a>
                                                @endif
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{url('users/delete/'.$user->id)}}">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                  </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
let table = new DataTable('#user-table');
</script>
@endsection
