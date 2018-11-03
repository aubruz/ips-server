@extends('layouts.app')

@section('title', 'Administration')
@section('body-class', 'buildings')

@section('content')
    <div class="container">
        <h2>Create building</h2>
    </div>
    <div id="content" class="container">
        @include('partials.notifications')

        <div class="row">
            <div class="col-12">
                <form id="form" role="form" method="POST" action="{{ route('buildings.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <input type="text" class="form-control" placeholder="Address" name="address" value="{{ old('address') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="pull-right btn btn-primary" form="form">Save</button>
            </div>
        </div>
    </div>
@endsection
