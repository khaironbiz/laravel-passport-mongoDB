@extends('layout.user')
@section('content')

    <!-- Main content -->

        <section class="content mb-5">
            <div class="container-fluid">
                @if(\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {!! \Session::get('success') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif(\Session::has('danger'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        {!! \Session::get('danger') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-5">
                    @include('user.profile.menu')
                    <!-- /.col -->
                    <div class="col-lg-9 col-md-8 col-sm-6">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#observation" data-toggle="tab">Health Over View</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#laporan" data-toggle="tab">Resume</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#family" data-toggle="tab">Family</a></li>
                                    @if($user->level != "user")
                                        <li class="nav-item"><a class="nav-link" href="#organisasi" data-toggle="tab">Organisasi</a></li>
                                    @endif
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="observation">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-striped table-sm" id="example1">
                                                    <thead class="bg-secondary">
                                                    <th>No</th>
                                                    <th>Observation</th>
                                                    <th>Value</th>
                                                    <th>Interpretation</th>
                                                    <th>Base Line</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($observation as $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->coding['display'] }}<br> <small>{{ date('Y-m-d H:i', $data->time) }}</small> </td>
                                                            <td>{{ $data->value }} <br> <small>{{ $data->unit['display'] }}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="family">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-striped table-sm" id="exaple1">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>DOB</th>
                                                        <th>NIK</th>
                                                        <th>Gender</th>
                                                        <th>Hubungan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($family as $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->nama['nama_depan'] }}</td>
                                                            <td>{{ $data->lahir['tanggal'] }}</td>
                                                            <td>{{ $data->nik }}</td>
                                                            <td>{{ $data->gender }}</td>
                                                            <td>{{ $data->family['hubungan_keluarga'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="laporan">

                                        <table class="table table-sm table-striped table-responsive">
                                            <thead>
                                            <th>#</th>
                                            <th>Observation</th>
                                            <th>Time</th>
                                            <th>Value</th>
                                            <th>Unit</th>
                                            <th>Label</th>
                                            </thead>
                                            <tbody>
                                            @foreach($resume as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if($data != null)
                                                            {{ $data->coding->display }}
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if($data != null)
                                                            {{ date('d-m-Y H:i', $data->time) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data != null)
                                                            {{ round($data->value,2) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data != null)
                                                            {{ $data->unit->display }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data != null)
                                                            @if($data->interpretation != null)
                                                                {{ $data->interpretation->display }}
                                                            @endif
                                                        @endif


                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane mb-5" id="organisasi">
                                        <b>Organisasi</b>
                                        <div class="row mb-1">
                                            <label class="col-sm-2">Level</label>
                                            <div class="col-sm-10">{{ $user->level }}</div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-2">Organisasi</label>
                                            <div class="col-sm-10">
                                                @if(! empty($user->organisasi))
                                                    {{ $user->organisasi['name'] }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-2">Status</label>
                                            <div class="col-sm-10">
                                                @if(! empty($user->organisasi))
                                                    {{ $user->organisasi['status'] }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-2">Nakes</label>
                                            <div class="col-sm-10">
                                                @if($user->is_nakes == true)
                                                    {{ "Nakes" }}
                                                @else
                                                    {{ "Non Nakes" }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editOrganisasi">
                                                Edit
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="editOrganisasi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Update Organisasi</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('profile.update.organisasi') }}" method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row mb-1">
                                                                    <label class="col-sm-3 col-form-label">Organisasi</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control" name="organisasi">
                                                                            <option></option>
                                                                            @foreach($customers as $data)
                                                                                <option value="{{ $data->_id }}"
                                                                                @if($user->organisasi != null)
                                                                                    @if($user->organisasi['id'] == $data->_id)
                                                                                    {{ "selected" }}
                                                                                        @endif
                                                                                @endif
                                                                                >{{ $data->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-1">
                                                                    <label class="col-sm-3 col-form-label">Petugas Kesehatan</label>
                                                                    <div class="col-sm-9">
                                                                        <select class="form-control" name="is_nakes">
                                                                            <option value="N">Tidak</option>
                                                                            <option value="Y" @if($user->is_nakes == true) {{ "selected" }} @endif>Ya</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save Change</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>

                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
@endsection
