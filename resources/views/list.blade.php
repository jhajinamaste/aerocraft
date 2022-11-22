@extends('layout.layout')
@section('title', 'Aerocraft Engineering')
@section('content')
<section id="form" class="roboto-condensed">
  <div class="col-6 mx-auto r-anf-cont">
    <h1 class="text-center mt-5 pageTitle roboto-thin">Event List</h1>
    <hr>
    <div class="events">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Sl. No.</th>
            <th>Event</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key => $val)
          <tr>
            <td>{{++$key}}</td>
            <td>{{$val->title}}</td>
            <td>
              <a href="#" class="btn btn-sm btn-info view" data-id="{{$val->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">View</a>
              <a href="#" class="btn btn-sm btn-danger action" data-type="delete" data-id="{{$val->id}}">Delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>    
  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title roboto-thin" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="event-data"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</section>

@endsection