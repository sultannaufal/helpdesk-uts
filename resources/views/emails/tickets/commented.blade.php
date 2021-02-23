<h1>Komentar Baru Pada "{{ $comment->ticket->theme }}"</h1>

<b>Oleh</b>: {{ $comment->user->name }}<br>
<b>Judul</b>: {{ $comment->theme }}<br>
<b>Komentar</b>: {{ $comment->content }}<br>

@component('mail::button', ['url' => $ticketRoute])
    Buka Aplikasi
@endcomponent
