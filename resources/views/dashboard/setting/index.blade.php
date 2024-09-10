@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Jenis Cuti</h5>
            @if ($datas->count() < 1)
                <a href="{{ route('setting.create') }}" class="btn btn-primary mx-2">Create Data</a>
            @endif
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover my-5">
                <thead>
                    <tr>
                        <th>Nama Instansi</th>
                        <th>Alamat Instansi</th>
                        <th>No Telp</th>
                        <th>Faks</th>
                        <th>Email</th>
                        <th>Laman Web</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($datas as $item)
                        <tr>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                <strong>{{ ucwords($item->nama_instansi) }}</strong>
                            </td>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                <strong>{{ ucwords($item->alamta_instansi) }}</strong>
                            </td>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                <strong>{{ $item->no_telp }}</strong>
                            </td>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                <strong>{{ $item->faks }}</strong>
                            </td>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                <strong>{{ $item->email }}</strong>
                            </td>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                <strong>{{ $item->no_telp }}</strong>
                            </td>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                <strong>{{ $item->laman_web }}</strong>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('setting.edit', $item->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form id="delete-{{ $item->id }}"
                                            action="{{ route('setting.destroy', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('delete')
                                        </form>

                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('delete-{{ $item->id }}').submit();">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
