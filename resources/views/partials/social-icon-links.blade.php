<nav class="se-footer-social" aria-label="Social links">
    @foreach ($socialLinks as $socialLink)
        @php($socialLabel = strtolower((string) ($socialLink['label'] ?? '')))
        <a href="{{ $socialLink['url'] }}" target="_blank" rel="noreferrer" aria-label="{{ $socialLink['label'] }}">
            @if ($socialLabel === 'tiktok')
                <svg class="se-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M16.6 5.8A6.1 6.1 0 0 1 15.1 1h-4.2v14.7a3.5 3.5 0 1 1-3-3.5V8a7.7 7.7 0 1 0 7.2 7.7V9.1a10.2 10.2 0 0 0 5.9 1.9V6.9a6.2 6.2 0 0 1-4.4-1.1Z"/>
                </svg>
            @elseif ($socialLabel === 'instagram')
                <svg class="se-social-icon se-social-icon--stroke" viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="3" y="3" width="18" height="18" rx="5"/>
                    <circle cx="12" cy="12" r="4.25"/>
                    <circle class="se-social-icon__dot" cx="17.4" cy="6.7" r="1"/>
                </svg>
            @elseif ($socialLabel === 'linkedin')
                <svg class="se-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5.2 7.8H1.6V22h3.6V7.8ZM3.4 2A2.1 2.1 0 1 0 3.4 6.2 2.1 2.1 0 0 0 3.4 2ZM22.4 13.9c0-4.3-2.3-6.3-5.4-6.3a4.7 4.7 0 0 0-4.2 2.3V7.8H9.2V22h3.6v-7c0-1.9.4-3.7 2.7-3.7 2.3 0 2.3 2.1 2.3 3.8V22h3.6l1-8.1Z"/>
                </svg>
            @else
                <span>{{ $socialLink['label'] }}</span>
            @endif
        </a>
    @endforeach

    @if ($hasWhatsapp)
        <a href="{{ $whatsappUrl }}" target="_blank" rel="noreferrer" aria-label="WhatsApp">
            <svg class="se-social-icon" viewBox="0 0 32 32" aria-hidden="true">
                <path d="M19.11 17.36c-.26-.13-1.53-.76-1.77-.85-.24-.09-.41-.13-.58.13-.17.26-.67.85-.82 1.02-.15.17-.3.2-.56.07-.26-.13-1.09-.4-2.08-1.27-.77-.68-1.29-1.51-1.44-1.77-.15-.26-.02-.4.11-.53.12-.12.26-.3.39-.45.13-.15.17-.26.26-.43.09-.17.04-.33-.02-.46-.07-.13-.58-1.4-.8-1.92-.21-.5-.42-.43-.58-.44h-.5c-.17 0-.45.07-.69.33-.24.26-.91.89-.91 2.16 0 1.27.93 2.5 1.06 2.67.13.17 1.83 2.79 4.43 3.92.62.27 1.11.43 1.49.55.63.2 1.21.17 1.66.1.51-.08 1.53-.63 1.75-1.24.22-.61.22-1.13.15-1.24-.07-.11-.24-.17-.5-.3Z"/>
                <path d="M27.29 15.22c0 6.23-5.06 11.29-11.29 11.29-1.98 0-3.92-.52-5.63-1.5L4.71 26.5l1.53-5.49a11.2 11.2 0 0 1-1.53-5.79C4.71 9 9.77 3.94 16 3.94s11.29 5.06 11.29 11.28Zm-11.29-9.39c-5.18 0-9.39 4.21-9.39 9.39 0 1.82.52 3.59 1.5 5.11l.21.32-.91 3.25 3.33-.88.31.18a9.36 9.36 0 0 0 4.95 1.41c5.18 0 9.39-4.21 9.39-9.39 0-5.18-4.21-9.39-9.39-9.39Z"/>
            </svg>
        </a>
    @endif
</nav>
