@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-responsive-sm table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kuantitas</th>
                                <th class="text-center">Angka Kredit</th>
                                <th class="text-center">Mutu</th>
                                <th class="text-center">Biaya</th>
                                <th class="text-center">Time</th>
                            </tr>
                            @foreach ($realiation as $t)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $t->kuantitas }}</td>
                                <td class="text-center">{{ $t->kredit}}</td>
                                <td class="text-center">{{ $t->mutu}}</td>
                                <td class="text-center">{{ $t->biaya }}</td>
                                <td class="text-center">{{ $t->waktu }}</td>
                            </tr>
                            @endforeach
                        </thead>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection
