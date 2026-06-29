@extends('layouts.master')

@section('content')
    <div class="pcoded-content">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10">
                <div class="card chat-card shadow-lg">
                    <div class="card-header chat-header d-flex align-items-center py-3">
                        <a href="{{ route('chat.index') }}" class="text-white mr-3" style="font-size: 20px;">
                            <i class="feather icon-arrow-left"></i>
                        </a>
                        <img src="{{ asset('dist/assets/images/user/avatar-1.jpg') }}"
                            class="img-radius rounded-circle border border-white mr-3" width="45" alt="User">
                        <div>
                            <h5 class="text-white mb-0 font-weight-bold">{{ $receiver->name ?? 'Kontak' }}</h5>
                            <small class="text-white-50"><i class="feather icon-circle text-success"></i> Online</small>
                        </div>
                    </div>

                    <div class="card-body chat-box" id="chatBox">
                        @forelse($messages as $msg)
                            <div class="chat-message {{ $msg->pengirim_id == Auth::id() ? 'sent' : 'received' }}">
                                <div class="message-bubble">
                                    {{ $msg->pesan }}
                                </div>
                                <div class="message-time">
                                    {{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}
                                    @if($msg->pengirim_id == Auth::id())
                                        <i class="feather icon-check-circle text-primary ml-1"></i>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted mt-5">
                                <p>Belum ada obrolan. Kirim pesan untuk memulai!</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="card-footer bg-white border-top">
                        <form id="formKirimPesan" action="{{ route('chatroom.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                            <div class="input-group align-items-center">
                                <input type="text" name="pesan" id="inputPesan"
                                    class="form-control rounded-pill mr-2 bg-light border-0 px-4"
                                    placeholder="Ketik pesan Anda..." required autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary rounded-circle shadow-sm"
                                        style="width: 45px; height: 45px; padding: 0;">
                                        <i class="feather icon-send" style="margin-left: -3px;"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Auto-scroll ke bawah saat halaman dimuat
            var chatBox = document.getElementById("chatBox");
            chatBox.scrollTop = chatBox.scrollHeight;

            $('#formKirimPesan').on('submit', function (e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var pesanInput = $('#inputPesan').val();

                // 1. Bungkus/ambil datanya DULU SEBELUM inputan dikosongkan!
                var formData = form.serialize();

                // 2. Buat efek bubble chat sementara
                var tempBubble = `
                    <div class="chat-message sent temp-msg">
                        <div class="message-bubble" style="opacity: 0.7;">
                            ${pesanInput}
                        </div>
                        <div class="message-time">Mengirim...</div>
                    </div>`;
                $('#chatBox').append(tempBubble);
                chatBox.scrollTop = chatBox.scrollHeight;

                // 3. BARU inputannya dikosongkan
                $('#inputPesan').val('');

                // 4. Kirim datanya ke server
                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData, // Kirim variabel formData yang sudah dibungkus di langkah 1
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function (xhr) {
                        $('.temp-msg').remove();
                        alert('Gagal mengirim pesan. Silakan coba lagi.');
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection