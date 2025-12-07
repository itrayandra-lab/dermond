@php
    $chatMode = \App\Models\SiteSetting::getValue('chat.mode', 'whatsapp');
    $whatsappNumber = \App\Models\SiteSetting::getValue('contact.phone', '');
    $whatsappClean = preg_replace('/[^0-9]/', '', $whatsappNumber);
@endphp

@if($chatMode === 'whatsapp' && $whatsappClean)
{{-- WhatsApp Mode: Simple floating button --}}
<a
    href="https://wa.me/{{ $whatsappClean }}"
    target="_blank"
    rel="noopener noreferrer"
    class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-400 text-white rounded-full shadow-lg flex items-center justify-center transition-transform hover:scale-105"
    style="box-shadow: 0 10px 40px rgba(34, 197, 94, 0.3);"
    title="Chat via WhatsApp"
>
    {{-- WhatsApp Icon --}}
    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>

@elseif($chatMode === 'chatbot')
{{-- Chatbot Mode: Full AI chat widget --}}
<div
    x-data="chatbotWidget()"
    x-init="init()"
    class="fixed bottom-6 right-6 z-50 flex flex-col items-end"
    x-cloak
>
    {{-- Chat Window --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="mb-4 w-80 md:w-96 bg-[#0a1226] border border-blue-500/30 rounded-2xl shadow-2xl flex flex-col overflow-hidden"
    >
        {{-- Header --}}
        <div class="bg-blue-600 p-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
                <h3 class="font-bold text-white text-sm">Dermond AI Expert</h3>
            </div>
            <button @click="close()" class="text-white/80 hover:text-white transition-colors">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Messages --}}
        <div class="h-80 overflow-y-auto p-4 space-y-4 bg-[#050a14]" x-ref="messages">
            <template x-if="messages.length === 0">
                <div class="flex justify-start">
                    <div class="max-w-[80%] p-3 rounded-2xl rounded-tl-none text-sm bg-[#1e293b] text-gray-200 border border-white/5">
                        Hello! I am your Dermond Specialist. Ask me about our products or intimate hygiene.
                    </div>
                </div>
            </template>

            <template x-for="message in messages" :key="message.id ?? message.tempId">
                <div class="flex" :class="message.type === 'user' ? 'justify-end' : 'justify-start'">
                    <div
                        class="max-w-[80%] p-3 rounded-2xl text-sm"
                        :class="message.type === 'user'
                            ? 'bg-blue-600 text-white rounded-tr-none'
                            : 'bg-[#1e293b] text-gray-200 rounded-tl-none border border-white/5'"
                    >
                        <div class="whitespace-pre-wrap break-words" x-html="formatMessage(message.content, message.type)"></div>
                    </div>
                </div>
            </template>

            <template x-if="isTyping">
                <div class="flex justify-start">
                    <div class="bg-[#1e293b] p-3 rounded-2xl rounded-tl-none border border-white/5">
                        <div class="flex gap-1">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></span>
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 75ms;"></span>
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Input --}}
        <div class="p-4 bg-[#0a1226] border-t border-white/5 flex gap-2">
            <input
                type="text"
                x-model="form.message"
                @keydown.enter="sendMessage()"
                placeholder="Ask about Freshcore Mist..."
                class="flex-1 bg-[#050a14] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition-colors"
                :disabled="sending"
            >
            <button
                @click="sendMessage()"
                :disabled="sending || form.message.trim() === ''"
                class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white p-2 rounded-lg transition-colors"
            >
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- Toggle Button --}}
    <button
        @click="toggle()"
        class="w-14 h-14 bg-blue-600 hover:bg-blue-500 text-white rounded-full shadow-lg flex items-center justify-center transition-transform hover:scale-105"
        style="box-shadow: 0 10px 40px rgba(37, 99, 235, 0.3);"
    >
        <template x-if="!isOpen">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </template>
        <template x-if="isOpen">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </template>
    </button>
</div>

<script>
function chatbotWidget() {
    return {
        isOpen: false,
        sending: false,
        isTyping: false,
        sessionId: null,
        messages: [],
        form: { message: '' },
        storageKey: 'chatbot_session_id',

        async init() {
            this.restoreSession();
        },

        toggle() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.ensureSession();
            }
        },

        close() {
            this.isOpen = false;
        },

        restoreSession() {
            const stored = window.sessionStorage.getItem(this.storageKey);
            if (stored) {
                this.sessionId = stored;
            }
        },

        async ensureSession() {
            if (this.sessionId) {
                await this.loadHistory();
                return;
            }
            await this.createSession();
        },

        async createSession() {
            try {
                const response = await axios.get('/api/chatbot/session');
                this.sessionId = response.data?.session_id;
                if (this.sessionId) {
                    window.sessionStorage.setItem(this.storageKey, this.sessionId);
                }
                await this.loadHistory();
            } catch (error) {
                console.error('Failed to create session:', error);
            }
        },

        async loadHistory() {
            if (!this.sessionId) return;
            try {
                const response = await axios.get('/api/chatbot/history', {
                    params: { session_id: this.sessionId, limit: 50 },
                });
                this.messages = response.data?.messages ?? [];
                this.$nextTick(() => this.scrollToBottom());
            } catch (error) {
                // ignore silently
            }
        },

        async sendMessage() {
            const text = this.form.message.trim();
            if (!text || this.sending) return;

            if (!this.sessionId) {
                await this.createSession();
                if (!this.sessionId) return;
            }

            const tempId = `temp-${Date.now()}`;
            this.messages.push({ tempId, type: 'user', content: text, sent_at: new Date().toISOString() });
            this.form.message = '';
            this.sending = true;
            this.isTyping = true;
            this.$nextTick(() => this.scrollToBottom());

            try {
                const response = await axios.post('/api/chatbot/send', {
                    session_id: this.sessionId,
                    message: text,
                });

                const botMessages = response.data?.messages ?? [];
                this.messages = this.messages.filter((msg) => msg.tempId !== tempId);
                this.messages.push(...botMessages);
            } catch (error) {
                this.messages.push({ type: 'bot', content: "Sorry, I'm having trouble connecting to the server." });
            } finally {
                this.sending = false;
                this.isTyping = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        scrollToBottom() {
            if (this.$refs.messages) {
                this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight;
            }
        },

        formatMessage(content, type) {
            if (!content) return '';
            const escapeHtml = (text) => {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            };
            let formatted = escapeHtml(content);
            formatted = formatted.replace(/\n/g, '<br>');
            return formatted;
        },
    };
}
</script>
@endif
