@extends('layouts.app')

@section('content')
<div class="h-[calc(100vh-8rem)] flex flex-col">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-4 bg-skin-base p-4 rounded-xl border border-skin-border shadow-sm">
        <a href="{{ route('chat.index') }}" class="text-skin-text-muted hover:text-skin-text">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-umera-100 flex items-center justify-center text-umera-700 font-bold">
                {{ substr($receiver->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-lg font-bold text-skin-text">{{ $receiver->name }}</h1>
                <p class="text-xs text-skin-text-muted">{{ ucfirst($receiver->role) }}</p>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 bg-skin-base rounded-xl shadow-sm border border-skin-border flex flex-col overflow-hidden relative">
        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6" id="messages-container">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%]">
                        <div class="{{ $message->sender_id === auth()->id() ? 'bg-umera-600 text-white' : 'bg-skin-base-ter text-skin-text' }} rounded-2xl px-5 py-3 shadow-sm relative group">
                            
                            <!-- Text Message -->
                            @if($message->message)
                                <p class="text-sm whitespace-pre-wrap">{{ $message->message }}</p>
                            @endif

                            <!-- Attachment -->
                            @if($message->attachment_path)
                                <div class="mt-2">
                                    @if($message->attachment_type === 'image')
                                        @php
                                            $imgPath = '/storage/'.$message->attachment_path;
                                        @endphp
                                        <a href="{{ $imgPath }}" target="_blank">
                                            <img src="{{ $imgPath }}" alt="Attachment" class="max-w-full h-auto rounded-lg border border-white/20">
                                        </a>
                                    @elseif($message->attachment_type === 'voice')
                                        @php
                                            $origPath = '/storage/'.$message->attachment_path;
                                            $mp3Path = preg_replace('/\.[^\.]+$/', '.mp3', $message->attachment_path);
                                            $srcPath = Storage::disk('public')->exists($mp3Path) ? '/storage/'.$mp3Path : $origPath;
                                        @endphp
                                        <div 
                                            x-data="voicePlayer('{{ $srcPath }}')" 
                                            x-init="init()" 
                                            @keydown="handleKey($event)"
                                            tabindex="0"
                                            role="region"
                                            aria-label="Voice message player"
                                            class="w-full min-w-[260px] max-w-[520px] select-none"
                                        >
                                            <div class="flex items-center gap-3">
                                                <button 
                                                    type="button" 
                                                    @click="toggle()" 
                                                    :aria-label="isPlaying ? 'Pause voice note' : 'Play voice note'"
                                                    class="h-12 w-12 min-h-12 min-w-12 rounded-full flex items-center justify-center transition-all shadow-md ring-1 ring-skin-border hover:ring-umera-600"
                                                    :class="isPlaying ? 'bg-gradient-to-br from-umera-600 to-red-900 text-white hover:from-umera-700 hover:to-red-900' : 'bg-skin-base-ter text-skin-text hover:bg-skin-base-quat'"
                                                >
                                                    <template x-if="!isPlaying">
                                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v14l11-7-11-7z"/>
                                                        </svg>
                                                    </template>
                                                    <template x-if="isPlaying">
                                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 5h2v14h-2zM16 5h2v14h-2z"/>
                                                        </svg>
                                                    </template>
                                                </button>
                                                
                                                <div class="flex-1">
                                                    <div class="relative">
                                                        <canvas 
                                                            x-ref="wave" 
                                                            width="420" 
                                                            height="56" 
                                                            class="w-full h-14 rounded-xl bg-skin-base-ter cursor-pointer border border-skin-border"
                                                            @click="waveSeek($event)"
                                                            aria-hidden="true"
                                                        ></canvas>
                                                        <div 
                                                            x-show="isBuffering" 
                                                            class="absolute inset-0 flex items-center justify-center"
                                                            style="display: none;"
                                                            aria-live="polite"
                                                        >
                                                            <div class="h-6 w-6 border-2 border-gold border-t-transparent rounded-full animate-spin"></div>
                                                        </div>
                                                        <div 
                                                            x-show="hasError" 
                                                            class="absolute inset-0 flex items-center justify-center gap-3 text-xs text-red-600 bg-skin-base/80"
                                                            style="display: none;"
                                                            role="alert"
                                                        >
                                                            <span x-text="errorMessage"></span>
                                                            <a :href="src" target="_blank" class="px-2 py-1 rounded bg-red-600 text-white">Download</a>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 flex items-center gap-2">
                                                        <span class="text-[12px] text-skin-text-muted font-medium" :aria-label="'Current time '+formattedCurrent" x-text="formattedCurrent"></span>
                                                        <input 
                                                            type="range" 
                                                            min="0" max="100" step="0.5" 
                                                            :value="progress" 
                                                            @input="seek($event)" 
                                                            class="flex-1 accent-umera-600"
                                                            aria-label="Seek position"
                                                            :aria-valuemin="0" 
                                                            :aria-valuemax="100" 
                                                            :aria-valuenow="Math.round(progress)"
                                                        >
                                                        <span class="text-[12px] text-skin-text-muted font-medium" :aria-label="'Total duration '+formattedDuration" x-text="formattedDuration"></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="w-28 flex items-center gap-2">
                                                    <svg class="h-4 w-4 text-skin-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5L6 9H3v6h3l5 4V5z"/>
                                                    </svg>
                                                    <input 
                                                        type="range" 
                                                        min="0" max="1" step="0.05" 
                                                        :value="volume" 
                                                        @input="setVolume($event)" 
                                                        class="flex-1 accent-gold"
                                                        aria-label="Volume"
                                                        :aria-valuemin="0" 
                                                        :aria-valuemax="1" 
                                                        :aria-valuenow="volume"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @php
                                            $filePath = '/storage/'.$message->attachment_path;
                                        @endphp
                                        <a href="{{ $filePath }}" target="_blank" class="flex items-center gap-2 p-2 bg-black/10 rounded-lg hover:bg-black/20 transition-colors">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            <span class="text-xs truncate">{{ $message->original_filename }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <p class="text-[10px] mt-1 text-right opacity-70">
                                {{ $message->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center h-full text-skin-text-muted">
                    <svg class="h-16 w-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-sm">No messages yet. Start the conversation!</p>
                </div>
            @endforelse
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t border-skin-border bg-skin-base-sec" x-data="chatHandler()">
            <!-- Voice Recording UI -->
            <div x-show="isRecording" class="absolute inset-x-0 bottom-0 p-4 bg-skin-base border-t border-skin-border flex items-center justify-between z-10" style="display: none;">
                <div class="flex items-center gap-3 text-red-500 animate-pulse">
                    <div class="h-3 w-3 rounded-full bg-red-500"></div>
                    <span class="text-sm font-medium" x-text="recordingTime">00:00</span>
                </div>
                <div class="flex items-center gap-4">
                    <button @click="cancelRecording" type="button" class="text-skin-text-muted hover:text-skin-text text-sm">Cancel</button>
                    <button @click="stopAndSendRecording" type="button" class="bg-umera-600 text-white p-2 rounded-full hover:bg-umera-700 shadow-md">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Normal Input UI -->
            <form action="{{ route('chat.store', $receiver->id) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-3" x-ref="form">
                @csrf
                
                <!-- Attachments Button -->
                <div class="relative" x-data="{ open: false }">
                    <button type="button" @click="open = !open" class="p-2 text-skin-text-muted hover:text-skin-text hover:bg-skin-base-ter rounded-full transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute bottom-full left-0 mb-2 w-40 bg-skin-base rounded-lg shadow-xl border border-skin-border overflow-hidden z-20" style="display: none;">
                        <label class="block px-4 py-2 hover:bg-skin-base-ter cursor-pointer text-sm text-skin-text flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Image/File
                            <input type="file" name="attachment" class="hidden" @change="updateFile">
                        </label>
                    </div>
                </div>

                <!-- Text Input -->
                <div class="flex-1 bg-skin-base rounded-2xl border border-skin-border focus-within:ring-2 focus-within:ring-umera-500 focus-within:border-transparent transition-all">
                    <textarea name="message" rows="1" 
                              class="w-full bg-transparent border-none focus:ring-0 p-3 max-h-32 resize-none text-sm" 
                              placeholder="Type a message..."
                              @input="updateText"></textarea>
                    <div class="px-3 pb-2 text-xs text-skin-text-muted truncate" x-ref="fileName"></div>
                </div>

                <!-- Mic Button (Show if no text) / Send Button -->
                <button type="button" @click="startRecording" x-show="!hasText && !hasFile" class="p-3 bg-skin-base-ter text-skin-text rounded-full hover:bg-skin-base-quat transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                    </svg>
                </button>

                <button type="submit" x-show="hasText || hasFile" class="p-3 bg-umera-600 text-white rounded-full hover:bg-umera-700 transition-colors shadow-md" style="display: none;">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function chatHandler() {
        return {
            isRecording: false,
            recordingTime: '00:00',
            mediaRecorder: null,
            audioChunks: [],
            timerInterval: null,
            startTime: null,
            text: '',
            fileSelected: false,
            selectedMime: '',
            selectedExt: 'webm',
            
            get hasText() { return this.text.length > 0; },
            get hasFile() { return this.fileSelected; },

            updateText(e) {
                this.text = e.target.value;
                e.target.style.height = 'auto'; 
                e.target.style.height = Math.min(e.target.scrollHeight, 128) + 'px';
            },

            updateFile(e) {
                this.fileSelected = e.target.files.length > 0;
                this.$refs.fileName.innerText = this.fileSelected ? e.target.files[0].name : '';
                this.open = false; // Close dropdown
            },

            async startRecording() {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    alert('Microphone access requires a secure connection (HTTPS) or localhost. You appear to be accessing via HTTP IP address.');
                    return;
                }

                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    const preferred = [
                        'audio/webm;codecs=opus',
                        'audio/webm',
                        'audio/mp4',
                        'audio/mpeg'
                    ];
                    let mime = '';
                    for (const t of preferred) {
                        if (typeof MediaRecorder !== 'undefined' && MediaRecorder.isTypeSupported && MediaRecorder.isTypeSupported(t)) {
                            mime = t; break;
                        }
                    }
                    this.selectedMime = mime || 'audio/webm';
                    if (this.selectedMime.includes('mp4')) this.selectedExt = 'mp4';
                    else if (this.selectedMime.includes('mpeg')) this.selectedExt = 'mp3';
                    else this.selectedExt = 'webm';
                    this.mediaRecorder = new MediaRecorder(stream, mime ? { mimeType: mime } : undefined);
                    this.audioChunks = [];

                    this.mediaRecorder.ondataavailable = (event) => {
                        this.audioChunks.push(event.data);
                    };

                    this.mediaRecorder.start();
                    this.isRecording = true;
                    this.startTime = Date.now();
                    
                    this.timerInterval = setInterval(() => {
                        const diff = Date.now() - this.startTime;
                        const date = new Date(diff);
                        this.recordingTime = date.toISOString().substr(14, 5);
                    }, 1000);

                } catch (err) {
                    console.error('Error accessing microphone:', err);
                    
                    if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                        alert('Microphone permission denied. Please allow access in your browser settings.');
                    } else if (err.name === 'NotFoundError') {
                        alert('No microphone found on this device.');
                    } else {
                        alert('Could not access microphone. Ensure you are using HTTPS or localhost. Error: ' + err.message);
                    }
                }
            },

            cancelRecording() {
                if (this.mediaRecorder && this.isRecording) {
                    this.mediaRecorder.stop();
                    this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
                }
                this.isRecording = false;
                clearInterval(this.timerInterval);
                this.recordingTime = '00:00';
            },

            stopAndSendRecording() {
                if (this.mediaRecorder && this.isRecording) {
                    this.mediaRecorder.onstop = () => {
                        const audioBlob = new Blob(this.audioChunks, { type: this.selectedMime || 'audio/webm' });
                        const filename = `voice_note.${this.selectedExt}`;
                        const file = new File([audioBlob], filename, { type: this.selectedMime || 'audio/webm' });
                        
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        
                        let voiceInput = document.querySelector('input[name="voice_note"]');
                        if (!voiceInput) {
                            voiceInput = document.createElement('input');
                            voiceInput.type = 'file';
                            voiceInput.name = 'voice_note';
                            voiceInput.className = 'hidden';
                            this.$refs.form.appendChild(voiceInput);
                        }
                        
                        voiceInput.files = dataTransfer.files;
                        this.$refs.form.submit();
                    };

                    this.mediaRecorder.stop();
                    this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
                    this.isRecording = false;
                    clearInterval(this.timerInterval);
                }
            }
        }
    }

    function voicePlayer(src) {
        return {
            src,
            audio: null,
            isPlaying: false,
            duration: 0,
            currentTime: 0,
            progress: 0,
            volume: 1,
            isBuffering: false,
            hasError: false,
            errorMessage: '',
            unsupported: false,
            formattedCurrent: '00:00',
            formattedDuration: '00:00',
            canvasEl: null,
            waveformData: [],
            _id: Math.random().toString(36).slice(2),
            fakeWaveRAF: null,
            fakePhase: 0,
            init() {
                this.audio = new Audio(this.src);
                this.audio.preload = 'auto';
                this.audio.volume = this.volume;
                this.audio.crossOrigin = 'anonymous';
                this.canvasEl = this.$refs.wave;
                const ext = (this.src.split('?')[0].split('.').pop() || '').toLowerCase();
                const mimeMap = {
                    webm: 'audio/webm; codecs=opus',
                    mp4: 'audio/mp4',
                    m4a: 'audio/mp4',
                    mp3: 'audio/mpeg',
                    wav: 'audio/wav',
                    ogg: 'audio/ogg',
                };
                const mimeToTest = mimeMap[ext] || 'audio/mpeg';
                const canPlay = this.audio.canPlayType(mimeToTest);
                this.unsupported = !(canPlay && canPlay.length > 0);
                this.audio.addEventListener('loadedmetadata', () => {
                    this.duration = this.audio.duration || 0;
                    this.formattedDuration = this.format(this.duration);
                    this.resizeCanvas();
                });
                this.audio.addEventListener('timeupdate', () => {
                    this.currentTime = this.audio.currentTime || 0;
                    this.progress = this.duration ? (this.currentTime / this.duration) * 100 : 0;
                    this.formattedCurrent = this.format(this.currentTime);
                    this.updateWaveProgress();
                });
                this.audio.addEventListener('play', () => {
                    this.isPlaying = true;
                    window.dispatchEvent(new CustomEvent('voice-play', { detail: { id: this._id } }));
                    if (this.waveformData.length === 0) this.startFakeWave();
                });
                this.audio.addEventListener('pause', () => {
                    this.isPlaying = false;
                    this.stopFakeWave();
                });
                this.audio.addEventListener('waiting', () => {
                    this.isBuffering = true;
                });
                this.audio.addEventListener('canplay', () => {
                    this.isBuffering = false;
                });
                this.audio.addEventListener('ended', () => {
                    this.isPlaying = false;
                    this.currentTime = 0;
                    this.progress = 0;
                    this.updateWaveProgress(true);
                    this.stopFakeWave();
                });
                this.audio.addEventListener('error', () => {
                    this.isPlaying = false;
                    this.isBuffering = false;
                    this.errorMessage = this.unsupported ? 'Unsupported audio format in this browser' : 'Playback failed';
                    this.hasError = true;
                    this.stopFakeWave();
                });
                window.addEventListener('voice-play', (e) => {
                    if (e.detail && e.detail.id !== this._id && this.isPlaying) {
                        this.audio.pause();
                    }
                });
                if (window.AudioContext || window.webkitAudioContext) {
                    this.renderWave();
                }
                window.addEventListener('resize', () => this.resizeCanvas());
            },
            toggle() {
                if (this.hasError && this.unsupported) return;
                if (!this.isPlaying) {
                    const tryPlay = () => this.audio.play().catch((err) => { 
                        this.isPlaying = false; 
                        if (this.unsupported) {
                            this.errorMessage = 'Unsupported audio format in this browser';
                            this.hasError = true;
                            return;
                        }
                        this.isBuffering = true;
                        const onReady = () => {
                            this.isBuffering = false;
                            this.audio.removeEventListener('canplay', onReady);
                            this.audio.play().catch(() => {
                                this.errorMessage = 'Playback failed';
                                this.hasError = true;
                            });
                        };
                        this.audio.addEventListener('canplay', onReady, { once: true });
                    });
                    if (this.audio.readyState >= 2) {
                        tryPlay();
                    } else {
                        this.audio.load();
                        tryPlay();
                    }
                } else {
                    this.audio.pause();
                }
            },
            seek(e) {
                const val = parseFloat(e.target.value);
                const time = this.duration * (val / 100);
                if (!isNaN(time)) this.audio.currentTime = time;
            },
            waveSeek(e) {
                const rect = this.canvasEl.getBoundingClientRect();
                const ratio = (e.clientX - rect.left) / rect.width;
                const time = Math.max(0, Math.min(this.duration, this.duration * ratio));
                this.audio.currentTime = time;
            },
            setVolume(e) {
                const v = parseFloat(e.target.value);
                this.volume = Math.max(0, Math.min(1, isNaN(v) ? this.volume : v));
                if (this.audio) this.audio.volume = this.volume;
            },
            format(t) {
                const m = Math.floor((t || 0) / 60);
                const s = Math.floor((t || 0) % 60);
                return `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
            },
            resizeCanvas() {
                if (!this.canvasEl) return;
                const w = Math.max(260, Math.min(520, this.canvasEl.clientWidth || 420));
                this.canvasEl.width = w;
                this.canvasEl.height = 56;
                this.drawWaveform();
            },
            renderWave() {
                const AudioCtx = window.AudioContext || window.webkitAudioContext;
                const ctx = new AudioCtx();
                fetch(this.src)
                    .then(r => r.arrayBuffer())
                    .then(b => new Promise((resolve, reject) => {
                        const fn = ctx.decodeAudioData(b, resolve, reject);
                        if (fn && typeof fn.then === 'function') fn.then(resolve).catch(reject);
                    }))
                    .then(buffer => {
                        const data = buffer.getChannelData(0);
                        const bars = 160;
                        const step = Math.floor(data.length / bars);
                        const values = [];
                        for (let i = 0; i < bars; i++) {
                            const start = i * step;
                            let min = 1.0, max = -1.0;
                            for (let j = 0; j < step; j++) {
                                const v = data[start + j];
                                if (v < min) min = v;
                                if (v > max) max = v;
                            }
                            values.push((max - min) / 2);
                        }
                        this.waveformData = values;
                        this.drawWaveform();
                    })
                    .catch(() => {});
            },
            drawWaveform() {
                if (!this.canvasEl || this.waveformData.length === 0) return;
                const c = this.canvasEl;
                const g = c.getContext('2d');
                const w = c.width, h = c.height;
                g.clearRect(0,0,w,h);
                const barW = w / this.waveformData.length;
                for (let i=0;i<this.waveformData.length;i++) {
                    const val = this.waveformData[i];
                    const barH = Math.max(4, val * (h-6));
                    const x = i * barW;
                    const y = (h - barH)/2;
                    g.fillStyle = 'rgba(184, 151, 106, 0.6)';
                    g.fillRect(x, y, Math.max(1, barW*0.78), barH);
                }
                this.updateWaveProgress();
            },
            updateWaveProgress(reset=false) {
                if (!this.canvasEl || this.waveformData.length === 0) return;
                const c = this.canvasEl;
                const g = c.getContext('2d');
                const w = c.width, h = c.height;
                const x = reset ? 0 : Math.max(0, Math.min(w, (this.progress/100) * w));
                g.fillStyle = '#89070633';
                g.fillRect(0,0,x,h);
            },
            startFakeWave() {
                if (!this.canvasEl) return;
                const c = this.canvasEl;
                const g = c.getContext('2d');
                const w = c.width, h = c.height;
                const bars = 160;
                const barW = w / bars;
                const loop = () => {
                    if (!this.isPlaying || this.waveformData.length) return;
                    g.clearRect(0,0,w,h);
                    for (let i=0;i<bars;i++) {
                        const amp = 0.3 + 0.2*Math.sin((i*0.15)+this.fakePhase) + 0.1*Math.sin((i*0.05)+this.fakePhase*1.7);
                        const barH = Math.max(4, amp * (h-6));
                        const x = i * barW;
                        const y = (h - barH)/2;
                        g.fillStyle = 'rgba(184, 151, 106, 0.6)';
                        g.fillRect(x, y, Math.max(1, barW*0.78), barH);
                    }
                    const xProg = Math.max(0, Math.min(w, (this.progress/100)*w));
                    g.fillStyle = '#89070633';
                    g.fillRect(0,0,xProg,h);
                    this.fakePhase += 0.06;
                    this.fakeWaveRAF = requestAnimationFrame(loop);
                };
                this.fakeWaveRAF = requestAnimationFrame(loop);
            },
            stopFakeWave() {
                if (this.fakeWaveRAF) cancelAnimationFrame(this.fakeWaveRAF);
                this.fakeWaveRAF = null;
            },
            handleKey(e) {
                if (e.key === ' ' || e.key === 'Spacebar') {
                    e.preventDefault();
                    this.toggle();
                } else if (e.key === 'ArrowRight') {
                    this.audio.currentTime = Math.min(this.duration, this.audio.currentTime + 5);
                } else if (e.key === 'ArrowLeft') {
                    this.audio.currentTime = Math.max(0, this.audio.currentTime - 5);
                } else if (e.key === 'ArrowUp') {
                    this.setVolume({ target: { value: Math.min(1, this.volume + 0.05) } });
                } else if (e.key === 'ArrowDown') {
                    this.setVolume({ target: { value: Math.max(0, this.volume - 0.05) } });
                }
            }
        }
    }

    // Scroll to bottom
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
