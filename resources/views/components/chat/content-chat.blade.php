<div class="flex flex-col h-full bg-gray-100 border border-gray-300 rounded-xl overflow-hidden">
    <!-- Header -->
    <div id="chat-header" class="flex items-center justify-between bg-white p-4 shadow-sm">
        <h2 class="font-semibold text-lg">Pilih chat untuk memulai percakapan</h2>
    </div>

    <!-- Chat Body -->
    <div id="chat-body" class="flex-1 overflow-y-auto p-4 space-y-4 scrollbar-hide">
        <!-- Messages will be loaded here dynamically -->
    </div>

    <!-- Input -->
    <form id="chat-form" class="flex items-center gap-2 p-4 bg-white shadow">
        @csrf
        <input type="hidden" name="toko_id" id="toko_id_input">
        <input type="hidden" name="receiver_id" id="receiver_id_input">
        <input type="text" id="chat-input" name="message" placeholder="Ketik pesan..." class="flex-1 rounded-full px-4 py-2 focus:outline-none" disabled />
        <button type="submit" id="chat-send-button" class="py-2 px-4 bg-[#00795E] text-white rounded-full hover:bg-[#005744] transition duration-500 cursor-pointer" disabled>
            <i class="bi bi-send-fill"></i>
        </button>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatItems = document.querySelectorAll('.chat-item');
    const chatHeader = document.getElementById('chat-header').querySelector('h2');
    const chatBody = document.getElementById('chat-body');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatSendButton = document.getElementById('chat-send-button');
    const tokoIdInput = document.getElementById('toko_id_input');
    const receiverIdInput = document.getElementById('receiver_id_input');
    let activeChatId = null;
    let activeChatType = null;
    let fetchInterval = null;

    chatItems.forEach(item => {
        item.addEventListener('click', function () {
            // Remove active class from all items
            chatItems.forEach(i => i.classList.remove('bg-[#00795E]', 'text-white'));
            chatItems.forEach(i => i.classList.add('bg-gray-100'));

            // Add active class to clicked item
            this.classList.add('bg-[#00795E]', 'text-white');
            this.classList.remove('bg-gray-100');
            
            activeChatId = this.dataset.id;
            activeChatType = this.dataset.type;

            const name = this.querySelector('h1').textContent;
            chatHeader.textContent = `Chat dengan ${name}`;
            
            chatInput.disabled = false;
            chatSendButton.disabled = false;

            if (activeChatType === 'toko') {
                tokoIdInput.value = activeChatId;
                receiverIdInput.value = ''; // Clear receiver for buyer->toko
            } else { // type is 'user'
                @if(Auth::user()->toko)
                    tokoIdInput.value = {{ Auth::user()->toko->id_toko }};
                @endif
                receiverIdInput.value = activeChatId;
            }

            fetchMessages();

            if(fetchInterval) clearInterval(fetchInterval);
            fetchInterval = setInterval(fetchMessages, 3000);
        });
    });

    function fetchMessages() {
        if (!activeChatId) return;

        let url = `/chat/messages?`;
        if (activeChatType === 'user') {
            url += `user_id=${activeChatId}`;
        } else {
            url += `toko_id=${activeChatId}`;
        }
        
        fetch(url)
            .then(response => response.json())
            .then(messages => {
                chatBody.innerHTML = '';
                messages.forEach(message => {
                    appendMessage(message);
                });
                chatBody.scrollTop = chatBody.scrollHeight;
            });
    }

    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        const formData = new FormData(this);

        fetch('{{ route("chat.sendMessage") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(newMessage => {
            if (newMessage.error) {
                console.error(newMessage.error);
                return;
            }
            appendMessage(newMessage);
            chatInput.value = '';
            chatBody.scrollTop = chatBody.scrollHeight;
        });
    });

    function appendMessage(message) {
        const messageWrapper = document.createElement('div');
        const messageBubble = document.createElement('div');
        const messageText = document.createElement('p');
        const messageTime = document.createElement('p');

        messageWrapper.classList.add('flex');
        messageBubble.classList.add('rounded-xl', 'p-3', 'max-w-sm', 'shadow');
        messageText.classList.add('text-gray-800');
        messageTime.classList.add('text-xs', 'mt-1', 'text-right');

        messageText.textContent = message.message;
        messageTime.textContent = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        if (message.sender_id === {{ Auth::id() }}) {
            messageWrapper.classList.add('justify-end');
            messageBubble.classList.add('bg-[#00795E]', 'text-white');
            messageTime.classList.add('text-gray-200');
        } else {
            messageWrapper.classList.add('justify-start');
            messageBubble.classList.add('bg-white', 'border', 'border-gray-300');
            messageTime.classList.add('text-gray-500');
        }

        messageBubble.appendChild(messageText);
        messageBubble.appendChild(messageTime);
        messageWrapper.appendChild(messageBubble);
        chatBody.appendChild(messageWrapper);
    }
});
</script>
@endpush
