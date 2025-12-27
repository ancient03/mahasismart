@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Conversations</div>

                <div class="panel-body">
                    <ul class="list-group">
                        @foreach ($users as $user)
                            <li class="list-group-item">
                                <a href="{{ route('chat.toko.conversation', ['user_id' => $user->id]) }}">
                                    {{ $user->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
