<style>
    /* Tombol Mengambang dengan Animasi Pulse */
    .chat-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        text-align: center;
        line-height: 60px;
        font-size: 28px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        z-index: 9999;
        transition: transform 0.3s ease;
    }

    .chat-btn:hover {
        transform: scale(1.1) rotate(10deg);
    }

    /* Kotak Chat Utama */
    .chat-box {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 360px;
        height: 500px;
        background: #f8fafc;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        overflow: hidden;
        z-index: 9999;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        border: 1px solid #e2e8f0;
    }

    /* Header Elegan */
    .chat-header {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
        padding: 16px 20px;
        font-size: 15px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    .close-btn {
        cursor: pointer;
        font-size: 20px;
        background: none;
        border: none;
        color: white;
        font-weight: bold;
        transition: 0.2s;
    }

    .close-btn:hover {
        color: #fca5a5;
        transform: scale(1.2);
    }

    /* Area Chat Body + Custom Scrollbar */
    .chat-body {
        flex: 1;
        padding: 20px 15px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chat-body::-webkit-scrollbar {
        width: 6px;
    }

    .chat-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Desain Balon Chat Modern (Speech Bubble) */
    .msg-user {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        padding: 12px 16px;
        font-size: 14px;
        line-height: 1.5;
        border-radius: 16px 16px 0 16px;
        /* Ekor di kanan bawah */
        align-self: flex-end;
        max-width: 80%;
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.2);
    }

    .msg-bot {
        background: white;
        color: #1e293b;
        padding: 12px 16px;
        font-size: 14px;
        line-height: 1.5;
        border-radius: 16px 16px 16px 0;
        /* Ekor di kiri bawah */
        align-self: flex-start;
        max-width: 85%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
    }

    .msg-bot b {
        color: #2563eb;
    }

    /* Area Input Kekinian */
    .chat-input-area {
        display: flex;
        border-top: 1px solid #e2e8f0;
        background: white;
        padding: 10px;
        align-items: center;
    }

    .chat-input-area input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        outline: none;
        font-size: 14px;
        transition: border 0.3s;
    }

    .chat-input-area input:focus {
        border-color: #3b82f6;
    }

    .chat-input-area button {
        background: #2563eb;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-left: 10px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: 0.3s;
        box-shadow: 0 2px 5px rgba(37, 99, 235, 0.3);
    }

    .chat-input-area button:hover {
        background: #1d4ed8;
        transform: scale(1.05);
    }

    /* Animasi Mengetik */
    .typing-text {
        font-style: italic;
        color: #64748b;
        font-size: 13px;
    }

    .msg-error {
        background: #fee2e2;
        color: #b91c1c;
        padding: 10px;
        font-size: 13px;
        border-radius: 12px;
        text-align: center;
        align-self: center;
        width: 90%;
    }
</style>

<div class="chat-btn" onclick="toggleChat()">🤖</div>

<div class="chat-box" id="chatBox">
    <div class="chat-header">
        <span><i class="fas fa-robot"></i> Asisten MARCOS</span>
        <button class="close-btn" onclick="toggleChat()">✖</button>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="msg-bot">Halo! 👋 Ketik <b>halo</b> atau <b>menu</b> untuk melihat fitur cerdas saya.</div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="chatInput" placeholder="Ketik pesan di sini..." autocomplete="off"
            onkeypress="handleEnter(event)">
        <button onclick="sendMessage()">➤</button>
    </div>
</div>

<script>
    function toggleChat() {
        let box = document.getElementById('chatBox');
        box.style.display = box.style.display === 'flex' ? 'none' : 'flex';
    }

    function handleEnter(e) {
        if (e.key === 'Enter') sendMessage();
    }

    // Fungsi scroll smooth ke paling bawah
    function scrollToBottom() {
        let chatBody = document.getElementById('chatBody');
        chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: 'smooth' });
    }

    function sendMessage() {
        let input = document.getElementById('chatInput');
        let message = input.value.trim();
        if (message === '') return;

        let chatBody = document.getElementById('chatBody');

        // 1. Munculkan Chat User
        chatBody.innerHTML += `<div class="msg-user">${message}</div>`;
        input.value = '';
        scrollToBottom();

        // 2. Munculkan Indikator "Mengetik..."
        let typingId = "typing-" + Date.now();
        chatBody.innerHTML += `<div class="msg-bot" id="${typingId}"><span class="typing-text">🤖 Sedang mengetik...</span></div>`;
        scrollToBottom();

        // 3. Kirim via AJAX
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "{{ route('chatbot.reply') }}", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                // Hapus indikator "Mengetik..." setelah ada respon
                let typingElement = document.getElementById(typingId);
                if (typingElement) typingElement.remove();

                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    // Munculkan chat bot dengan efek delay sepersekian detik biar natural
                    setTimeout(() => {
                        chatBody.innerHTML += `<div class="msg-bot">${response.reply}</div>`;
                        scrollToBottom();
                    }, 200);
                } else {
                    chatBody.innerHTML += `<div class="msg-error">❌ Gagal terhubung ke server. Periksa jaringan Anda.</div>`;
                    scrollToBottom();
                }
            }
        };
        xhr.send("message=" + encodeURIComponent(message));
    }
</script>