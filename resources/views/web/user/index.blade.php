@extends('layouts.master')

@section('content')
<div class="col-md-12">
    @include('includes.flash-message')
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Users List</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <a href="{{ route('user.create') }}" class="btn btn-primary" style="margin-bottom:20px;">New User</a>
          
        <table class="table table-bordered">
          <tbody><tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Active</th>
            <th>Email</th>
            <th style="width: 210px">Action</th>
          </tr>
          @if (($users->count() == 0))
            <tr>
              <td></td>
              <td>Tidak ada record yang ditemukan</td>
            </tr>
          @endif
          @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>
                  @if($user->is_active)
                    <a href="{{ route('user.switch', $user->id) }}" class="label bg-green cover">Active</a>
                  @else
                    <a href="{{ route('user.switch', $user->id) }}" class="label bg-red cover">Not Active</a>
                  @endif
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('user.edit', $user->id) }}"> <i class="fa fa-pencil"></i> Edit </a>
                    
                    <a href="#" class="btn-delete" data-id="{{ $user->id }}"><i class="nav-icon fa fa-trash"></i> Delete </a>
                      <form action="{{ route('user.destroy', $user->id)}}" method="POST" id="form-{{ $user->id }}">
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
        {{ $users->links() }}
      </div>
    </div>
    <!-- /.box -->
  </div>
@endsection