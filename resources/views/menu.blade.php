@extends('layout.app')
@section('content')
<style>
    svg{
        width: 20px
    }
</style>
<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Tambah Menu
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="/submit-menu" method="POST" enctype="multipart/form-data">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Input Menu</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" required name="kategori_id" aria-label="Default select example">
                                <option selected disabled value="">Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                <option value="{{$item->id}}">{{$item->kategori}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Gambar Menu</label>
                            <input name="gambar" required type="file" accept=".jpg, .png, .jpeg" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nama Menu</label>
                            <input name="name" required type="text" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Harga</label>
                            <input name="price" required type="number" class="form-control" id="exampleInputPassword1">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-body">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Gambar Menu</th>
                        <th scope="col">Nama Menu</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                    <tr>
                        <td> {{ $data->firstItem() + $key }}</td>
                        <td>
                            <img src="/storage/image/{{$item->gambar}}" style="width: 70px" alt="">
                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->kategori->kategori}}</td>
                        <td>{{$item->price}}</td>
                        <td>
                            <form action="/delete-menu/{{$item->id}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModaledit{{$item->id}}">
                                    Edit
                                </button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
             {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $data->links() !!}
        </div>
        </div>

    </div>

    @foreach ($data as $item)
    <!-- Modal edit -->
    <div class="modal fade" id="exampleModaledit{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form action="/update-menu/{{$item->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Edit Menu</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" required name="kategori_id" aria-label="Default select example">
                                <option selected disabled value="">Pilih Kategori</option>
                                @foreach ($kategori as $kt)
                                <option value="{{$kt->id}}" {{ $kt->id == $item->kategori_id ? 'selected' : '' }}>{{$kt->kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Gambar Menu</label>
                            <input name="gambar" value="{{$item->gambar}}" type="file" accept=".jpg, .png, .jpeg" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Menu</label>
                            <input type="text" name="name" required value="{{$item->name}}" class="form-control"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Harga</label>
                            <input type="number" name="price" required value="{{$item->price}}" class="form-control"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>
@endforeach

@endsection
