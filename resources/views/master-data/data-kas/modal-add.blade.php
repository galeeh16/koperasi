<x-modal id="modal-add-data-kas">
    <x-slot:header>Form Tambah Data Kas</x-slot:header>

    <form method="post" id="form-add-data-kas" spellcheck="false">
        @csrf

        <div class="mb-3">
            <x-label for="nama_kas">Nama Kas</x-label>
            <x-input-text id="nama_kas" name="nama_kas"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="aktif">Aktif</x-label>
            <x-input-select id="aktif" name="aktif">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="simpanan">Simpanan</x-label>
            <x-input-select id="simpanan" name="simpanan">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="penarikan">Penarikan</x-label>
            <x-input-select id="penarikan" name="penarikan">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pinjaman">Pinjaman</x-label>
            <x-input-select id="pinjaman" name="pinjaman">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="angsuran">Angsuran</x-label>
            <x-input-select id="angsuran" name="angsuran">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pemasukan_kas">Pemasukan Kas</x-label>
            <x-input-select id="pemasukan_kas" name="pemasukan_kas">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pengeluaran_kas">Pengeluaran Kas</x-label>
            <x-input-select id="pengeluaran_kas" name="pengeluaran_kas">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="transfer_kas">Transfer Kas</x-label>
            <x-input-select id="transfer_kas" name="transfer_kas">
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
    function resetAddForm() {
        $('#form-add-data-kas')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();

        $('#aktif').val('Y').trigger('change');
        $('#simpanan').val('Y').trigger('change');
        $('#penarikan').val('Y').trigger('change');
        $('#pinjaman').val('Y').trigger('change');
        $('#angsuran').val('Y').trigger('change');
        $('#pemasukan_kas').val('Y').trigger('change');
        $('#pengeluaran_kas').val('Y').trigger('change');
        $('#transfer_kas').val('Y').trigger('change');
    }

    function addDataKas(modalAdd) {
        $.ajax({
            url: "{{ url('master-data/data-kas') }}",
            type: 'post',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                nama_kas: $('#nama_kas').val(),
                aktif: $('#aktif').val(),
                simpanan: $('#simpanan').val(),
                penarikan: $('#penarikan').val(),
                pinjaman: $('#pinjaman').val(),
                angsuran: $('#angsuran').val(),
                pemasukan_kas: $('#pemasukan_kas').val(),
                pengeluaran_kas: $('#pengeluaran_kas').val(),
                transfer_kas: $('#transfer_kas').val(),
            },
            success: function(response) {
                showAlertSuccess(response.message);
                resetAddForm();
                modalAdd.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    $(document).ready(function() {
        $('#aktif, #simpanan, #penarikan, #pinjaman, #angsuran, #pemasukan_kas, #pengeluaran_kas, #transfer_kas').select2({
            dropdownParent: $('#modal-add-data-kas'),
            minimumResultsForSearch: -1
        });

        let modalAdd = new bootstrap.Modal('#modal-add-data-kas', {
            backdrop: 'static'
        });

        $('#form-add-data-kas').validate({
            submitHandler: function() {
                addDataKas(modalAdd);
            },
            rules: {
                nama_kas: {
                    required: true,
                },
                aktif: {
                    required: true,
                },
                simpanan: {
                    required: true,
                },
                penarikan: {
                    required: true,
                },
                pinjaman: {
                    required: true,
                },
                angsuran: {
                    required: true,
                },
                pemasukan_kas: {
                    required: true,
                },
                pengeluaran_kas: {
                    required: true,
                },
                transfer_kas: {
                    required: true,
                },
            }
        });
    });
</script>
@endpush
