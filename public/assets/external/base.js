// format duit. Example: 1,000,000
function rupiah(money) {
    return $.fn.dataTable.render.number(',', '.', 0).display(money);
}

function showAlertSuccess(msg = 'Success') {
    Swal.fire("", msg, "success");
}

function showAlertError(msg = 'Whoops, something went wrong') {
    Swal.fire("", msg, "error");
}

// tampilkan loading
function showLoading(msg = 'Sedang memproses, harap menunggu...') {
    Swal.fire({
        title: '',
        text: msg,
        html: '<div style="display: flex; justify-content: center; flex-direction: column; align-items: center;"><div class="loader-spinner"></div><div style="margin-top: 20px; font-size: 16px; color: #222;">Sedang Memproses, harap menunggu...</div><div>',
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
        showLoaderOnConfirm: false
    });
}

// sembunyikan loading
function hideLoading() {
    Swal.close()
}

// return number on key press event
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

// format date with time. d-m-Y H:i
function dateFormatTime(datetime, withSecond = false) {
    let ta = new Date(datetime);
    let month = (1 + ta.getMonth()).toString();
    let mta = month.length > 1 ? month : '0' + month;
    let date = ta.getDate().toString();
    let tgl = date.length > 1 ? date : '0' + date;

    let hours = ta.getHours();
    let minutes = ta.getMinutes();
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    let sec = '';

    let strTime = hours + ':' + minutes;
    if (withSecond) {
        let seconds = ta.getSeconds();
        let s = seconds < 10 ? '0' + seconds : seconds;
        strTime += ':' + s;
    }

    return tgl + '-' + mta + '-' + ta.getFullYear() + ' ' + strTime;
}

// return date format d-m-Y
function dateFormat(datetime) {
    let dates = datetime.split(' ');
    let ta = new Date(dates[0]);
    let month = (1 + ta.getMonth()).toString();
    let mta = month.length > 1 ? month : '0' + month;
    let date = ta.getDate().toString();
    let tgl = date.length > 1 ? date : '0' + date;

    return tgl + '-' + mta + '-' + ta.getFullYear();
}

function downloadFile(url, params, errorMessage = 'File tidak ditemukan di server') {
    let decode = JSON.parse(params);

    $.ajax({
        url: url,
        type: "post",
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function() {
            showLoading();
        },
        xhr: function() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 2) {
                    if (xhr.status == 200) {
                        xhr.responseType = "blob";
                    } else {
                        xhr.responseType = "text";
                    }
                }
            };
            return xhr;
        },
        data: decode,
        success: function(data, status, xhr) {
            hideLoading();
            var fileName = xhr.getResponseHeader('content-disposition').split('filename=')[1].split(';')[0];
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = fileName.replace(/\"/g, '');
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        },
        error: function(xhr, stat, err) {
            hideLoading();

            $('p.text-danger').remove();
            $('.form-line.has-error').removeClass('has-error');

            if (xhr.status == 400 || xhr.status == 404) {
                swal('', errorMessage, 'warning');
            }

            if(xhr.status == 422) {
                $.each(xhr.responseJSON, (key, val) => {
                    let el = $('#' + key);

                    let newVal = `<p class="text-danger" for="${key}" id="${key}-error">${val}</p>`;
                    el.closest('div.form-line')
                    .removeClass('has-error')
                    .addClass(val.length > 0 ? 'has-error' : '')
                    .find('p.text-danger')
                    .remove();
                    el.after(newVal);
                });
            }
        }
    })
}

$('.sidebar-toggle').on('click', function () {
    if (!$.fn.DataTable.isDataTable('.responsive-datatable')) {
        $('.responsive-datatable').DataTable().columns.adjust();
    }
} );

$(document).ready(function() {
    // let urlPage = window.location.href;
    // let linkUrl = urlPage.split('?')[0];

    // $('a[href="'+linkUrl+'"]').addClass('active');

    // if ($('a[href="'+linkUrl+'"]').parents('.sub-nav.collapse').length > 0) {
    //     let subNav = $('a[href="'+linkUrl+'"]').parents('.sub-nav.collapse');
    //     subNav.siblings('.nav-link').attr('aria-expanded', 'true');
    // 	subNav.addClass('show');
    // }

    $.extend($.fn.dataTable.defaults, {
        language: {
            paginate: {
                previous: 'Prev',
                next: `Next`
            }
        },
        searchDelay: 200
    });

    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        }
    });

    $( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {

        if(jqxhr.status === 401 && jqxhr.responseJSON.telah_logout) {
            if(confirm(`User ${nameOld} (${userIdOld}) telah logout, harap melakukan reload page atau login kembali.`)) {
                window.location.reload();
                return;
            }
        } else if(jqxhr.status === 401 || jqxhr.status === 419) {
            window.location.href = '/login';
        }
    });

    $.validator.setDefaults({
        debug: false,
        ignore: "",
        highlight: function(element) {
            $(element).addClass('is-invalid');
            $(element).siblings('.select2-container').find('.select2-selection').addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
            $(element).siblings('.select2-container').find('.select2-selection').removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            let errText = error.addClass('text-danger');
            if (element.hasClass('select-dua') || element.hasClass('select2-without-search')) {
                errText.insertAfter(element.siblings('.select2'));
            } else {
                errText.insertAfter(element);
            }
        }
    });



});
