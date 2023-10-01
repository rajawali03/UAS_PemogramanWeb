@extends('layout.template')
<!-- START DATA -->
@section('konten')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                {!! $angkatanChart->container() !!}
            </div>
        </div>
    </div>
</div>

<div class="p-3 my-3 rounded shadow bg-body">
    <!-- FORM PENCARIAN -->
    <nav class="navbar bg-body-tertiary" style="background-color: #e3f2fd;">
        <div class="container ">
            <a class="ml-5 navbar-brand">Pencarian data mahasiswa</a>
        </div>
    <div class="container-fluid">
        <a href='{{url('mahasiswa/create')}}' class="btn btn-success">+ Tambah Data</a>
        <form class="d-flex" action="{{url('mahasiswa')}}" method="get" role="search">
            <input class="form-control me-2" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Masukan kata kunci" aria-label="Search">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </form>
    </div>
    </nav>

    <!-- TABLE DATA -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-1">NIM</th>
                <th class="col-md-2">Nama</th>
                <th class="col-md-1">angkatan</th>
                <th class="col-md-4">Jurusan</th>
                <th class="col-md-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=$data->firstItem() ?>
            @foreach ($data as $item)
            <tr>
                <td>{{$i}}</td>
                <td>{{$item->nim}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->angkatan}}</td>
                <td>{{$item->jurusan}}</td>
                <td>
                    <a href='{{url('mahasiswa/'.$item->nim.'/edit')}}' class="btn btn-warning btn-sm">Edit</a>
                    <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus data?')" class="d-inline" action="{{url('mahasiswa/'.$item->nim)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php $i++ ?>
            @endforeach
        </tbody>
    </table>
    {{$data->withQueryString()->links()}}
</div>
<div class="shadow card">
    <div class="container">
        <div class="p-3 bg-light">
            <p class="text-center">Copyright: Rajawali_H1051211029</p>
        </div>
    </div>
</div>
<script src="{{ $angkatanChart->cdn() }}"></script>
{{ $angkatanChart->script() }}
<!-- AKHIR DATA -->
@endsection
