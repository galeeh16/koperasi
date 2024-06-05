<x-modal id="modal-edit-transfer">
    <x-slot:header>Form Ubah Transfer</x-slot:header>

    <form method="post" id="form-edit-transfer" spellcheck="false">
        @csrf
        @method('put')
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
            <x-label for="dari_kas_edit">Dari Kas</x-label>
            <x-input-select id="dari_kas_edit" name="dari_kas_edit" data-placeholder="Pilih Kas">
                <option value=""></option>
                @foreach ($data_kas as $kas)
                    <option value="{{ $kas->id }}">{{ $kas->nama_kas }}</option>
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
        $('#form-edit-transfer')[0].reset();
        $('#dari_kas_edit').val($('#dari_kas_edit option:first').val()).trigger('change');
        $('#untuk_kas_edit').val($('#untuk_kas_edit option:first').val()).trigger('change');
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
    }

    function findTransferByID(id, modalEdit) {
        $.ajax({
            url: "{{ url('transactions/transfer') }}" + '/' + id,
            type: 'get',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            success: function(response) {
                let data = response.data;
                $('#id_edit').val(data.id);
                $('#tanggal_edit').val(dateFormat(data.tanggal_transaksi));
                $('#jumlah_edit').val(data.jumlah);
                $('#keterangan_edit').val(data.keterangan);
                $('#dari_kas_edit').val(data.dari_kas_id).trigger('change');
                $('#untuk_kas_edit').val(data.untuk_kas_id).trigger('change');

                modalEdit.show();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    function editTransfer(modalEdit) {
        let id = $('#id_edit').val();

        $.ajax({
            url: "{{ url('transactions/transfer') }}" + '/' + id,
            type: 'put',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                jumlah: $('#jumlah_edit').val(),
                keterangan: $('#keterangan_edit').val(),
                dari_kas: $('#dari_kas_edit').val(),
                untuk_kas: $('#untuk_kas_edit').val(),
            },
            success: function(response) {
                showAlertSuccess(response.message);
                clearEditForm();
                modalEdit.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError();
            }
        });
    }

    $(document).ready(function() {
        $('#dari_kas_edit, #untuk_kas_edit').select2({
            dropdownParent: $('#modal-edit-transfer'),
        });

        let modalEdit = new bootstrap.Modal('#modal-edit-transfer', {
            backdrop: 'static'
        });

        // button edit onclick handler
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');

            findTransferByID(id, modalEdit);
        });

        const formEditTransfer = $('#form-edit-transfer');

        $('#dari_kas_edit, #untuk_kas_edit').on('change', function(e) {
           formEditTransfer.validate().element($(this));
        });

        formEditTransfer.validate({
            submitHandler: function(form) {
                editTransfer(modalEdit);
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
                dari_kas_edit: {
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
