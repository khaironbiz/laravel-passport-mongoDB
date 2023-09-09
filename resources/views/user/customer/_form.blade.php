<div class="card">
    <div class="card-header">
        <h3 class="card-title">Meetings</h3>
    </div>
    <div class="card-body">
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Kode Perusahaan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="code" value="{{ old('code'), $customer->code }}">
                @error('code')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Nama Perusahaan</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name" value="{{ old('name'), $customer->name }}">
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" name="hp" value="{{ old('hp'), $customer->hp }}">
                @error('hp')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
                <input type="email" class="form-control" name="email" value="{{ old('email'), $customer->email }}">
                @error('email')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Website</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="website" value="{{ old('website'), $customer->website }}">
                @error('website')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">NIK PIC</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" name="nik_pic" value="{{ old('nik_pic'), $customer->pic }}">
                @error('nik_pic')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-9">
                <textarea name="alamat" class="form-control">{{ old('alamat'), $customer->alamat }}</textarea>
                @error('alamat')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Kode Post</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" name="postal" value="{{ old('postal'), $customer->postal }}">
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
