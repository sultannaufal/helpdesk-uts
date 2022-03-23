@extends('layouts.app')
@section('title', 'Cetak Laporan')
@section('content')
@include('layouts.headers.main')
    <div class="container-fluid mt--7">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header">Pilih Tanggal</div>
                    <div class="card-body">
                        <div class="input group mb-3">
                            <label for="label">Tanggal Awal</label>
                            <x-flat-pickr name="date1" format="YYYY-MM-DD" class="form-control" />
                        </div>
                        <div class="input group mb-3">
                            <label for="label">Tanggal Akhir</label>
                            <x-flat-pickr name="date2" format="YYYY-MM-DD" class="form-control" />
                        </div>
                        <div class="input group mb-3">
                            <a href="" onclick="this.href='/print/'+ document.getElementById('date1').value + '/' + document.getElementById('date2').value" target="_blank" class="btn btn-primary">Cetak</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
