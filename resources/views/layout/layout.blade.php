<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ url('assets') }}/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ url('assets') }}/css/ui.css">
  <link rel="stylesheet" href="{{ url('assets') }}/css/style.css">
</head>
<body>
  <div  class="pageLoader"></div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light roboto-condensed">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('/') }}">Aerocraft Engineering</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarColor03">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">Create Event</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/list') }}">Event List</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  @yield('content')
  <script src="{{ url('assets') }}/js/jquery.min.js"></script>
  <script src="{{ url('assets') }}/js/bootstrap.min.js"></script>
  <script src="{{ url('assets') }}/js/ui.js"></script>
  <script src="{{ url('assets') }}/js/swal.js"></script>
  <script src="{{ url('assets') }}/js/app.js"></script>
</body>
</html>