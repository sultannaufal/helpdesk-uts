@extends('layouts.print')

@section('content')
<div class="form-group">
    @if($reportDate->isNotEmpty())
    <h1 align="center"><b>Laporan Data Pengaduan</b></h1><br>
    <table class="table table-bordered" align="center" rules="all" border="1px" style="width: 95%;">
        <thead class="thead-light">
            <tr>
            <th>Judul</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Pada</th>
            </tr>
        </thead>
        @foreach($reportDate as $item)
            <tr>
                <td>{{ $item->theme }}</a></td>
                <td>{{ $item->location->loc ?? 'Belum ditentukan' }}</td>
                <td>{{ $item->getStatusLabel() }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
        @endforeach
    </table>
    @else
        <p class="text-center">Tidak Ada Data</p>
    @endif
</div>
<script type="text/javascript">
    window.print();
</script>
@endsection