
@extends('layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session('danger'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('danger') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card">


                        <div class="card-header bg-black"><b>Daftar Petugas</b></div>

                        <div class="card-body">
                            <!-- Button trigger modal -->

                            <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#staticBackdrop">
                                Add Petugas
                            </button>

                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Organisasi</th>
                                <th>Aksi</th>
                                </thead>
                                <tbody>

                                @foreach($users as $user)

                                    <tr class="@if($user->active == false) bg-warning @endif">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->nama['nama_depan']." ".$user->nama['nama_belakang'] }}</td>
                                        <td>{{ $user->nik }}</td>
                                        <td>{{ $user->kontak['email'] }}</td>
                                        <td>{{ $user->kontak['nomor_telepon'] }}</td>
                                        <td>
                                            @if($user->organisasi != null)
                                                {{ $user->organisasi['name'] }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('observation.petugas', ['id' => $user->id]) }}" class="btn btn-sm btn-info">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('users.petugas.store') }}" method="post">
                                            @csrf
                                            <div class="modal-body">

                                                <div class="row mb-1">
                                                    <label class="col-sm-2 col-form-label">NIK</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" name="nik">
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label class="col-sm-2 col-form-label">Organisasi</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" name="organisasi">
                                                            @foreach($customers as $data)
                                                                <option value="{{ $data->_id }}">{{ $data->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
    </section>
@endsection
