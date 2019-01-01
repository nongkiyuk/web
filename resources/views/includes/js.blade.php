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

@if(Route::is('place.create') || Route::is('place.edit') )
@isset($place)
<script>
    lat = {{ $place->latitude }};
    lng = {{ $place->longitude }};
    var amikom = { //-7.759891, 110.408463
      lat: lat, 
      lng: lng
    }; 
</script>
@else
<script>
    var amikom = { //-7.759891, 110.408463
        lat: -7.759891, 
        lng: 110.408463
    }; 
</script>
@endisset
<script>
function initMap() {
  inputLat = document.getElementById('lat');
  inputLong = document.getElementById('long');
  inputLat.value = (amikom.lat);
  inputLong.value = (amikom.lng);

  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 17, center: amikom});
  var marker = new google.maps.Marker({
      position: amikom, 
      map: map,
      title: 'Tag Your Location',
      draggable: true
    });
    google.maps.event.addListener(marker, 'dragend', function(evt){ 
        lat = evt.latLng.lat().toFixed(8);
        long = evt.latLng.lng().toFixed(8);
        

        inputLat.value = (lat);
        inputLong.value = (long);

        console.log(lat + ', ' + long)
    });

}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAP_APIKEY') }}&callback=initMap" type="text/javascript"></script>
@endif
