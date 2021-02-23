<h1>Pengaduan Baru Telah Dibuat</h1>

<b>Oleh</b>: {{ $ticket->client->name }}<br>
<b>Judul</b>: {{ $ticket->theme }}<br>
<b>Komentar</b>: {{ $ticket->content }}<br>

@component('mail::button', ['url' => $ticketRoute])
    Buka Aplikasi
@endcomponent
