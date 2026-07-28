@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Activity Log</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p>Catatan Aktivitas Sistem.</p>
            <table class="table table-bordered">
                <thead><tr><th>Waktu</th><th>User</th><th>Aktivitas</th></tr></thead>
                <tbody><tr><td colspan="3" class="text-center">Belum ada data</td></tr></tbody>
            </table>
        </div>
    </div>
</div>
@endsection