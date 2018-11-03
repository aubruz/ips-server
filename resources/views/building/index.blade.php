@extends('layouts.app')

@section('title', 'Administration')
@section('body-class', 'buildings')

@section('content')
    <div id="nav-wrapper">
        <div class="container">
            <h2>Buildings Management</h2>
        </div>
    </div>
    <div id="content" class="container">
        {{-- Partials --}}
        @include('partials.notifications')

        <div class="row">
            <div class="col-xs-12 col-sm-10">
                <input type="text" data-href="{{ route('buildings.index') }}" class="form-control" id="search_field" placeholder="Search" value="{{ $search }}">
            </div>
            <div class="col-xs-12 col-sm-2">
                <button id="search" data-href="{{ route('buildings.index') }}" class="btn btn-primary btn-block">Search</button>
            </div>
        </div>
        <hr>
        <a href="{{ route('buildings.create') }}" class="btn btn-info btn-xs" style="margin-bottom: 15px;">Create new building</a>
        <div class="panel panel-default">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($buildings as $building)
                    <tr>
                        <td>{{ $building->id }}</td>
                        <td>
                            <a href="{{ route('buildings.show', $building->encoded_id) }}">
                                {{ $building->name }}
                            </a>
                        </td>
                        <td>
                            {{ $building->address }}
                        </td>
                        <td>
                            <a href="{{ route('buildings.floors.index', $building->encoded_id) }}" class="btn btn-info btn-xs" style="width:49%;">Manage floors</a>
                            <form role="form" method="POST" style="width:49%;display: inline-block;"
                                  action="{{ route('buildings.destroy', $building->encoded_id) }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @csrf
                                <button class="btn btn-danger btn-block btn-xs" style="width: 100%"
                                        type="submit" onclick="return confirm('Are you sure ?');">
                                    Remove building
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {!! $buildings->appends(['sort' => 'buildings', 'search' => $search])->render() !!}
        </div>
    </div>
@endsection

@section('custom_script')
    <script>
        $(document).ready(function () {
            $('#search_field').keypress(function (e) {
                if (e.which == 13) {
                    window.document.location = $(this).data('href') + '?search=' + $('#search_field').val();

                }
            });
            $('#search').click(function () {
                window.document.location = $(this).data('href') + '?search=' + $('#search_field').val();
                return false;
            });
        });
    </script>
@endsection
