@extends('layouts.master')

@section('content')
<div class="col-md-6">
    @if($errors->first())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
    @endif
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ isset($place) ? 'Edit' : 'New'}} Place</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="{{ isset($place) ? route('place.update', $place->id) : route('place.store') }}" method="POST" enctype="multipart/form-data">
            <div class="box-body">
                @csrf
               <div class="form-group">
                    <label for="name">Name </label>
                    <input type="text" class="form-control" id="name" placeholder="Place Name" name="name" required value="{{ isset($place) ? $place->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="name">Description </label>
                    <textarea name="description" id="" cols="30" rows="10" class="form-control">
                            {{ isset($place) ? $place->description : old('description') }}
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="name">Address </label>
                    <input type="text" class="form-control" id="name" placeholder="Place Address" name="address" required value="{{ isset($place) ? $place->address : old('address') }}">
                </div>
                <div class="form-group">
                    <label for="name">Location </label>
                    <div class="row">
                        <div class="col-md-6">
                          <input id="lat" type="text" name="latitude" class="form-control" placeholder="Latitude" readonly>
                        </div>
                        <div class="col-md-6">
                          <input id="long" type="text" name="longitude" class="form-control" placeholder="Longitude" readonly>
                        </div>
                      </div>
                      <sub>drag map marker to change location</sub>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save and Add Image</button>
                <a href="{{ route('index') }}" class="btn btn-default pull-right">Batal</a>
            </div>
        </form>
    </div>
</div>
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div id="map" style="height:400px;width:100%"> Map </div>
        </div>
    </div>
</div>
@endsection