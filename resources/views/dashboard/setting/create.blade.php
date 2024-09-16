@extends('layouts.admin')
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Data Setting</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('setting.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Instansi</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('nama_instansi')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="nama_instansi" autocomplete="off"
                                    value="{{ old('nama_instansi') }}" />
                                @error('nama_instansi')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Satuan Organisasi</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('satuan_organisasi')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="satuan_organisasi" autocomplete="off"
                                    value="{{ old('satuan_organisasi') }}" />
                                @error('satuan_organisasi')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Pimpinan</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('nama_pimpinan')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="nama_pimpinan" autocomplete="off"
                                    value="{{ old('nama_pimpinan') }}" />
                                @error('nama_pimpinan')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Email Pimpinan</label>
                            <div class="col-sm-10">
                                <input type="email"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="email" autocomplete="off" value="{{ old('email') }}" />
                                @error('email')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Jabatan Pimpinan</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('jabatan_pimpinan')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="jabatan_pimpinan" autocomplete="off"
                                    value="{{ old('jabatan_pimpinan') }}" />
                                @error('jabatan_pimpinan')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">NIP Pimpinan</label>
                            <div class="col-sm-10">
                                <input type="number"
                                    class="form-control @error('nip_jabatan')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="nip_jabatan" autocomplete="off"
                                    value="{{ old('nip_jabatan') }}" />
                                @error('nip_jabatan')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Kode Pos</label>
                            <div class="col-sm-10">
                                <input type="number"
                                    class="form-control @error('kode_pos')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="kode_pos" autocomplete="off"
                                    value="{{ old('kode_pos') }}" />
                                @error('kode_pos')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Faks</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('faks')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="faks" autocomplete="off"
                                    value="{{ old('faks') }}" />
                                @error('faks')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Alamat Instansi</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('alamta_instansi')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="alamta_instansi" autocomplete="off"
                                    value="{{ old('alamta_instansi') }}" />
                                @error('alamta_instansi')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('no_telp')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="no_telp" autocomplete="off"
                                    value="{{ old('no_telp') }}" />
                                @error('no_telp')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
                            <div class="col-sm-10">
                                <input type="email"
                                    class="form-control @error('email_setting')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="email_setting" autocomplete="off"
                                    value="{{ old('email_setting') }}" />
                                @error('email_setting')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Laman Web</label>
                            <div class="col-sm-10">
                                <input type="url"
                                    class="form-control @error('laman_web')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="laman_web" autocomplete="off"
                                    value="{{ old('laman_web') }}" />
                                @error('laman_web')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
