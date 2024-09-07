@extends('layouts.admin')
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Data Jenis Cuti</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('cuti.update', $cuti->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Jenis Cuti</label>
                            <div class="col-sm-10">
                                <input type="text"
                                    class="form-control @error('jenis_cuti')
                                    is-invalid
                                @enderror"
                                    id="basic-default-name" name="jenis_cuti" autocomplete="off"
                                    value="{{ $cuti->jenis_cuti }}" />
                                @error('jenis_cuti')
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
