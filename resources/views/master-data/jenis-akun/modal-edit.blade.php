<x-modal id="modal-edit-jenis-akun">
    <x-slot:header>Form Ubah Jenis Akun</x-slot:header>

    <form id="form-edit-jenis-akun" method="post" spellcheck="false">
        @csrf
        <input type="hidden" id="id_edit" name="id_edit">

        <div class="mb-3">
            <x-label for="kode_aktiva_edit">Kode Aktiva</x-label>
            <x-input-text id="kode_aktiva_edit" name="kode_aktiva_edit"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="nama_akun_edit">Nama Akun</x-label>
            <x-input-text id="nama_akun_edit" name="nama_akun_edit"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="akun_edit">Akun</x-label>
            <x-input-select id="akun_edit" name="akun_edit">
                <option value="Aktiva">Aktiva</option>
                <option value="Pasiva">Pasiva</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pemasukan_edit">Pemasukan</x-label>
            <x-input-select id="pemasukan_edit" name="pemasukan_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="pengeluaran_edit">Pengeluaran</x-label>
            <x-input-select id="pengeluaran_edit" name="pengeluaran_edit">
                <option value="Y">Ya</option>
                <option value="N">Tidak</option>
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="laba_rugi_edit">Laba Rugi</x-label>
            <x-input-select id="laba_rugi_edit" name="laba_rugi_edit">
                <option value="Pendapatan">Pendapatan</option>
                <option value="Biaya">Biaya</option>
            </x-input-select>
        </div>

        <div class="mt-4 d-flex align-items-center justify-content-end gap-2">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light" onclick="resetEditForm()">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script>
    function resetEditForm() {
        $('#form-edit-jenis-akun')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
        $('#akun').val('Aktiva').trigger('change');
        $('#pemasukan').val('Y').trigger('change');
        $('#pengeluaran').val('Y').trigger('change');
        $('#laba_rugi').val('Pendapatan').trigger('change');
    }

    function editJenisAkun(modalEdit) {
        let id = $('#id_edit').val();

        $.ajax({
            url: "{{ url('master-data/jenis-akun') }}" + '/' + id,
            type: 'put',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                kode_aktiva: $('#kode_aktiva_edit').val(),
                nama_akun: $('#nama_akun_edit').val(),
                akun: $('#akun_edit').val(),
                pemasukan: $('#pemasukan_edit').val(),
                pengeluaran: $('#pengeluaran_edit').val(),
                laba_rugi: $('#laba_rugi_edit').val(),
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
        $('#akun_edit, #pemasukan_edit, #pengeluaran_edit, #laba_rugi_edit').select2({
            dropdownParent: $('#modal-edit-jenis-akun'),
            minimumResultsForSearch: -1
        })

        let modalEdit = new bootstrap.Modal('#modal-edit-jenis-akun', {
            backdrop: 'static'
        });

        // button edit onclick handler
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let kodeAktiva = $(this).data('kode-aktiva');
            let namaAkun = $(this).data('nama-akun');
            let akun = $(this).data('akun');
            let pemasukan = $(this).data('pemasukan');
            let pengeluaran = $(this).data('pengeluaran');
            let labaRugi = $(this).data('laba-rugi');

            $('#id_edit').val(id);
            $('#kode_aktiva_edit').val(kodeAktiva);
            $('#nama_akun_edit').val(namaAkun);
            $('#akun_edit').val(akun).trigger('change');
            $('#pemasukan_edit').val(pemasukan).trigger('change');
            $('#pengeluaran_edit').val(pengeluaran).trigger('change');
            $('#laba_rugi_edit').val(labaRugi).trigger('change');

            modalEdit.show();
        });

        $('#form-edit-jenis-akun').validate({
            submitHandler: function(form) {
                editJenisAkun(modalEdit);
            },
            rules: {
                kode_aktiva_edit: {
                    required: true
                },
                nama_akun_edit: {
                    required: true
                },
                akun_edit: {
                    required: true
                },
                pemasukan_edit: {
                    required: true
                },
                pengeluaran_edit: {
                    required: true
                },
                laba_rugi_edit: {
                    required: true
                },
            }
        });
    });
</script>
@endpush
