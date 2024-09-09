@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Riawayat Pengajuan Cuti</h5>
            {{-- <a href="{{ route('cuti.create') }}" class="btn btn-primary mx-2">Create Data</a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover my-5" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Jenis Cuti</th>
                            <th>Tanggal Mulai Cuti</th>
                            <th>Tanggal Selesai Cuti</th>
                            <th>Alasan Cuti</th>
                            <th>Status</th> 
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($cutis as $item)
                            <tr>
                                <td>
                                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                    <strong>{{ ucwords($item->user->name) }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->user->nip }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->jenisCuti->jenis_cuti }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->tanggal_mulai_cuti }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->tanggal_selesai_cuti }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->alasan_cuti }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->status }}</strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data Kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        var table;
        $(document).ready(function() {
            $('#dataTable').DataTable({
            dom: 'Bfrtip', // Memungkinkan tombol muncul
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Export Excel'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data Export PDF'
                }
            ]
        });
        });
    </script>
@endpush
