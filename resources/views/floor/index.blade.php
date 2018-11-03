@extends('layouts.app')

@section('title', 'Administration')
@section('body-class', 'manager')

@section('content')
    <div id="nav-wrapper">
        <div class="container">
            <h2>Floors Management of {{ $building->name }}</h2>
        </div>
    </div>
    <div id="content" class="container">
        {{-- Partials --}}
        @include('partials.notifications')

        <div class="row">
            <div class="col-xs-12 col-sm-10">
                <input type="text" data-href="{{ route('buildings.floors.index', $building->encoded_id) }}" class="form-control" id="search_field" placeholder="Search" value="{{ $search }}">
            </div>
            <div class="col-xs-12 col-sm-2">
                <button id="search" data-href="{{ route('buildings.floors.index', $building->encoded_id) }}" class="btn btn-primary btn-block">Search</button>
            </div>
        </div>
        <hr>
        <a href="{{ route('buildings.floors.create', $building->encoded_id) }}" class="btn btn-info btn-xs" style="margin-bottom: 15px;">Create new floor</a>
        <div class="panel panel-default">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Blueprint</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($floors as $floor)
                    <tr>
                        <td>{{ $building->id }}</td>
                        <td>
                            <a href="{{ route('buildings.floors.show', [$building->encoded_id, $floor->encoded_id]) }}">
                                {{ $floor->name }}
                            </a>
                        </td>
                        <td>
                            {{ $building->blueprint }}
                        </td>
                        <td>
                            <form role="form" method="POST" style="width:49%;display: inline-block;"
                                  action="{{ route('buildings.floors.destroy', [$building->encoded_id, $floor->encoded_id]) }}">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-block btn-xs" style="width: 100%"
                                        type="submit" onclick="return confirm('Are you sure ?');">
                                    Remove floor
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {!! $floors->appends(['sort' => 'floors', 'search' => $search])->render() !!}
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
