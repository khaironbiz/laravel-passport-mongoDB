@extends('layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-black"><b>{{ $title }}</b></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-striped">
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td class="w-75">{{ $observation->pasien['nama']['nama_depan']." ".$observation->pasien['nama']['nama_belakang'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>:</td>
                                            <td class="w-75">{{ $observation->pasien['gender'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>DOB</td>
                                            <td>:</td>
                                            <td class="w-75">{{ $observation->pasien['lahir']['tanggal'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pemeriksaan</td>
                                            <td>:</td>
                                            <td class="w-75">{{ $observation->coding['display'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Waktu</td>
                                            <td>:</td>
                                            <td class="w-75">{{ date('Y-m-d H:i', $observation->time) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hasil</td>
                                            <td>:</td>
                                            <td class="w-75">{{ $observation->value." ".$observation->unit['display'] }}</td>
                                        </tr>
                                        @if($observation->interpretation != null)
                                            <tr>
                                                <td>Interpretasi</td>
                                                <td>:</td>
                                                <td class="w-75">{{ $observation->interpretation['display'] }}</td>
                                            </tr>
                                        @endif


                                    </table>
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
