@section('title', 'Dashboard')
@section('page-header', 'Dashboard')
@section('optional-header', 'Highlight Data')

@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>200</h3>

                <p>Total</p>
            </div>
            <div class="icon">
                <i class="ion ion-cube"></i>
            </div>
        </div>
    </div>
</div>
@endsection