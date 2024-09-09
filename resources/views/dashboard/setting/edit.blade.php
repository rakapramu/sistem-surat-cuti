@extends('layouts.admin')
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Setting</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('setting.update',$setting->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Instansi</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('nama_instansi')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="nama_instansi" autocomplete="off"
                                    value="{{ $setting->nama_instansi }}" />
                                @error('nama_instansi')
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
                                    value="{{ $setting->kode_pos }}" />
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
                                    value="{{ $setting->faks }}" />
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
                                    value="{{ $setting->alamta_instansi }}" />
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
                                    value="{{ $setting->no_telp }}" />
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
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="email" autocomplete="off"
                                    value="{{ $setting->email }}" />
                                @error('email')
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
                                    value="{{ $setting->laman_web }}" />
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
