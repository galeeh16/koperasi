<x-modal id="modal-edit-data-kas">
    <x-slot:header>Form Ubah Data Kas</x-slot:header>

    <form method="post" id="form-edit-data-kas" spellcheck="false">
        @csrf
        <input type="hidden" id="id_edit" name="id_edit">

        <div class="mb-3">
            <x-label for="nama_kas_edit">Nama Kas *</x-label>
            <x-input-text id="nama_kas_edit" name="nama_kas_edit"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="aktif_edit">Aktif *</x-label>
            <x-input-select id="aktif_edit" name="aktif_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="simpanan_edit">Simpanan *</x-label>
            <x-input-select id="simpanan_edit" name="simpanan_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="penarikan_edit">Penarikan *</x-label>
            <x-input-select id="penarikan_edit" name="penarikan_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pinjaman_edit">Pinjaman *</x-label>
            <x-input-select id="pinjaman_edit" name="pinjaman_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="angsuran_edit">Angsuran *</x-label>
            <x-input-select id="angsuran_edit" name="angsuran_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pemasukan_kas_edit">Pemasukan Kas *</x-label>
            <x-input-select id="pemasukan_kas_edit" name="pemasukan_kas_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pengeluaran_kas_edit">Pengeluaran Kas *</x-label>
            <x-input-select id="pengeluaran_kas_edit" name="pengeluaran_kas_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="transfer_kas_edit">Transfer Kas *</x-label>
            <x-input-select id="transfer_kas_edit" name="transfer_kas_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>

        <div class="mt-4 d-flex align-items-center justify-content-end gap-2">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script>
    function resetEditForm() {
        $('#form-edit-data-kas')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();

        $('#aktif_edit').val('Y').trigger('change');
        $('#simpanan_edit').val('Y').trigger('change');
        $('#penarikan_edit').val('Y').trigger('change');
        $('#pinjaman_edit').val('Y').trigger('change');
        $('#angsuran_edit').val('Y').trigger('change');
        $('#pemasukan_kas_edit').val('Y').trigger('change');
        $('#pengeluaran_kas_edit').val('Y').trigger('change');
        $('#transfer_kas_edit').val('Y').trigger('change');
    }

    function editDataKas(modalEdit) {
        let id = $('#id_edit').val();

        $.ajax({
            url: "{{ url('master-data/data-kas') }}" + '/' + id,
            type: 'put',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                nama_kas: $('#nama_kas_edit').val(),
                aktif: $('#aktif_edit').val(),
                simpanan: $('#simpanan_edit').val(),
                penarikan: $('#penarikan_edit').val(),
                pinjaman: $('#pinjaman_edit').val(),
                angsuran: $('#angsuran_edit').val(),
                pemasukan_kas: $('#pemasukan_kas_edit').val(),
                pengeluaran_kas: $('#pengeluaran_kas_edit').val(),
                transfer_kas: $('#transfer_kas_edit').val(),
            },
            success: function(response) {
                showAlertSuccess(response.message);
                resetEditForm();
                modalEdit.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    $(document).ready(function() {
        $('#aktif_edit, #simpanan_edit, #penarikan_edit, #pinjaman_edit, #angsuran_edit, #pemasukan_kas_edit, #pengeluaran_kas_edit, #transfer_kas_edit').select2({
            dropdownParent: $('#modal-edit-data-kas'),
            minimumResultsForSearch: -1
        });

        let modalEdit = new bootstrap.Modal('#modal-edit-data-kas', {
            backdrop: 'static'
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $('#id_edit').val(id);
            $('#nama_kas_edit').val($(this).data('nama-kas'));
            $('#aktif_edit').val($(this).data('aktif')).trigger('change');
            $('#simpanan_edit').val($(this).data('simpanan')).trigger('change');
            $('#penarikan_edit').val($(this).data('penarikan')).trigger('change');
            $('#pinjaman_edit').val($(this).data('pinjaman')).trigger('change');
            $('#angsuran_edit').val($(this).data('angsuran')).trigger('change');
            $('#pemasukan_kas_edit').val($(this).data('pemasukan-kas')).trigger('change');
            $('#pengeluaran_kas_edit').val($(this).data('pengeluaran-kas')).trigger('change');
            $('#transfer_kas_edit').val($(this).data('transfer-kas')).trigger('change');

            modalEdit.show();
        });

        $('#form-edit-data-kas').validate({
            submitHandler: function() {
                editDataKas(modalEdit);
            },
            rules: {
                nama_kas_edit: {
                    required: true,
                },
                aktif_edit: {
                    required: true,
                },
                simpanan_edit: {
                    required: true,
                },
                penarikan_edit: {
                    required: true,
                },
                pinjaman_edit: {
                    required: true,
                },
                angsuran_edit: {
                    required: true,
                },
                pemasukan_kas_edit: {
                    required: true,
                },
                pengeluaran_kas_edit: {
                    required: true,
                },
                transfer_kas_edit: {
                    required: true,
                },
            }
        });
    });
</script>
@endpush
