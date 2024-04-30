{{-- @extends('layouts.app') --}}

{{-- Customize layout sections --}}

{{-- @section('subtitle', 'kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Create') --}}

{{-- Content body: main Page content --}}
{{-- 
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3>Buat Kategori Baru</h3>
        </div>

        <form method="post" action="../kategori">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="kategori_kode">Kode Kategori</label>
                    <!-- Memindahkan elemen input ke bawah label -->
                    <input id="kategori_kode"
                     type="text" 
                     name="kategori_kode" 
                     placeholder="Masukkan Kode Kategori" 
                     class="form-control @error('kategori_kode') is-invalid @enderror">
                    <!-- Menampilkan pesan error di bawah input -->
                    @error('kategori_kode')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kategori_nama">Nama Kategori</label>
                    <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" placeholder="Masukkan Nama Kategori">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection --}}


@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('kategori') }}" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kode Kategori</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" value="{{ old('kategori_kode') }}" required>
                    @error('kategori_kode')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Nama Kategori</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" value="{{ old('kategori_nama') }}" required>
                    @error('kategori_nama')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('kategori') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<!-- Tambahan CSS jika diperlukan -->
@endpush

@push('js')
<!-- Tambahan JS jika diperlukan -->
@endpush


