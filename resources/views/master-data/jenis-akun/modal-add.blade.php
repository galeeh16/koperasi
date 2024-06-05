<x-modal id="modal-add-jenis-akun">
    <x-slot:header>Form Tambah Jenis Akun</x-slot:header>

    <form id="form-add-jenis-akun" method="post" spellcheck="false">
        @csrf

        <div class="mb-3">
            <x-label for="kode_aktiva">Kode Aktiva</x-label>
            <x-input-text id="kode_aktiva" name="kode_aktiva"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="nama_akun">Nama Akun</x-label>
            <x-input-text id="nama_akun" name="nama_akun"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="akun">Akun</x-label>
            <x-input-select id="akun" name="akun">
                <option value="Aktiva">Aktiva</option>
                <option value="Pasiva">Pasiva</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pemasukan">Pemasukan</x-label>
            <x-input-select id="pemasukan" name="pemasukan">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pengeluaran">Pengeluaran</x-label>
            <x-input-select id="pengeluaran" name="pengeluaran">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="laba_rugi">Laba Rugi</x-label>
            <x-input-select id="laba_rugi" name="laba_rugi">
                <option value="Pendapatan">Pendapatan</option>
                <option value="Biaya">Biaya</option>
            </x-input-select>
        </div>

        <div class="mt-4 d-flex align-items-center justify-content-end gap-2">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light" onclick="resetAddForm()">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script>
    function resetAddForm() {
        $('#form-add-jenis-akun')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
        $('#akun').val('Aktiva').trigger('change');
        $('#pemasukan').val('Y').trigger('change');
        $('#pengeluaran').val('Y').trigger('change');
        $('#laba_rugi').val('Pendapatan').trigger('change');
    }

    function addJenisAkun(modalAdd) {
        $.ajax({
            url: "{{ url('master-data/jenis-akun') }}",
            type: 'post',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                kode_aktiva: $('#kode_aktiva').val(),
                nama_akun: $('#nama_akun').val(),
                akun: $('#akun').val(),
                pemasukan: $('#pemasukan').val(),
                pengeluaran: $('#pengeluaran').val(),
                laba_rugi: $('#laba_rugi').val(),
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
        $('#akun, #pemasukan, #pengeluaran, #laba_rugi').select2({
            dropdownParent: $('#modal-add-jenis-akun'),
            minimumResultsForSearch: -1
        })

        let modalAdd = new bootstrap.Modal('#modal-add-jenis-akun', {
            backdrop: 'static'
        });

        $('#form-add-jenis-akun').validate({
            submitHandler: function(form) {
                addJenisAkun(modalAdd);
            },
            rules: {
                kode_aktiva: {
                    required: true
                },
                nama_akun: {
                    required: true
                },
                akun: {
                    required: true
                },
                pemasukan: {
                    required: true
                },
                pengeluaran: {
                    required: true
                },
                laba_rugi: {
                    required: true
                },
            }
        });
    });
</script>
@endpush
