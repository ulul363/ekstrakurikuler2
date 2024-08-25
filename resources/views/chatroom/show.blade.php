@extends('layouts.master')

@section('content')
    <style>
        /* Style untuk chat card */
        .chat-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-height: 600px;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        /* Style untuk chat container */
        .chat-container {
            max-height: 500px;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        /* Style untuk message row */
        .message-row {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
            justify-content: flex-start;
        }

        /* Style untuk message avatar */
        .message-avatar {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }

        .message-avatar img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }

        /* Style untuk message content */
        .message-content {
            max-width: 75%;
            margin-left: 10px;
        }

        .message-row.sent .message-content {
            margin-left: 0;
            margin-right: 10px;
            text-align: right;
        }

        .message-row.received .message-content {
            margin-left: 10px;
            margin-right: 0;
        }

        /* Style untuk message text */
        .message-text {
            background-color: #f1f1f1;
            border-radius: 8px;
            padding: 12px;
            display: inline-block;
            word-wrap: break-word;
            font-size: 14px;
        }

        /* Style untuk message time */
        .message-time {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }

        .sent {
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .sent .message-text {
            background-color: #007bff;
            color: #fff;
        }

        .sent .message-avatar {
            order: 1;
        }

        .received {
            justify-content: flex-start;
        }

        .received .message-avatar {
            order: 0;
        }

        .received .message-content {
            margin-right: 10px;
        }

        .received .message-text {
            background-color: #e9ecef;
        }

        .pembina .message-text {
            border-left: 5px solid #007bff;
        }

        .ketua .message-text {
            border-left: 5px solid #28a745;
        }

        /* Style untuk input group (button and input) */
        .input-group {
            display: flex;
            align-items: center;
            border-top: 1px solid #ddd;
            background-color: #f9f9f9;
            padding: 10px;
        }

        .input-group .form-control {
            flex: 1;
            margin-right: 10px;
            border-radius: 20px;
            padding: 10px 15px;
        }

        .input-group .btn {
            border-radius: 20px;
            padding: 10px 20px;
        }
    </style>

    <div class="col-lg-4 col-md-12">
        <div class="card chat-card">
            <div class="card-header">
                <h5>Chat</h5>
            </div>
            <div class="card-body chat-container" id="chat-body">
                <div id="chat-isi">
                    @foreach ($chats as $chat)
                        @php
                            $user = \App\Models\User::find($chat->pengirim);
                            $userRole = $user->getRoleNames()->first();
                        @endphp
                        <div
                            class="message-row {{ $chat->pengirim == auth()->user()->id ? 'sent' : 'received' }} {{ $userRole === 'Pembina' ? 'pembina' : ($userRole === 'Ketua' ? 'ketua' : '') }}">
                            @if ($chat->pengirim == auth()->user()->id || $userRole === 'Pembina')
                                <div class="message-avatar">
                                    <img src="{{ $userRole === 'Pembina' ? asset('assets/images/profile/bg-4.jpg') : asset('assets/images/profile/bg-4.jpg') }}"
                                        alt="user image">
                                </div>
                            @endif
                            <div class="message-content">
                                <p class="message-text">{{ $chat->pesan }}</p>
                                <p class="message-time"><i
                                        class="fa fa-clock-o m-r-10"></i>{{ $chat->created_at->format('H:i a') }}</p>
                            </div>
                            @if ($chat->pengirim !== auth()->user()->id && $userRole === 'Ketua')
                                <div class="message-avatar">
                                    <img src="{{ $userRole === 'Ketua' ? asset('assets/images/profile/bg-3.jpg') : asset('assets/images/profile/bg-3.jpg') }}"
                                        alt="user image">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="input-group">
                    <form id="chat-form" action="{{ route('chatroom.store') }}" method="POST"
                        style="display: flex; width: 100%;">
                        @csrf
                        <input type="hidden" name="pengajuan_pertemuan_id"
                            value="{{ $pertemuan->id_pengajuan_pertemuan }}">
                        <input type="text" name="pesan" class="form-control" id="pesan" placeholder="Send message" autocomplete="off">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
                <div id="loading" style="display: none;">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function createChatMessage(chat, currentUser) {
            var messageClass = chat.pengirim === currentUser ? 'sent' : 'received';
            var userRole = chat.pengirim_role === 'Pembina' ? 'pembina' : (chat.pengirim_role === 'Ketua' ? 'ketua' : '');
            var avatarSrc = userRole === 'Pembina' ? '{{ asset('assets/images/profile/bg-4.jpg') }}' : (userRole ===
                'Ketua' ? '{{ asset('assets/images/profile/bg-3.jpg') }}' :
                '{{ asset('assets/images/profile/bg-4.jpg') }}');

            return `
                <div class="message-row ${messageClass} ${userRole}">
                    ${messageClass === 'sent' ? `
                            <div class="message-content">
                                <p class="message-text">${chat.pesan}</p>
                                <p class="message-time"><i class="fa fa-clock-o m-r-10"></i>${new Date(chat.created_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}</p>
                            </div>
                            <div class="message-avatar">
                                <img src="${avatarSrc}" alt="user image">
                            </div>
                        ` : `
                            <div class="message-avatar">
                                <img src="${avatarSrc}" alt="user image">
                            </div>
                            <div class="message-content">
                                <p class="message-text">${chat.pesan}</p>
                                <p class="message-time"><i class="fa fa-clock-o m-r-10"></i>${new Date(chat.created_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}</p>
                            </div>
                        `}
                </div>
            `;
        }

        function fetchMessages() {
            $('#loading').show();

            $.ajax({
                url: '{{ route('chatroom.fetch', ['id' => $pertemuan->id_pengajuan_pertemuan]) }}',
                type: 'GET',
                success: function(data) {
                    var chatContainer = $('#chat-isi');
                    var wasScrolledToBottom = chatContainer.scrollTop() + chatContainer.height() >=
                        chatContainer.prop('scrollHeight');

                    chatContainer.empty();

                    data.forEach(function(chat) {
                        chatContainer.append(createChatMessage(chat, {{ auth()->user()->id }}));
                    });

                    if (wasScrolledToBottom) {
                        chatContainer.scrollTop(chatContainer.prop('scrollHeight'));
                    }

                    $('#loading').hide();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching new chats:', error);
                    alert('Unable to fetch new messages. Please try again.');
                    $('#loading').hide();
                }
            });
        }

        $(document).ready(function() {
            setInterval(fetchMessages, 5000);

            $('#chat-form').submit(function(event) {
                event.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    success: function(response) {
                        var chatContainer = $('#chat-isi');
                        chatContainer.append(createChatMessage(response,
                            {{ auth()->user()->id }}));
                        chatContainer.scrollTop(chatContainer.prop('scrollHeight'));

                        form.trigger('reset');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending message:', error);
                        alert('Unable to send message. Please try again.');
                    }
                });
            });
        });
    </script>
@endsection
