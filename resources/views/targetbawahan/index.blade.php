@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-responsive-sm table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Nama Pegawai</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                            @foreach ($users as $u)
                                <tr>
                        </thead>
                        <tbody>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $u->nip }}</td>
                            <td class="text-center">{{ $u->name }}</td>
                            <td class="text-center">{{ $u->unit->name }}</td>
                            <td class="text-center">{{ optional($u->target->last())->status }}</td>


                            </td>
                            <td class="text-center">
                                <a href="{{ route('statustarget', $u->nip) }}" button type="button"
                                    class="btn btn-success">
                                    <i class="cil-pencil"></i>
                                </a>
                            </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
