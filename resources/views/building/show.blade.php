@extends('app')

@section('title', 'Administration')
@section('body-class', 'manager')

@section('body')
    <div id="nav-wrapper">
        @include('admin.navs')
        <div class="container">
            <h2>{{ $building->name }}</h2>
        </div>
    </div>
    <div id="content" class="container">
        <div class="row">
            <div class="col-xs-12">
                @if ($readonly)
                    <a href="{{ route('admin.buildings.edit', $building->encoded_id) }}" class="pull-right btn btn-default">Edit</a>
                @else
                    <button type="submit" class="pull-right btn btn-primary" form="form">Save</button>
                    <a href="{{ route('admin.buildings.show', $building->encoded_id) }}" class="pull-right btn btn-link">Cancel</a>
                @endif
            </div>
        </div>
        <br>
        @include('partials.notifications')

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <form enctype="multipart/form-data" id="form" role="form" method="POST" action="{{ route('admin.buildings.update', $building->encoded_id) }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $building->name }}" {{ $readonly ? 'readonly' : '' }}>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <input type="text" class="form-control" placeholder="Address" name="address" value="{{ $building->address }}" {{ $readonly ? 'readonly' : '' }}>
                    </div>
                    <!--
                    if (!$readonly)
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" id="logo" name="logo">
                        </div>
                    elseif($group->logo)
                        Logo :<br><br>
                        <div class="thumbnail">
                            <img src="{{-- $group->logo --}}">
                        </div>
                    endif
                            -->
                    <hr>
                    <div class="form-group">
                        <label for="created_at" class="control-label">Created At :</label>
                        <input type="text" class="form-control" id="created_at" value="{{ $building->created_at ? $building->created_at->toDayDateTimeString() : '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="updated_at" class="control-label">Updated At :</label>
                        <input type="text" class="form-control" id="updated_at" value="{{ $building->updated_at ? $building->updated_at->toDayDateTimeString() : '' }}" readonly>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class="control-label">Floors :</label>
                    <ul class="list-group">
                        @foreach($building->floors as $floor)
                        <li class="list-group-item">
                            Name :
                            <strong>{{ $floor->name }}</strong>
                            <span style="float: right">
                            Blueprint :
                            <strong>{{ ($floor->blueprint)? 'YES':'NO' }}</strong>
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('admin.buildings.floors.index', $building->encoded_id) }}" class="btn btn-info btn-xs">Manage floors of this building</a>
            </div>
        </div>
    </div>
@endsection
