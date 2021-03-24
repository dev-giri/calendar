@extends('calendar::layouts.master')

@section('title', config('calendar.name'))

@section('vendor-style')
  <!-- Vendor css files -->
  <link rel="stylesheet" href="{{ asset('themes/girisoft/vendors/css/calendars/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/girisoft/vendors/css/forms/select/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/girisoft/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('themes/girisoft/css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/girisoft/css/base/plugins/forms/form-validation.css') }}">


  <link rel="stylesheet" href="{{ mix('css/calendar.css') }}"> 
@endsection


@section('content')
<!-- Full calendar start -->
<section>
  <div class="app-calendar overflow-hidden border">
    <div class="row no-gutters">
      <!-- Sidebar -->
      <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
        <div class="sidebar-wrapper">
          <div class="card-body d-flex justify-content-center">
            <button
              class="btn btn-primary btn-block" id="addANewEvent"
            >
              <span class="align-middle">Add Event</span>
            </button>
            <!-- <button
              class="btn btn-primary btn-toggle-sidebar btn-block"
              data-toggle="modal"
              data-target="#add-new-sidebar"
            >
              <span class="align-middle">Add Event</span>
            </button> -->
          </div>
          <div class="card-body pb-0">
            <h5 class="section-label mb-1">
              <span class="align-middle">Filter</span>
            </h5>
            <div class="custom-control custom-checkbox mb-1">
              <input type="checkbox" class="custom-control-input select-all" id="select-all" checked />
              <label class="custom-control-label" for="select-all">View All</label>
            </div>
            <div class="calendar-events-filter">
              @foreach($calendarTypes as $row)
              <div class="custom-control custom-control-{{$row->color}} custom-checkbox mb-1">
                <input
                  type="checkbox"
                  class="custom-control-input input-filter"
                  id="{{$row->color}}"
                  data-value="{{$row->slug}}"
                  checked
                />
                <label class="custom-control-label" for="{{$row->color}}">{{$row->display}}</label>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="mt-auto">
          <img
            src="{{ asset('themes/girisoft/images/pages/calendar-illustration.png') }}"
            alt="Calendar illustration"
            class="img-fluid"
          />
        </div>
      </div>
      <!-- /Sidebar -->

      <!-- Calendar -->
      <div class="col position-relative">
        <div class="card shadow-none border-0 mb-0 rounded-0">
          <div class="card-body pb-0">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
      <!-- /Calendar -->
      <div class="body-content-overlay"></div>
    </div>
  </div>
  <!-- Calendar Add/Update/Delete event modal-->
  <div class="modal modal-slide-in event-sidebar " id="add-new-sidebar">
    <div class="modal-dialog sidebar-lg">
      <div class="modal-content p-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        <div class="modal-header mb-1">
          <h5 class="modal-title">Add Event</h5>
        </div>
        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
          <form role="form" class="event-form needs-validation" method="POST" enctype="multipart/form-data" id="add-edit-event-form" data-ajax="false" novalidate>
            <!-- CSRF TOKEN -->
            {{ csrf_field() }}
            <div class="form-group">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Event Title" required />
            </div>
            <div class="form-group">
              <label for="select-label" class="form-label">Label</label>
              <select class=" select-label form-control w-100" id="select-label" name="label">
                <option data-label="primary" value="Business" selected>Business</option>
                <option data-label="danger" value="Personal">Personal</option>
                <option data-label="warning" value="Family">Family</option>
                <option data-label="success" value="Holiday">Holiday</option>
                <option data-label="info" value="ETC">ETC</option>
              </select>
            </div>
            <div class="form-group position-relative">
              <label for="start-date" class="form-label">Start Date</label>
              <input type="text" class="form-control" id="start-date" name="start" placeholder="Start Date" required data-date-format="F d, Y G:i K" />
            </div>
            <div class="form-group position-relative">
              <label for="end-date" class="form-label">End Date</label>
              <input type="text" class="form-control" id="end-date" name="end" placeholder="End Date" required data-date-format="F d, Y G:i K" />
            </div>
            <div class="form-group">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input allDay-switch" id="customSwitch3" name="allDay" />
                <label class="custom-control-label" for="customSwitch3">All Day</label>
              </div>
            </div>
            <div class="form-group">
              <label for="event-url" class="form-label">Event URL</label>
              <input type="url" class="form-control" id="event-url" placeholder="https://www.google.com" name="url" />
            </div>
            <div class="form-group select2-primary">
              <label for="event-guests" class="form-label">Add Guests</label>
              <select class=" select-add-guests form-control w-100" id="event-guests" multiple>
                @if(isset($users))
                @foreach($users as $user)
                <option data-avatar="{{$user->avatar}}" value="{{$user->username}}">{{$user->name}}</option>
                @endforeach
                @else
                <option data-avatar="1-small.png" value="Jane Foster">
                <option data-avatar="3-small.png" value="Donna Frank">Donna Frank</option>
                <option data-avatar="5-small.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                <option data-avatar="7-small.png" value="Lori Spears">Lori Spears</option>
                <option data-avatar="9-small.png" value="Sandy Vega">Sandy Vega</option>
                <option data-avatar="11-small.png" value="Cheryl May">Cheryl May</option>
                @endif
              </select>
            </div>
            <div class="form-group">
              <label for="event-location" class="form-label">Location</label>
              <input type="text" class="form-control" id="event-location" placeholder="Enter Location" name="location"/>
            </div>
            <div class="form-group">
              <label class="form-label">Description</label>
              <textarea name="description" id="event-description-editor" class="form-control" ></textarea>
            </div>
            <div class="form-group d-flex">
              <button type="submit" class="btn btn-primary add-event-btn mr-1">Add</button>
              <button type="button" class="btn btn-outline-secondary btn-cancel" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary update-event-btn d-none mr-1">Update</button>
              <button class="btn btn-outline-danger btn-delete-event d-none">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--/ Calendar Add/Update/Delete event modal-->
</section>
<!-- Full calendar end -->
@endsection

@section('vendor-script')
  <!-- Vendor js files -->
  <script src="{{ asset('themes/girisoft/vendors/js/calendar/fullcalendar.min.js') }}"></script>
  <script src="{{ asset('themes/girisoft/vendors/js/extensions/moment.min.js') }}"></script>
  <!-- <script src="{{ asset('themes/girisoft/vendors/js/forms/select/select2.full.min.js') }}"></script> -->
  <script src="{{ asset('themes/girisoft/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('themes/girisoft/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ mix('js/calendar.js') }}"></script>
@endsection