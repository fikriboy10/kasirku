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
                    Transaksi
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
                                <button id="btnTambahtransaksi" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    Tambah Transaksi
                                </button>
                            </div>
                        </div>

                        <!-- Tabel Data Transaksi -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Kode Barang</th>
                                                    <th>Kasir</th>
                                                    <th>Jumlah</th>
                                                    <th>Subtotal</th>
                                                    <th>Tanggal Transaksi</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaksi as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $transaksi->id_transaksi }}</td>
                                                        <td>{{ $transaksi->barang->nama_barang }}</td>
                                                        <td>{{ $transaksi->kasir->name }}</td>
                                                        <td>{{ $transaksi->jumlah }}</td>
                                                        <td>{{ $transaksi->subtotal }}</td>
                                                        <td>{{ $transaksi->tanggal_transaksi }}</td>
                                                        <td>
                                                            <!-- Edit button -->
                                                            <button class="btn btn-warning">
                                                                <a href="{{ route('transaksi.edit', ['transaksi' => $transaksi->id]) }}" class="text-white">Edit</a>
                                                            </button>
                                        
                                                            <!-- Delete form -->
                                                            <form action="{{ route('transaksi.delete', $transaksi->id) }}" method="POST" class="d-inline">
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
                                        {{-- <div class="d-flex justify-content-center">
                                            {{ $transaksi->links('vendor.pagination.bootstrap-5') }}
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Modal Tambah Transaksi -->
                         <div class="modal modal-blur fade" id="modal-inputtransaksi" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Transaksi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/transaksi/store" method="POST" id="frmtransaksi" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="kode_barang" class="form-label">Kode Barang</label>
                                                <input type="text" id="kode_barang" class="form-control" name="kode_barang" placeholder="Kode Barang">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="kasir" class="form-label">Kasir</label>
                                                <input type="text" id="kasir" class="form-control" name="kasir" placeholder="Kasir">
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                <input type="number" id="jumlah" class="form-control" name="jumlah" placeholder="Jumlah">
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="subtotal" class="form-label">Subtotal</label>
                                                <input type="number" id="subtotal" class="form-control" name="subtotal" placeholder="Subtotal">
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                                                <input type="date" id="tanggal_transaksi" class="form-control" name="tanggal_transaksi" placeholder="Tanggal Transaksi">
                                            </div>
                        
                                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <!-- Modal Edit Transaksi -->
                        <div class="modal modal-blur fade" id="modal-edittransaksi" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Transaksi</h5>
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
        // Buka modal tambah transaksi
        $("#btnTambahtransaksi").click(function() {
            $("#modal-inputtransaksi").modal("show");
        });

        // Fungsi untuk edit transaksi
        $(".edit").click(function() {
            var id = $(this).data('id');
            
            $.ajax({
                type: 'GET', // Use GET method since you are retrieving data to edit
                url: '{{ route("transaksi.edit", ":id") }}'.replace(':id', id), // Replace :id with actual transaction id
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        $("#loadeditform").html(response.html);
                        $("#modal-edittransaksi").modal("show");
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

        // Validasi form Transaksi
        $("#frmtransaksi").submit(function() {
            var jenis = $("#jenis_transaksi").val();
            if (jenis == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jenis Transaksi harus diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#jenis_transaksi").focus();
                });
                return false;
            }
            return true;
        });
    });
</script>

@endpush
