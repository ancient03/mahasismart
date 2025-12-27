@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chat with {{ $toko->nama_toko }}</div>

                <div class="panel-body">
                    <div class="chat-messages">
                        @foreach ($messages as $message)
                            <div class="message">
                                <strong>{{ $message->sender->name }}:</strong> {{ $message->message }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="panel-footer">
                    <form action="{{ route('chat.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="toko_id" value="{{ $toko->id_toko }}">
                        <input type="hidden" name="receiver_id" value="{{ $toko->user->id }}">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Type your message...">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection