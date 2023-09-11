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
                        <div class="row mt-2 justify-content-center">
                            <div class="col-lg-10">
                                <div class="card">
                                    <div class="card-header bg-dark"><b>{{ $title }}</b></div>
                                    <form action="{{ route('service.update', ['id'=>$service->_id]) }}" method="post">
                                        @csrf
                                        @include('user.service._form')
                                        <diV class="card-footer">

                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </diV>
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
