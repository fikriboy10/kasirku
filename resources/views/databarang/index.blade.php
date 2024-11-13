@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    Data Barang
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Notifikasi -->
                        <div class="row">
                            <div class="col-12">
                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif

                                @if (Session::get('warning'))
                                    <div class="alert alert-warning">
                                        {{ Session::get('warning') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Tombol Tambah Data Barang -->
                        <div class="row">
                            <div class="col-12">
                                <button id="btnTambahdatabarang" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    Tambah Data Barang
                                </button>
                            </div>
                        </div>

                        <!-- Tabel Data Barang -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Barang</th>
                                                    <th>Harga Jual</th>
                                                    <th>Kode Barang</th>
                                                   
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($databarang as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nm_barang }}</td>
                                                        <td>{{ $item->harga_jual }}</td>
                                                        <td>{{ $item->kd_barang }}</td>
                                                       
                                                        <td>
                                                            <button class="btn btn-warning edit" data-id="{{ $item->id }}" data-nama="{{ $item->nama_barang }}">Edit</button>
                                                            <form action="{{ route('databarang.delete', $item->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger delete-confirm">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Link Pagination -->
                                        <div class="d-flex justify-content-center">
                                            {{ $databarang->links('vendor.pagination.bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Tambah Data Barang -->
                         <div class="modal modal-blur fade" id="modal-inputdatabarang" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Data Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/databarang/store" method="POST" id="frmdatabarang" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="text" id="nama_barang" class="form-control" name="nm_barang" placeholder="Nama Barang">
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" id="harga_jual" class="form-control" name="harga_jual" placeholder="Harga Jual">
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" id="kd_barang" class="form-control" name="kd_barang" placeholder="Kode Barang">
                                            </div>
                                           
                                            
                                           
                                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                       <!-- Modal Edit Data Barang -->
                    <div class="modal fade" id="modal-editdatabarang" tabindex="-1" role="dialog" aria-labelledby="modal-editdatabarangLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-editdatabarangLabel">Edit Data Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form Edit Barang akan dimuat di sini -->
                                    <div id="loadeditform"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Buka modal tambah data barang
        $("#btnTambahdatabarang").click(function() {
            $("#modal-inputdatabarang").modal("show");
        });

        // Fungsi untuk edit data barang
        $(".edit").click(function() {
    var id = $(this).data('id'); // Mendapatkan id dari data-id

    // Melakukan request AJAX untuk mengambil data berdasarkan ID
    $.ajax({
        type: 'POST', // Menggunakan GET untuk mengambil data
        url: '{{ route("databarang.edit", ":id") }}'.replace(':id', id), // Menyisipkan ID ke dalam URL
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.error) {
                alert(response.error);
            } else {
                // Cek respons yang diterima di console
                console.log(response.html);

                // Masukkan form edit ke dalam elemen #loadeditform dan tampilkan modal
                $("#loadeditform").html(response.html);
                $("#modal-editdatabarang").modal("show");
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('Error: ' + error);
        }
    });
});


        // Fungsi konfirmasi penghapusan data
        $(".delete-confirm").click(function(e) {
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin Data Ini Mau Di Hapus?',
                text: "Jika Ya Maka Data Akan Terhapus Permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire('Deleted!', 'Data Berhasil Di Hapus', 'success');
                }
            });
        });
    });
</script>
@endpush

@endsection