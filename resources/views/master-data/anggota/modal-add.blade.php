<x-modal id="modal-add-anggota" size="xl">
    <x-slot:header>Form Tambah Anggota</x-slot:header>

    <form id="form-add-anggota" method="post" spellcheck="false">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="mb-3">
                    <x-label for="username">Username</x-label>
                    <x-input-text id="username" name="username"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="nama_lengkap">Nama Lengkap</x-label>
                    <x-input-text id="nama_lengkap" name="nama_lengkap"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="jenis_kelamin">Jenis Kelamin</x-label>
                    <x-input-select id="jenis_kelamin" name="jenis_kelamin" data-minimum-results-for-search="-1">
                        <option value="l">Laki - Laki</option>
                        <option value="p">Perempuan</option>
                    </x-input-select>
                </div>
                <div class="mb-3">
                    <x-label for="tempat_lahir">Tempat Lahir</x-label>
                    <x-input-text id="tempat_lahir" name="tempat_lahir"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="tanggal_lahir">Tanggal Lahir</x-label>
                    <x-input-text id="tanggal_lahir" name="tanggal_lahir" autocomplete="off"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="status_menikah">Status Menikah</x-label>
                    <x-input-select id="status_menikah" name="status_menikah">
                        @foreach ($status_menikah as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_status }}</option>
                        @endforeach
                    </x-input-select>
                </div>
                <div class="mb-3">
                    <x-label for="departemen">Departemen</x-label>
                    <x-input-select id="departemen" name="departemen">
                        @foreach ($departemen as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_departemen }}</option>
                        @endforeach
                    </x-input-select>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="mb-3">
                    <x-label for="pekerjaan">Pekerjaan</x-label>
                    <x-input-select id="pekerjaan" name="pekerjaan">
                        @foreach ($pekerjaan as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_pekerjaan }}</option>
                        @endforeach
                    </x-input-select>
                </div>
                <div class="mb-3">
                    <x-label for="agama">Agama</x-label>
                    <x-input-select id="agama" name="agama">
                        @foreach ($agama as $row)
                            <option value="{{ $row->id }}">{{ $row->nama_agama }}</option>
                        @endforeach
                    </x-input-select>
                </div>
                <div class="mb-3">
                    <x-label for="alamat" :required="false">Alamat</x-label>
                    <x-input-text id="alamat" name="alamat"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="kota" :required="false">Kota</x-label>
                    <x-input-text id="kota" name="kota"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="no_hp" :required="false">No Handphone</x-label>
                    <x-input-text id="no_hp" name="no_hp"></x-input-text>
                </div>
                <div class="mb-3">
                    <x-label for="photo" :required="false">Photo <span class="text-muted">(.jpg, .jpeg, .png)</span></x-label>
                    <x-input-text type="file" id="photo" name="photo" accept="image/*"></x-input-text>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center gap-2 mt-3">
            <x-button type="submit" class="btn-primary">Submit</x-button>
            <x-button data-bs-dismiss="modal" class="btn-light" onclick="resetFormAdd()">Batal</x-button>
        </div>
    </form>
</x-modal>

@push('script')
<script src="{{ asset('assets/external/jquery-validation/additional-methods.js') }}"></script>
<script>
    function resetFormAdd() {
        $('#form-add-anggota')[0].reset();
        $('#jenis_kelamin').val('l').trigger('change');
        $('#status_menikah').val('1').trigger('change');
        $('#departemen').val('1').trigger('change');
        $('#pekerjaan').val('1').trigger('change');
        $('#agama').val('1').trigger('change');
        $('.error').remove();
        $('.is-invalid').removeClass('is-invalid');
    }

    function addAnggota(modalAdd) {
        let formData = new FormData($('#form-add-anggota')[0]);
        formData.append('photo', $('#photo')[0].files.length > 0 ? $('#photo')[0].files[0] : '');

        $.ajax({
            url: "{{ url('master-data/anggota') }}",
            type: 'post',
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            beforeSend: function() { showLoading(); },
            data: formData,
            success: function(response) {
                showAlertSuccess(response.message);
                resetFormAdd();
                modalAdd.hide();
                getData();
            },
            error: function(xhr) {
                showAlertError(xhr.responseJSON?.message);
            }
        });
    }

    $(document).ready(function() {

        $('#jenis_kelamin, #status_menikah, #departemen, #pekerjaan, #agama').select2({
            dropdownParent: $('#modal-add-anggota'),
            minimumResultsForSearch: -1
        });

        $('#tanggal_lahir').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '-80:+0',
            onClose: function(dateText, inst) {
                dateObject = $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay, 1));
            }
        })
        // .datepicker("setDate", new Date(2000, 1, 01));

        let modalAdd = new bootstrap.Modal('#modal-add-anggota', {
            backdrop: 'static',
        });

        $('#form-add-anggota').validate({
            submitHandler: function(form) {
                addAnggota(modalAdd);
            },
            rules: {
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 30
                },
                nama_lengkap: {
                    required: true,
                    minlength: 3,
                    maxlength: 255,
                },
                jenis_kelamin: {
                    required: true,
                },
                tempat_lahir: {
                    required: true,
                },
                tanggal_lahir: {
                    required: true,
                },
                status_menikah: {
                    required: true,
                },
                departemen: {
                    required: true,
                },
                pekerjaan: {
                    required: true,
                },
                agama: {
                    required: true,
                },
                alamat: {
                    required: false,
                },
                kota: {
                    required: false,
                },
                no_hp: {
                    required: false,
                },
                photo: {
                    required: false,
                    extension: 'jpg|jpeg|png'
                }
            }
        });
    });
</script>
@endpush
