@if(Route::is('teacher.index') || Route::is('student.index') 
    || Route::is('industry.index') || Route::is('period.index') 
    || Route::is('placement.index') || Route::is('activity.index')
    || Route::is('department.index') || Route::is('discussion.index')))
<script>
$(document).on('click','.btn-delete', function(){
    formid = $(this).attr('data-id');
    swal({
        title: 'Anda yakin ingin manghapus?',
        text: "item ini tidak dapat dikembalikan setelah di hapus!, item terkait akan ikut terhapus.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
                $('#form-' + formid).submit();
            }
    })
})
</script>
@endif

@if (Route::is('period.create') || Route::is('period.edit'))
<script>
    var selector = document.getElementById("school_year");

    var im = new Inputmask("9999/9999");
    im.mask(selector);
</script>
@endif

<script>
$(document).on('change','#periodId', function(){
    url = $(this).val();
    location.href = url;
})
</script>