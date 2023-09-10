<div class="card">
    <div class="card-header">
        <h3 class="card-title">Buat Kunjungan Baru</h3>
    </div>
    <div class="card-body">
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Nama Faskes</label>
            <div class="col-sm-9">
                <select class="form-control" name="id_faskes">
                    <option value="{{ $customer->_id }}">{{ $customer->name }}</option>
                </select>
                @error('id_faskes')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Nama Pasien</label>
            <div class="col-sm-9">
                <select class="form-control" name="id_pasien">
                    <option value="{{ $user->_id }}">{{ $user->nama['nama_depan']." ".$user->nama['nama_belakang'] }}</option>
                </select>
                @error('id_pasien')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Tanggal</label>
            <div class="col-sm-9">
                <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                @error('date')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>
    </div>

</div>
