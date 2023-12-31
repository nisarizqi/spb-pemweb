@extends('layouts.default_adminunit')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h2 class="mt-4">Tambah Permintaan Peminjaman</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/adminunit/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/adminunit/reqpeminjaman">Permintaan Peminjaman</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
        <!-- <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div>
                        </div> -->
        <div class="card mb-4">
            <div class="card-header">
                <!-- <i class="fas fa-table me-1"></i> -->
                Tambah Permintaan Peminjaman
            </div>
            <div class="card-body">
                <form action="{{ route('adminunit.reqpeminjaman.store') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="$id_unit">
                    <?php
                    $date = date("Y-m-d");
                    ?>
                    <input type="hidden" name="tgl_reservasi" value="<?= $date; ?>">
                    {{ csrf_field() }}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <!-- <span>Nama Unit</span> -->
                                <select class="form-select @error('id_user') is-invalid @enderror" id="id_user" name="id_user">
                                    @foreach($users as $r)
                                    @if(old('id_user') && old('id_user' == $r->id))
                                    <option selected value="{{ $r->id }}">{{ $r->name }}</option>
                                    @endif
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                                <label for="id_user">Pengguna</label>

                                @error('id_user')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <!-- <span>Lokasi Unit</span> -->
                                <select class="form-select @error('id_barang') is-invalid @enderror" id="id_barang" name="id_barang">
                                    @foreach($barang as $r)
                                    @if(old('id_barang') && old('id_barang') == $r->id)
                                    <option selected value="{{ $r->id }}">{{ $r->nama_barang }}</option>
                                    @endif
                                    <option value="{{ $r->id }}">{{ $r->nama_barang }}</option>
                                    @endforeach
                                </select>
                                <label for="id_barang">Barang</label>


                                @error('id_barang')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <!-- <span>Nama Unit</span> -->
                                <input class="form-control @error('tgl_pinjam') is-invalid @enderror" id="tgl_pinjam" name="tgl_pinjam" type="date" value="{{ old('tgl_pinjam') }}" />
                                <label for="tgl_pinjam">Tanggal Pinjam</label>

                                @error('tgl_pinjam')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control @error('tgl_kembali') is-invalid @enderror" id="tgl_kembali" name="tgl_kembali" type="date" value="{{ old('tgl_kembali') }}" />
                                <label for="tgl_kembali">Tanggal Kembali</label>

                                @error('tgl_kembali')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="d-grid"><button type="submit" class="btn btn-primary">Tambah</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection