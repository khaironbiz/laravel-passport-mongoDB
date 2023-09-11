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
                        <div class="card-header bg-info">
                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin == true)
                                @include('layout.menu.admin.submenu.master')
                            @endif

                        </div>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header bg-dark"><b>Create Master {{ $title }}</b></div>
                                    <form action="{{ route('kits.store') }}" method="post">
                                        @csrf
                                        @include('user.kits._form')
                                        <diV class="card-footer">
                                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin == true)
                                                <a href="{{ route('kits.index') }}" class="btn btn-warning">Back</a>
                                            @else
                                                <a href="{{ route('customers.show',['id'=>\Illuminate\Support\Facades\Auth::user()->organisasi['id']]) }}" class="btn btn-warning">Back</a>
                                            @endif
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
