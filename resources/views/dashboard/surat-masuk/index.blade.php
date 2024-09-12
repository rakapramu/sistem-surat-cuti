@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Surat Masuk Permohonan Cuti</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover my-5">
                    <thead>
                        <tr>
                            <th>Nama Pemohon</th>
                            <th>NIP</th>
                            <th>Jenis Cuti</th>
                            <th>Tanggal Mulai Cuti</th>
                            <th>Tanggal Selesai Cuti</th>
                            <th>Alasan Cuti</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($approvals as $item)
                            <tr>
                                <td>
                                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                    <strong>{{ ucwords($item->leaverequest->user->name) }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->leaverequest->user->nip }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->leaverequest->jenisCuti->jenis_cuti }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->leaverequest->tanggal_mulai_cuti }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->leaverequest->tanggal_selesai_cuti }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->leaverequest->alasan_cuti }}</strong>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data Kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="container">
                    {{ $approvals->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.update-status').change(function() {
            var status = $(this).val();
            var id = $(this).data('id');

            // Lakukan AJAX request
            $.ajax({
                url: '/dashboard/updateStatusAtasan/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    alert('Status updated successfully!');
                },
                error: function(response) {
                    alert('Failed to update status!');
                }
            });
        });
    </script>
@endpush
