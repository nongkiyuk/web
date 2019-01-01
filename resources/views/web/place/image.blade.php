@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6">
        @include('includes.flash-message')
        <div class="alert alert-success" id="alert" style="display:none">Message</div>
        <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Place Images</h3>
                </div>
                <div class="box-body">
                    <form role="form" enctype="multipart/form-data" method="POST" action="{{ route('place.images', $id) }}" class="dropzone" id="dropzone">
                        @csrf
                        <div class="dz-message needsclick">
                            Drop some image here or click to upload.
                        </div>
                    </form>
                    <a class="btn btn-primary col-md-1" href="{{ route('index') }}" style="margin:10px 10px 0px 0px">Save</a>
                </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
            <h3 class="box-title">Place Images : {{ $place->name }}</h3>
            </div>
            <div class="box-body">
                <div class="row" style="margin-top: 20px;" id="imageGrid">
                    <div id="startGrid"></div>
                    @foreach ($place->images as $image)
                    <div class="col-md-3" grid-id="{{ $image->id }}">
                        @if($image->is_cover)
                            <p class="label bg-green cover">Cover</p>
                        @endif
                        <img class="img-fluid img-responsive" src="{{ asset(env('PLACE_IMAGE_PATH').$image->image) }}" alt="">
                        <button class="btn btn-danger col-md-12 galery-remove" img-id="{{ $image->id }}">Delete</button>
                        @if(!$image->is_cover)
                            <p class="label bg-primary cover set-cover" img-id="{{ $image->id }}">Set Cover</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        .galery-remove{
            margin-bottom: 5px;
        }
        .cover{
            position: absolute; 
            top: 5px; 
            left: 20px; 
        }
    </style>
@endsection

@section('js')
<script>
    var msgBox =  document.getElementById('alert');
    function showAlert(data)
    {
        msgBox.innerText = data;
        msgBox.style.display = 'block';
        setTimeout(function(){
            msgBox.style.display = 'none';
        }, 3000);
    }
</script>
{{-- dropzone --}}
<script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>
<script>
  Dropzone.autoDiscover = false;
  $(function() {
    // Now that the DOM is fully loaded, create the dropzone, and setup the
    // event listeners
    var myDropzone = new Dropzone("#dropzone");

    //when file add to upload
    myDropzone.on("addedfile", function(file, response) {
      file.previewElement.addEventListener("click", function() {
        myDropzone.removeFile(file);
      });
    });

    //when upload was success
    myDropzone.on("success", function(file, response){
        if(response.data.cover == 1){
            cover = "<p class='label bg-green cover'>Cover</p>";
        }else{
            cover = "<p class='label bg-primary cover set-cover' img-id='" + response.data.id + "'>Set Cover</p>";
        }
      $(
          "<div class='col-md-3' grid-id='"+ response.data.id +"'> " +
                "<img class='img-fluid  img-responsive' src='" + response.data.url +"' alt=''> "+
                "<button class='btn btn-danger col-md-12 galery-remove' img-id='"+ response.data.id +"' onclick=''>Delete</button>" +
                cover +
           "</div>"
      ).insertAfter('#startGrid');
      showAlert(response.message)
    });

    //when upload was error
    myDropzone.on("error", function(file, response){
        showAlert(response)
    });
  });
</script>
<script>
    $(document).on('click', '.galery-remove', function(){
        var agree = confirm('Are you sure you want to delete the item ?');
        if(agree){
            var url = '{{ url()->current() }}';
            var id = $(this).attr('img-id');
            $.ajax({
                method: "GET",
                url: url + '/' + id + '/delete',
                success: function(data){
                    $('div[grid-id=' + id + ']').remove();
                    showAlert(data);
                },
                error: function(data){
                    showAlert(data.responseJSON[0]);
                }
            });
        } 
    });
</script>
<script>
    $(document).on('click', '.set-cover', function(){
        var url = '{{ url()->current() }}';
        var id = $(this).attr('img-id');
        window.location.replace(url + '/' + id + '/cover')
    });
</script>
@endsection