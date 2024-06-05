<x-modal id="modal-add-transfer">
    <x-slot:header>Form Tambah Transfer</x-slot:header>

    <form method="post" id="form-add-transfer" spellcheck="false">
        @csrf
        <div class="mb-3">
            <x-label for="tanggal">Tanggal</x-label>
            <x-input-text id="tanggal" name="tanggal" readonly value="{{date('d-m-Y')}}"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="jumlah">Jumlah</x-label>
            <x-input-text id="jumlah" name="jumlah" onkeypress="return isNumberKey(event)"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="keterangan">Keterangan</x-label>
            <x-input-text id="keterangan" name="keterangan"></x-input-text>
        </div>
        <div class="mb-3">
            <x-label for="dari_kas">Dari Kas</x-label>
            <x-input-select id="dari_kas" name="dari_kas" data-placeholder="Pilih Kas">
                <option value=""></option>
                @foreach ($data_kas as $kas)
                    <option value="{{ $kas->id }}">{{ $kas->nama_kas }}</option>
                @endforeach
            </x-input-select>
        </div>
        <div class="mb-3">
            <x-label for="untuk_kas">Untuk Kas</x-label>
            <x-input-select id="untuk_kas" name="untuk_kas" data-placeholder="Pilih Kas">
                <option value=""></option>
                @foreach ($data_kas as $kas)
                    <option value="{{ $kas->id }}">{{ $kas->nama_kas }}</option>
                @endforeach
            </x-input-select>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-2">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light" onclick="clearAddForm()">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script>
    function clearAddForm() {
        $('#form-add-transfer')[0].reset();
        $('#dari_kas').val($('#dari_kas option:first').val()).trigger('change');
        $('#untuk_kas').val($('#untuk_kas option:first').val()).trigger('change');
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
    }

    function addTransfer(modalAdd) {
        $.ajax({
            url: "{{ url('transactions/transfer') }}",
            type: 'post',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                jumlah: $('#jumlah').val(),
                keterangan: $('#keterangan').val(),
                dari_kas: $('#dari_kas').val(),
                untuk_kas: $('#untuk_kas').val(),
            },
            success: function(response) {
                showAlertSuccess(response.message);
                clearAddForm();
                modalAdd.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError();
            }
        });
    }

    $(document).ready(function() {
        $('#dari_kas, #untuk_kas').select2({
            dropdownParent: $('#modal-add-transfer'),
        });

        let modalAdd = new bootstrap.Modal('#modal-add-transfer', {
            backdrop: 'static'
        });

        const formAddTransfer = $('#form-add-transfer');

        $('#dari_kas, #untuk_kas').on('change', function(e) {
           formAddTransfer.validate().element($(this));
        });

        formAddTransfer.validate({
            submitHandler: function(form) {
                addTransfer(modalAdd);
            },
            rules: {
                tanggal: {
                    required: true
                },
                jumlah: {
                    required: true,
                },
                keterangan: {
                    required: true,
                },
                dari_kas: {
                    required: true,
                },
                untuk_kas: {
                    required: true,
                },
            }
        });
    });
</script>
@endpush
