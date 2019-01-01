@if(Route::is('index') || Route::is('user.index'))
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