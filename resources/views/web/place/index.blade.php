@extends('layouts.master')

@section('content')
<div class="col-md-12">
    @include('includes.flash-message')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Places List</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <a href="{{ route('place.create') }}" class="btn btn-primary" style="margin-bottom:20px;">New Place</a>
          
        <table class="table table-bordered">
          <tbody><tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Address</th>
            <th style="width: 120px">Action</th>
          </tr>
          @if (($places->count() == 0))
            <tr>
              <td></td>
              <td>Tidak ada record yang ditemukan</td>
            </tr>
          @endif
          @foreach ($places as $place)
            <tr>
                <td>{{ $place->id }}</td>
                <td>{{ $place->name }}</td>
                <td>{{ $place->address }}</td>
                <td>
                    <a href="{{ route('place.edit', $place->id) }}"> <i class="fa fa-pencil"></i> Edit </a>
                    
                    <a href="#" class="btn-delete" data-id="{{ $place->id }}"><i class="nav-icon fa fa-trash"></i> Delete </a>
                      <form action="{{ route('place.destroy', $place->id)}}" method="POST" id="form-{{ $place->id }}">
                          @csrf 
                      </form>
                </td>
            </tr>
          @endforeach
        </tbody></table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
        {{-- PAGINATION IS HERE --}}
        {{ $places->links() }}
      </div>
    </div>
    <!-- /.box -->
  </div>
@endsection