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
                            <input type="date" name="date1" id="date1" class="form-control">
                        </div>
                        <div class="input group mb-3">
                            <label for="label">Tanggal Akhir</label>
                            <input type="date" name="date2" id="date2" class="form-control">
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