@extends('layout.layout')
@section('title', 'Aerocraft Engineering')
@section('content')
<section id="form">
  <div class="col-6 mx-auto r-anf-cont">
    <h1 class="text-center mt-5 pageTitle roboto-thin">Create New Event</h1>
    <hr>
    <form>
      @csrf
      <div class="form-group r-fg-mt r-fg-w">
        <label class="form-label" for="title">Title</label>
        <input type="text" name="title" class="form-control">
      </div>
      <div class="form-group r-fg-mt r-fg-w mt-3">
        <label class="form-label" for="sdate">Start Date</label>
        <input type="text" name="sdate" class="form-control datepicker">
      </div>
      <div class="form-group r-fg-w">
        <label class="form-label mt-4" for="repeat">Repeat Every</label>
        <select name="repeat" class="form-select repeat">
          <option value="Day">Day</option>
          <option value="Week">Week</option>
          <option value="Month">Month</option>
          <option value="Year">Year</option>
        </select>
      </div>
      <div class="form-group r-fg-w repeatDay">
        <label class="form-label mt-4" for="repeatDay">Repeat On Every</label>
        <select name="repeatDay" class="form-select repeatDayVal">
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
          <option value="Saturday">Saturday</option>
          <option value="Sunday">Sunday</option>
        </select>
      </div>
      <div class="form-group r-fg-mt r-fg-w mt-3 frequency">
        <div class="d-flex">
          <label class="form-label mt-1" for="frequency">Repeat Every</label>
          <div class="col-1 ms-2 me-2">
            <input type="text" name="frequency" value="1" class="form-control" onkeypress="validate(event)"> 
          </div>
          <span class="mt-1">Month(s)</span>
        </div>
      </div>
      <div class="form-group r-fg-mt r-fg-w mt-4">
        <label class="form-label me-5" for="when">End When</label>
        <input type="radio" name="when" class="when" value="date" checked> On Certain Date &nbsp;&nbsp;
        <input type="radio" name="when" class="when" value="occr"> After Defined Occurrences
      </div>
      <div class="form-group r-fg-mt r-fg-w mt-3 edate">
        <label class="form-label" for="edate">End Date</label>
        <input type="text" name="edate" class="form-control datepicker">
      </div>
      <div class="form-group r-fg-mt r-fg-w mt-3 eafter">
        <div class="d-flex">
          <label class="form-label mt-1" for="eafter">End After</label>
          <div class="col-1 ms-2 me-2">
            <input type="text" name="eafter" class="form-control text-center" value="1" onkeypress="validate(event)">
          </div>
          <span class="mt-1">Occurrence(s)</span>
        </div>
      </div>
      <div class="form-block r-fb mt-3 mb-5">
        <button type="submit" class="btn btn-primary r-fg-mt r-fg-w action w-100" data-type="create">Create Event</button>
      </div>
    </form>
  </div>
</section>
@endsection