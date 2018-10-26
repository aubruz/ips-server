@extends('app')

@section('title', 'Administration')
@section('body-class', 'manager')

@section('body')
    <div id="nav-wrapper">
        @include('admin.navs')
        <div class="container">
            <h2>Create a floor for {{ $building->name }}</h2>
        </div>
    </div>
    <div id="content" class="container">
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="pull-right btn btn-primary" form="form">Save</button>
            </div>
        </div>
        <br>
        @include('partials.notifications')

        <div class="row">
            <div class="col-xs-12">
                <form id="form" role="form" enctype="multipart/form-data" method="POST" action="{{ route('admin.buildings.floors.store', $building->encoded_id) }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
