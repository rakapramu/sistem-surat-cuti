@extends('layouts.admin')
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Pengajuan Cuti</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengajuan_cuti.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nama Lengkap</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ Auth::user()->name }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">NIP</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ Auth::user()->nip }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Pangkat/Jabatan</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ Auth::user()->jabatan }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Pangkat/Jabatan</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ Auth::user()->email }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-phone">Jenis Cuti Yang Diambil</label>
                            <select name="cuti_id"
                                class="form-select @error('cuti_id')
                                is-invalid
                            @enderror"
                                id="">
                                <option disabled selected>--Pilih Cuti--</option>
                                @foreach ($cutis as $item)
                                    <option value="{{ $item->id }}">{{ ucwords($item->jenis_cuti) }}</option>
                                @endforeach
                            </select>
                            @error('cuti_id')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal_mulai_cuti">Tanggal Mulai Cuti</label>
                            <input type="text" id="tanggal_mulai_cuti"
                                class="form-control @error('tanggal_mulai_cuti')
                                is-invalid
                            @enderror"
                                name="tanggal_mulai_cuti" value="{{ old('tanggal_mulai_cuti') }}" autocomplete="off">
                            @error('tanggal_mulai_cuti')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal_selesai_cuti">Tanggal Selesai Cuti</label>
                            <input type="text" id="tanggal_selesai_cuti"
                                class="form-control @error('tanggal_selesai_cuti')
                                is-invalid
                            @enderror"
                                name="tanggal_selesai_cuti" value="{{ old('tanggal_selesai_cuti') }}" autocomplete="off">
                            @error('tanggal_selesai_cuti')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Alasan Cuti</label>
                            <textarea id="basic-default-message"
                                class="form-control @error('alasan_cuti')
                                is-invalid
                            @enderror"
                                name="alasan_cuti">{{ old('alasan_cuti') }}</textarea>
                            @error('alasan_cuti')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#tanggal_mulai_cuti').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
            $('#tanggal_selesai_cuti').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@endpush
