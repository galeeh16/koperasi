<x-modal id="modal-add-pengeluaran">
    <x-slot:header>Form Tambah Pengeluaran</x-slot:header>

    <form method="post" id="form-add-pengeluaran" spellcheck="false">
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
            <x-label for="dari_akun">Dari Akun</x-label>
            <x-input-select id="dari_akun" name="dari_akun" data-placeholder="Pilih Akun" data-minimum-results-for-search="-1">
                <option value=""></option>
                @foreach ($jenis_akun as $akun)
                    <option value="{{ $akun->id }}">{{ $akun->kode_aktiva }} - {{ $akun->nama_akun }}</option>
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
        $('#form-add-pengeluaran')[0].reset();
        $('#dari_akun').val($('#dari_akun option:first').val()).trigger('change');
        $('#untuk_kas').val($('#untuk_kas option:first').val()).trigger('change');
        $('.is-invalid').removeClass('is-invalid');
        $('.error.text-danger').remove();
    }

    function addPengeluaran(modalAdd) {
        $.ajax({
            url: "{{ url('transactions/pengeluaran') }}",
            type: 'post',
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            beforeSend: function() { showLoading(); },
            data: {
                jumlah: $('#jumlah').val(),
                keterangan: $('#keterangan').val(),
                dari_akun: $('#dari_akun').val(),
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
        $('#dari_akun, #untuk_kas').select2({
            dropdownParent: $('#modal-add-pengeluaran'),
        });

        const modalAdd = new bootstrap.Modal('#modal-add-pengeluaran', {
            backdrop: 'static'
        });

        const formAddPengeluaran = $('#form-add-pengeluaran');

        $('#dari_akun, #untuk_kas').on('change', function(e) {
           formAddPengeluaran.validate().element($(this));
        });

       formAddPengeluaran.validate({
            submitHandler: function(form) {
                addPengeluaran(modalAdd);
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
                dari_akun: {
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
