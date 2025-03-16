@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($level)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan! </h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/level/' . $level->level_kode) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode Level</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kode" name="kode"
                                   value="{{ old('kode', $level->level_kode) }}" required>
                            @error('kode')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama Level</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $level->level_nama) }}"
                                   required>
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('user') }}">Kembali</a>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    @endsection

    @push('css')
    @endpush
    @push('js')
    @endpush
