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
                            <th class="text-center">Actions</th>
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
                                    <select name="status" class="form-select update-status" data-id="{{ $item->id }}">
                                        <option value="disetujui" {{ $item->status == 'disetujui' ? 'selected' : '' }}>
                                            Disetujui</option>
                                        <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>Ditolak
                                        </option>
                                        <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>
                                            Diproses
                                        </option>
                                    </select>
                                </td>
                                <td class="text-end pdf-container">
                                    @if ($item->status == 'disetujui')
                                        <a class="dropdown-item" href="{{ route('cetak', $item->id) }}">
                                            <i class="bx bxs-file-pdf me-1"></i> PDF
                                        </a>                                    
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data Kosong</td>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $('.update-status').change(function() {
                var status = $(this).val();
                var id = $(this).data('id');
                var $pdfContainer = $(this).closest('tr').find('.pdf-container');

                // Lakukan AJAX request
                $.ajax({
                    url: '/dashboard/updateStatus/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        alert('Status updated successfully!');
                        if (status === 'disetujui') {
                            $pdfContainer.html(`
                            <a class="dropdown-item pdf-link" href="/cuti/${id}/edit">
                                <i class="bx bxs-file-pdf me-1"></i> PDF
                            </a>
                        `);
                        } else {
                            $pdfContainer.html('');
                        }
                    },
                    error: function(response) {
                        alert('Failed to update status!');
                    }
                });
            });
        });
    </script>
@endpush
