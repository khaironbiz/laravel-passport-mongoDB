@extends('layout.user')
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('service.create') }}" class="btn btn-sm btn-primary">Add Data</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-striped" id="example1">
                            <thead>
                            <th>#</th>
                            <th>Date</th>
                            <th>Nama</th>
                            <th>Tujuan</th>
                            <th>Jaminan</th>
                            <th>Aksi</th>
                            </thead>
                            <tbody>
                            @foreach($services as $data)
                                <tr>

                                    <td></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
