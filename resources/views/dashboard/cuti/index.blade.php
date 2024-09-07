@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Jenis Cuti</h5>
            <a href="{{ route('cuti.create') }}" class="btn btn-primary mx-2">Create Data</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Jenis Cuti</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($datas as $item)
                        <tr>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i>
                                <strong>{{ ucwords($item->jenis_cuti) }}</strong>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('cuti.edit', $item->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form id="delete-{{ $item->id }}"
                                            action="{{ route('cuti.destroy', $item->id) }}" method="POST"
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
                            <td colspan="2" class="text-center">Data Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="container">
                {{ $datas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
