@empty($data)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $data->stok_id . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi</h5>
                        Apakah Anda ingin menghapus data berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">

                        <tr>
                            <th class="text-right col-3">Nama Barang:</th>
                            <td class="col-9">{{ $data->barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Supplier:</th>
                            <td class="col-9">{{ $data->supplier->supplier_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama User:</th>
                            <td class="col-9">{{ $data->user->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Stok:</th>
                            <td class="col-9">{{ $data->stok_tanggal }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jumlah Stok:</th>
                            <td class="col-9">{{ $data->stok_jumlah }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-delete").submit(function(e) {
                e.preventDefault();
                let form = this;
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#modal-master').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            data.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
            });
        });
    </script>
@endempty
