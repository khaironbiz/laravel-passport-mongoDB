<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Nama Faskes</label>
            <div class="col-sm-9">
                <select class="form-control" name="id_faskes">
                    <option value="{{ \Illuminate\Support\Facades\Auth::user()->organisasi['id'] }}">{{ \Illuminate\Support\Facades\Auth::user()->organisasi['name'] }}</option>
                </select>
                @error('id_faskes')
                <small class="text-danger"></small>
                @enderror
            </div>
        </div>

        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Category</label>
            <div class="col-sm-9">
                <select class="form-control" name="service_category">
                    <option value="">----</option>
                    @foreach($service_category as $data)
                        <option value="{{ $data['code'] }}"
                                @if($service->category == null)
                                    @else
                                    @if($data['code'] == $service->category['code'])
                                        {{ "selected" }}

                                        @endif
                                    @endif>

                            {{ $data['display'] }}
                        </option>
                    @endforeach

                </select>
                @error('service_category')
                <small class="text-danger"></small>
                @enderror
            </div>
        </div>
        <div class="row mb-1">
            <label class="col-sm-3 col-form-label">Nama Service</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="service_name" value="{{ $service->name }}">
                @error('service_name')
                <small class="text-danger"></small>
                @enderror
            </div>
        </div>
    </div>

</div>
