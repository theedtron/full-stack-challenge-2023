@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Comments</h1></div>

                <div class="panel-body">
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
                    <table class="table" id="comment-table">
                        <thead>
                            <th>Id</th>
                            <th>Comment</th>
                            <th>User</th>
                            <th>Actions</th>
                        </thead>
                        @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }} </td>
                            <td>{{ $comment->comment }} </td>
                            <td>{{ $comment->username }} </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                      Actions
                                    </button>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li>
                                                <a class="dropdown-item" href="{{url('comments/delete/'.$comment->id)}}">Delete</a>
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
let table = new DataTable('#comment-table');
</script>
@endsection
