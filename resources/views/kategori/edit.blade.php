{{-- @extends('layouts.app') --}}

{{-- Customize layout sections --}}

{{-- @section('subtitle', 'Edit kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle','Edit' ) --}}

{{--Content body: main Page content--}}

{{-- @section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3>Edit Kategori Baru</h3>
            </div>

            <form method="POST" action="{{ route('kategori.edit_simpan',$kategori->kategori_id) }}">
                {{ csrf_field() }}
                {{method_field('PUT')}}
            <div class="card-body">
                <div class="form-group">
                    <label for="kodeKategori">Kode Kategori</label>
                <input type="text" class="form-control" id="kodeKategori" name="kodeKategori" placeholder="Masukkan kode kategori" value="{{$kategori->kategori_kode}}">
                </div>
                <div class="form-group">
                    <label for="namaKategori">Nama Kategori</label>
                <input type="text" class="form-control" id="namaKategori" name="namaKategori" placeholder="Masukkan Nama Kategori" value="{{$kategori->kategori_nama}}">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Ubah</button>

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
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($kategori)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('kategori') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
        <form method="POST" action="{{ url('/kategori/'.$kategori->kategori_id) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT') !!} <!-- tambahkan baris ini untuk proses edit yang membutuhkan method PUT -->
          
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">kode Kategori</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" value="{{ old('kategori_kode', $kategori->kategori_kode) }}" required>
                    @error('kategori_kode')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">nama kategori</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" value="{{ old('kategori_nama', $kategori->kategori_nama) }}" required>
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
        @endempty
    </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush

