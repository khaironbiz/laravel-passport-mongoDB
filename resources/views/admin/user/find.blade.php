
@extends('layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-dark">
                            <b>{{ $title }}</b>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">NIK</label>
                                                <input type="number" class="form-control" placeholder="NIK" name="nik" value="{{ $nik }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(! empty($nik))
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <thead>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Gender</th>
                                                <th>DOB</th>
                                                <th>Aksi</th>
                                                </thead>
                                                <tbody>
                                                @foreach($users as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->nama['nama_depan']." ".$data->nama['nama_belakang'] }}</td>
                                                        <td>{{ $data->gender }}</td>
                                                        <td>{{ $data->lahir['tanggal'] }}</td>
                                                        <td>
                                                            <a href="{{ route('admission.create', ['id_user'=>$data->_id, 'id_customer'=> \Illuminate\Support\Facades\Auth::user()->organisasi['id']]) }}" class="btn btn-sm btn-primary">Kunjungan</a>
                                                            <a href="" class="btn btn-sm btn-info">Detail</a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
    </section>
@endsection
