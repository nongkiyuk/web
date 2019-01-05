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
            <h3 class="box-title">{{ isset($user) ? 'Edit' : 'New'}} User</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST" enctype="multipart/form-data">
            <div class="box-body">
                @csrf
               <div class="form-group">
                    <label for="name">Name </label>
                    <input type="text" class="form-control" id="name" placeholder="Name" name="name" required value="{{ isset($user) ? $user->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail </label>
                    <input type="email" class="form-control" id="email" placeholder="email" name="email" required value="{{ isset($user) ? $user->email : old('email') }}">
                </div>
                <div class="form-group">
                        <label for="picture">Picture </label>
                        <input type="file" class="form-control" id="picture" name="picture">
                    </div>
                <div class="form-group">
                    <label for="username">Username </label>
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" required value="{{ isset($user) ? $user->username : old('username') }}">
                </div>
                <div class="form-group">
                    <label for="password">Password </label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                    <sub>left blank if not change</sub>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('user.index') }}" class="btn btn-default pull-right">Batal</a>
            </div>
        </form>
    </div>
</div>
@isset($user)
<div class="col-md-3">
    <div class="box box-primary">
        <div class="box-body">
            <img src="{{ $user->picture }}" alt="" class="img-responsive" >
        </div>
    </div>
</div>
@endisset
@endsection