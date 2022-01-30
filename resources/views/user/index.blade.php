@extends('layouts.app')

@section('content')
    <h1>Users</h1>
    <a href="/user/create" class="btn btn-default pull-right">New User</a>
    <br>
    <br>
    @if (count($user) > 0)
        @foreach ($user as $users)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:50%" src="/storage/profile_image/{{ $users->profile_image }}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/user/{{ $users->id }}">{{ $users->First_Name }} {{ $users->Last_Name }}</a></h3>
                        <small>Written on {{ $users->created_at }}</small>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $user->links() }}
    @else
        <p>No Users found</p>
    @endif
@endsection
