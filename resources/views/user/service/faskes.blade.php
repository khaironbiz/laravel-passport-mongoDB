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
                            <th>Nama Faskes</th>
                            <th>Nama Layanan</th>
                            <th>Count</th>
                            <th>Aksi</th>
                            </thead>
                            <tbody>
                            @foreach($services as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @php
                                    $id_faskes = $data->id_faskes;
                                    $customer = \App\Models\Customer::find($id_faskes);
                                    @endphp
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td></td>
                                    <td>
                                        <a href="{{ route('service.show', ['id'=>$data->_id]) }}" class="btn btn-sm btn-info">Detail</a>
                                    </td>
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
