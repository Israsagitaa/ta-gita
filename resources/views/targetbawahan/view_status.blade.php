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
                                <th class="text-center">Kegiatan</th>
                                <th class="text-center">Angka Kredit</th>
                                <th class="text-center">Kuantitas</th>
                                <th class="text-center">Mutu</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">Biaya</th>
                            </tr>
                            @foreach ($target as $t)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $t->activities }}</td>
                                <td class="text-center">{{ $t->ak}}</td>
                                <td class="text-center">{{ $t->mutu}}</td>
                                <td class="text-center">{{ $t->quantity }}</td>
                                <td class="text-center">{{ $t->time }}</td>
                                <td class="text-center">{{ $t->cost }}</td>
                            </tr>
                            @endforeach
                        </thead>

                    </table>

                </div>

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group  col-md-12">
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <label>Status</label>
                                <select name="status" id="status" class="form-control ">
                                    <option value="0">Pilih Status</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Not Approved">Not Approved</option>
                                </select>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
