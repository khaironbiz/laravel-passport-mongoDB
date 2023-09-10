<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create New Patien</h3>
    </div>
    <div class="card-body">
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Kode Perusahaan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="code" value="{{ $customer->code, old('code') }}">
                @error('code')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Nama Perusahaan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name" value="{{ $customer->name, old('name') }}">
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" name="hp" value="{{ $customer->hp, old('hp') }}">
                @error('hp')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
                <input type="email" class="form-control" name="email" value="{{ $customer->email, old('email') }}">
                @error('email')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Website</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="website" value="{{ $customer->website, old('website') }}">
                @error('website')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">NIK PIC</label>
            <div class="col-sm-9">
                <small class="text-success">{{"PIC Lama : ".$customer->pic}}</small>
                <input type="number" class="form-control" name="nik_pic" value="{{ $customer->pic, old('nik_pic') }}">
                @error('nik_pic')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-9">
                <textarea name="alamat" class="form-control">{{ $customer->alamat, old('alamat') }}</textarea>
                @error('alamat')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Kode Post</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" name="postal" value="{{ $customer->postal, old('postal') }}">
                @error('postal')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>
