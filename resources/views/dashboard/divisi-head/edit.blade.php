@extends('layouts.admin')
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Data Atasan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('divisi-head.update', $divisiHead->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <h3>Informasi User</h3>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Atasan</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control @error('name')
                                        is-invalid
                                    @enderror"
                                        id="basic-default-name" name="name" autocomplete="off"
                                        value="{{ $divisiHead->user->name }}" />
                                    @error('name')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Email Atasan</label>
                                <div class="col-sm-10">
                                    <input type="email"
                                        class="form-control @error('email')
                                        is-invalid
                                    @enderror"
                                        id="basic-default-name" name="email" autocomplete="off"
                                        value="{{ $divisiHead->user->email }}" />
                                    @error('email')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nip Atasan</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control @error('nip')
                                        is-invalid
                                    @enderror"
                                        id="basic-default-name" name="nip" autocomplete="off"
                                        value="{{ $divisiHead->user->nip }}" />
                                    @error('nip')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Pangkat</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control @error('pangkat')
                                        is-invalid
                                    @enderror"
                                        id="basic-default-name" name="pangkat" autocomplete="off"
                                        value="{{ $divisiHead->user->pangkat }}" />
                                    @error('pangkat')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Jabatan</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control @error('jabatan')
                                        is-invalid
                                    @enderror"
                                        id="basic-default-name" name="jabatan" autocomplete="off"
                                        value="{{ $divisiHead->user->jabatan }}" />
                                    @error('jabatan')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Detail Divisi dan Level Atasan</h3>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Level Atasan</label>
                                <div class="col-sm-10">
                                    <select name="level"
                                        class="form-select @error('level')
                                        is-invalid
                                    @enderror"
                                        id="">
                                        <option value="" disabled selected>Pilih Level Atasan</option>
                                        <option value="1" @if ($divisiHead->level == 1) selected @endif>Atasan 1
                                        </option>
                                        <option value="2" @if ($divisiHead->level == 2) selected @endif>Atasan 2
                                        </option>
                                    </select>
                                    @error('level')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Divisi</label>
                                <div class="col-sm-10">
                                    <select name="divisi_id"
                                        class="form-select @error('divisi_id')
                                        is-invalid
                                    @enderror"
                                        id="">
                                        <option value="" disabled selected>Pilih Level Atasan</option>
                                        @foreach ($divisi as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $divisiHead->divisi_id ? 'selected' : '' }}>
                                                {{ ucwords($item->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('level')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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
