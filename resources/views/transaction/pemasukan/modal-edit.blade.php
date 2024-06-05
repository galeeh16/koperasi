<x-modal id="modal-edit-pemasukan">
    <x-slot:header>Form Ubah Pemasukan</x-slot:header>

    <form method="post" id="form-edit-pemasukan" spellcheck="false">
        @csrf
        <input type="hidden" id="id_edit" name="id_edit">

        <div class="mb-3">
            <x-label for="tanggal_edit">Tanggal</x-label>
            <x-input-text id="tanggal_edit" name="tanggal_edit" readonly value="{{date('d-m-Y')}}"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="jumlah_edit">Jumlah</x-label>
            <x-input-text id="jumlah_edit" name="jumlah_edit" onkeypress="return isNumberKey(event)"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="keterangan_edit">Keterangan</x-label>
            <x-input-text id="keterangan_edit" name="keterangan_edit"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="dari_akun_edit">Dari Akun</x-label>
            <x-input-select id="dari_akun_edit" name="dari_akun_edit" data-placeholder="Pilih Akun" data-minimum-results-for-search="-1">
                <option value=""></option>
                @foreach ($jenis_akun as $akun)
                    <option value="{{ $akun->id }}">{{ $akun->akun }}</option>
                @endforeach
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="untuk_kas_edit">Untuk Kas</x-label>
            <x-input-select id="untuk_kas_edit" name="untuk_kas_edit" data-placeholder="Pilih Kas">
                <option value=""></option>
                @foreach ($data_kas as $kas)
                    <option value="{{ $kas->id }}">{{ $kas->nama_kas }}</option>
                @endforeach
            </x-input-select>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-2">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light" onclick="clearEditForm()">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script>
    function clearEditForm() {
        $('#form-edit-pemasukan')[0].reset();
        $('#dari_akun_edit').val($('#dari_akun_edit option:first').val()).trigger('change');
        $('#untuk_kas_edit').val($('#untuk_kas_edit option:first').val()).trigger('change');
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
    }

    function findPemasukanByID(id, modalEdit) {
        $.ajax({
            url: "{{ url('transactions/pemasukan') }}" + '/' + id,
            type: 'get',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            success: function(response) {
                let data = response.data;
                $('#id_edit').val(data.id);
                $('#tanggal_edit').val(dateFormat(data.tanggal_transaksi));
                $('#jumlah_edit').val(data.jumlah);
                $('#keterangan_edit').val(data.keterangan);
                $('#dari_akun_edit').val(data.akun_id).trigger('change');
                $('#untuk_kas_edit').val(data.kas_id).trigger('change');

                modalEdit.show();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    function editPemasukan(modalEdit) {
        let id = $('#id_edit').val();

        $.ajax({
            url: "{{ url('transactions/pemasukan') }}" + '/' + id,
            type: 'put',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                jumlah: $('#jumlah_edit').val(),
                keterangan: $('#keterangan_edit').val(),
                dari_akun: $('#dari_akun_edit').val(),
                untuk_kas: $('#untuk_kas_edit').val(),
            },
            success: function(response) {
                showAlertSuccess(response.message);
                clearEditForm();
                modalEdit.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    $(document).ready(function() {
        $('#dari_akun_edit, #untuk_kas_edit').select2({
            dropdownParent: $('#modal-edit-pemasukan'),
        });

        const modalEdit = new bootstrap.Modal('#modal-edit-pemasukan', {
            backdrop: 'static'
        });

        const formEditPemasukan = $('#form-edit-pemasukan');

        $('#dari_akun, #untuk_kas').on('change', function(e) {
           formEditPemasukan.validate().element($(this));
        });

        // button edit onclick handler
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');

            findPemasukanByID(id, modalEdit);
        });

        formEditPemasukan.validate({
            submitHandler: function(form) {
                editPemasukan(modalEdit);
            },
            rules: {
                tanggal_edit: {
                    required: true
                },
                jumlah_edit: {
                    required: true,
                },
                keterangan_edit: {
                    required: true,
                },
                dari_akun_edit: {
                    required: true,
                },
                untuk_kas_edit: {
                    required: true,
                },
            }
        });

    });
</script>
@endpush
