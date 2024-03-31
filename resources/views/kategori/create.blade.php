@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Create')

{{-- Content body:: main page content --}}
@section('content')
<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Buat kategori baru</h3>
        </div>

        <form method="post" action="../kategori">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="kodeKategori">Kode Kategori</label>

                    <input id="kodeKategori" type="text" name="kategori_kode" class="@error('kategori_kode') is-invalid @enderror">

                    @error('kategori_kode')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    {{-- <input type="text" class="form-control" id="kodeKategori" name="kategori_kode" placeholder="Enter name"> --}}
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-group">
                    <label for="namaKategori">Nama Kategori</label>
                    <input type="text" class="form-control" id="namaKategori" name="kategori" placeholder="Enter name">
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        </form>
    </div>
</div>
@endsection