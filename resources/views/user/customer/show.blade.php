@extends('layout.user')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <b>{{ $title }}</b>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $customer->name }}</td>
                                </tr>
                                <tr>
                                    <td>Code</td>
                                    <td>:</td>
                                    <td>{{ $customer->code }}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>:</td>
                                    <td>{{ $customer->hp }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $customer->email }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $customer->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>PIC</td>
                                    <td>:</td>
                                    <td>{{ $customer->pic }}</td>
                                </tr>
                            </table>
                            <a href="{{ route('customers.edit', ['id'=>$customer->_id]) }}" class="btn btn-sm btn-success">Edit</a>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td>Kit Count</td>
                                    <td>:</td>
                                    <td class="w-75">{{ $kits->count(). " Alat" }} </td>
                                </tr>
                                <tr>
                                    <td>Pegawai Count</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Pasien Count</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Kunjungan</td>
                                    <td>:</td>
                                    <td>{{ $admission->count() }}</td>
                                </tr>
                                <tr>
                                    <td>Layanan</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="card-header bg-dark">
                        <b>Kit List</b>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('kits.create') }}" class="btn btn-sm btn-primary">Add Kit</a>
                        <table class="table table-sm table-striped">
                            <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Detail</th>
                            </thead>
                            <tbody>
                            @foreach($kits as $list)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $list->name }}</td>
                                    <td>
                                    @if($list->status == null | $list->status == "active")
                                        <button class="btn btn-sm btn-success">{{ "Active" }}</button>
                                        @elseif($list->status == "stop")
                                            <button class="btn btn-sm btn-danger">{{ $list->status }}</button>

                                    @endif
                                    </td>
                                    <td><a href="{{ route('customers.show', ['id'=>$list->id]) }}" class="btn btn-sm btn-primary">Detail</a></td>
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
