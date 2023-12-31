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
                        <form action="{{ route('users.store') }}" method="post">
                            @csrf
                            @include('admin.user._form')
                            <div class="card-footer text-center">
                                <a href="{{ route('users.index') }}" class="btn btn-danger">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
    </section>
@endsection
