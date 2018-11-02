@if (Session::has('error'))
    <div class="alert alert-{{ Session::has('notification_level') ? Session::get('notification_level') : 'warning' }}" role="alert">
        {{ Session::get('error') }}
    </div>
@endif

{{-- Form Validation --}}
@if ($errors !== null && count($errors))
    <div class="alert alert-{{ Session::has('notification_level') ? Session::get('notification_level') : 'warning' }}" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

{{-- Notification --}}
@if (Session::has('notification'))
    <div class="alert alert-{{ Session::has('notification_level') ? Session::get('notification_level') : '' }}" role="alert">
        {{ Session::get('notification') }}
    </div>
@endif

{{-- Status --}}
@if (Session::has('status'))
    <div class="alert alert-{{ Session::has('status_level') ? Session::get('status_level') : '' }}" role="alert">
        {{ Session::get('status') }}
    </div>
@endif
