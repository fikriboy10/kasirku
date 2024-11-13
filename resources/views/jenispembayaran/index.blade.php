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
                    Jenis Pembayaran
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

                        <!-- Tombol Tambah Data -->
                        <div class="row">
                            <div class="col-12">
                                <button id="btnTambahjenispembayaran" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    Tambah Jenis Pembayaran
                                </button>
                            </div>
                        </div>

                        <!-- Tabel Data Jenis Pembayaran -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Pembayar</th>
                                                    <th>Jenis Pembayaran</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jenispembayaran as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_pembayar }}</td>
                                                        <td>{{ $item->jenis_pembayaran }}</td>
                                                        <td>
                                                            <button class="btn btn-warning edit" data-id="{{ $item->id }}" data-nama="{{ $item->nama_pembayar }}">Edit</button>
                                                            <form action="{{ route('jenispembayaran.delete', $item->id) }}" method="POST" class="d-inline">
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
                                            {{ $jenispembayaran->links('vendor.pagination.bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Modal Tambah Jenis Pembayaran -->
                         <div class="modal modal-blur fade" id="modal-inputjenispembayaran" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Jenis Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/jenispembayaran/store" method="POST" id="frmjenispembayaran" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="text" id="nama_pembayar" class="form-control" name="nama_pembayar" placeholder="Nama Pembayar">
                                            </div>
                                            
                                            
                                            <input type="text" id="nama_pembayar" class="form-control" name="nama_pembayar" placeholder="Nama Pembayar">
                                            <select id="role" class="form-control" name="jenis_pembayaran">
                                                <option value="Cash">Cash</option>
                                                <option value="Transferbank">Transferbank</option>
                                                <option value="Qris">Qris</option>
                                            </select>

                                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Jenis Pembayaran -->
                        <div class="modal modal-blur fade" id="modal-editjenispembayaran" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Jenis Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="loadeditform">
                                        <!-- Form edit akan dimuat di sini -->
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
@endsection

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Buka modal tambah jenis pembayaran
        $("#btnTambahjenispembayaran").click(function() {
            $("#modal-inputjenispembayaran").modal("show");
        });

        // Fungsi untuk edit jenis pembayaran
        // Fungsi untuk membuka modal edit jenis pembayaran
        $(".edit").click(function() {
    var id = $(this).data('id');
    
    $.ajax({
        type: 'POST',
        url: '{{ route("jenispembayaran.edit") }}',
        data: {
            _token: "{{ csrf_token() }}",
            id: id
        },
        success: function(response) {
            if (response.error) {
                alert(response.error);
            } else {
                $("#loadeditform").html(response.html);
                $("#modal-editjenispembayaran").modal("show");
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

        // Validasi form Jenis Pembayaran
        $("#frmjenispembayaran").submit(function() {
            var jenis = $("#jenis").val();
            if (jenis == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jenis Pembayaran harus diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#jenis").focus();
                });
                return false;
            }
            return true;
        });
    });
</script>
@endpush
