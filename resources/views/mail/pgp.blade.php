@extends('layouts.mail')

@section('mail_content')
<h2>Hello {!!$name!!}</h2>
<p>{{$content}}</p>
@endsection
