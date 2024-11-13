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
                    Data Kasir
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
                                <button id="btnTambahkasir" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    Tambah Data
                                </button>
                            </div>
                        </div>

                        

                       <!-- Tabel Data Kasir -->
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kasir as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role }}</td>
                               
                                <td>
                                    <button class="btn btn-warning edit" name="{{ $item->name }}">Edit</button>
                                    <form action="{{ route('kasir.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-confirm">Delete</button>
                                    </form>                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
               


                        <!-- Modal Tambah Kasir -->
                        <div class="modal modal-blur fade" id="modal-inputkasir" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Data Kasir</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/kasir/store" method="POST" id="frmKasir" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama Kasir">
                                            </div>
                                            <div class="mb-3">
                                                <input type="email" id="email" class="form-control" name="email" placeholder="Email">
                                            </div>
                                            <div class="mb-3">
                                                <input type="password" id="password" class="form-control" name="password" placeholder="Password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role</label>
                                                <select id="role" class="form-control" name="role">
                                                    <option value="admin">Admin</option>
                                                    <option value="kasir">Kasir</option>
                                                    <option value="kasir">Owner</option>
                                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Kasir -->
                    <div class="modal modal-blur fade" id="modal-editkasir" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data Kasir</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="loadeditform">
                                    <!-- Form edit akan dimuat di sini -->
                                </div>
                            </div>
                        </div>
                    </div>

                         <!-- Link Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $kasir->links('vendor.pagination.bootstrap-5') }}
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
</div>
@endsection

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        // Buka modal tambah kasir
        $("#btnTambahkasir").click(function() {
            $("#modal-inputkasir").modal("show");
        });

        // Fungsi untuk edit kasir
        $(".edit").click(function() {
    var name = $(this).attr('name');  // Ambil nama kasir yang akan diedit
    $.ajax({
        type: 'POST',  // Pastikan method sesuai dengan route
        url: '{{ route("kasir.edit") }}',
        data: {
            _token: "{{ csrf_token() }}",
            name: name  // Kirim nama kasir
        },
        success: function(response) {
            if (response.error) {
                alert(response.error);
            } else {
                $("#loadeditform").html(response.html);  // Isi form edit dalam modal
                $("#modal-editkasir").modal("show");  // Tampilkan modal
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('Error: ' + error);
        }
    });
});



        // Fungsi untuk konfirmasi delete
        $(".delete-confirm").click(function(e) {
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin Data Ini Mau Di Hapus?',
                text: "Jika Ya Maka Data Akan Terhapus Permanent",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Deleted!',
                        'Data Berhasil Di Hapus',
                        'success'
                    );
                }
            });
        });

        // Validasi form kasir
        $("#frmKasir").submit(function() {
            var name = $("#nama").val();
            var email = $("#email").val();

            if (name == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama harus diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#nama").focus();
                });
                return false;
            } else if (email == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Email harus diisi!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#email").focus();
                });
                return false;
            }
            return true;
        });
    });
</script>
@endpush
