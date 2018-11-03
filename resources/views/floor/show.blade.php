@extends('layouts.app')

@section('title', 'Administration')
@section('body-class', 'floors')

@section('content')
    <div id="nav-wrapper">
        <div class="container">
            <h2>Floor {{ $floor->name }} of {{ $building->name }}</h2>
        </div>
    </div>
    <div id="content" class="container">
        <div class="row">
            <div class="col-xs-12">
                @if ($readonly)
                    <a href="{{ route('buildings.floors.edit', [$building->encoded_id, $floor->encoded_id]) }}" class="pull-right btn btn-default">Edit</a>
                @else
                    <button type="submit" class="pull-right btn btn-primary" form="form">Save</button>
                    <a href="{{ route('buildings.floors.show', [$building->encoded_id, $floor->encoded_id]) }}" class="pull-right btn btn-link">Cancel</a>
                @endif
            </div>
        </div>
        <br>
        @include('partials.notifications')

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <form enctype="multipart/form-data" id="form" role="form" method="POST" action="{{ route('buildings.floors.update', [$building->encoded_id, $floor->encoded_id]) }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $floor->name }}" {{ $readonly ? 'readonly' : '' }}>
                    </div>

                    <div class="form-group">
                        <label for="width" class="control-label">Width (m)</label>
                        <input type="text" class="form-control" placeholder="Width" name="width" value="{{ $floor->width }}" {{ $readonly ? 'readonly' : '' }}>
                    </div>

                    <div class="form-group">
                        <label for="height" class="control-label">Height (m)</label>
                        <input type="text" class="form-control" placeholder="Height" name="height" value="{{ $floor->height }}" {{ $readonly ? 'readonly' : '' }}>
                    </div>

                    @if (!$readonly)
                        <div class="form-group">
                            <label for="blueprint">Blueprint</label>
                            <input type="file" id="blueprint" name="blueprint">
                        </div>
                    @elseif($floor->blueprint)
                        Blueprint :<br><br>
                        <div class="thumbnail">
                            <img src="{{ $floor->blueprint }}">
                        </div>
                    @endif
                    <hr>
                    <div class="form-group">
                        <label for="created_at" class="control-label">Created At :</label>
                        <input type="text" class="form-control" id="created_at" value="{{ $floor->created_at ? $floor->created_at->toDayDateTimeString() : '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="updated_at" class="control-label">Updated At :</label>
                        <input type="text" class="form-control" id="updated_at" value="{{ $floor->updated_at ? $floor->updated_at->toDayDateTimeString() : '' }}" readonly>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-6">
                <!--<div class="form-group">
                    <label class="control-label">Building Informations :</label>
                    <ul class="list-group">
                        <li class="list-group-item">Users :
                            <strong>{{-- $group->users()->count() --}}</strong>
                        </li>
                        <li class="list-group-item">Invitation pending:
                            <strong>{{-- $group->invitations()->count() --}}</strong></li>
                        <li class="list-group-item">Manager : <strong>{{-- $group->managers()->count() --}}</strong></li>
                    </ul>
                </div>-->
            </div>
        </div>
    </div>
@endsection
