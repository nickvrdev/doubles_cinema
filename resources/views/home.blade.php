@extends('layouts.app')

@section('content')
@if(Auth::user())
<div class="text-center"><p>{{ __('Welcome back!') }} {{ Auth::user()->name ?: Auth::user()->email }}</p></div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Make a booking') }}</div>

                <div class="card-body">
                    <form id="booking-form" method="POST" action="{{ route('booking.create') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="cinema" class="col-md-4 col-form-label text-md-right">{{ __('Cinema') }}</label>

                            <div class="col-md-6">
                                <select id="cinema-select" name="cinema" class="form-control @error('cinema') is-invalid @enderror" required autofocus>
                                  <option>Select location</option>
                                  @foreach($cinemas as $cinema)
                                  <option value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                                  @endforeach
                                </select>
                                @error('cinema')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="film-select-cont" class="form-group row" style="display: none;">
                            <label for="film" class="col-md-4 col-form-label text-md-right">{{ __('Film') }}</label>

                            <div class="col-md-6">
                                <select id="film-select" name="film" class="form-control @error('film') is-invalid @enderror" required autofocus>
                                </select>
                                @error('film')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="timeslot-select-cont" class="form-group row" style="display: none;">
                            <label for="film" class="col-md-4 col-form-label text-md-right">{{ __('Timeslot') }}</label>

                            <div class="col-md-6">
                                <select id="timeslot-select" name="timeslot" class="form-control @error('timeslot') is-invalid @enderror" required autofocus>
                                </select>
                                @error('timeslot')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="ticket-input-cont" class="form-group row" style="display: none;">
                            <label for="ticket" class="col-md-4 col-form-label text-md-right">{{ __('Tickets') }}</label>

                            <div class="col-md-6">
                                <input type="number" id="ticket-input" name="ticket" class="form-control @error('ticket') is-invalid @enderror" min="1" required autofocus>
                                </select>
                                @error('ticket')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="alert-tickets_available" class="alert alert-info lead text-center" style="display: none;"><span id="tickets-available" class="badge bg-primary"></span> {{ __('tickets available') }}</div>
                        
                        <div id="alert-sold_out" class="alert alert-danger lead text-center" style="display: none;">{{ __('Tickets sold out') }}</div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                @if(Auth::user())
                                <button type="submit" class="btn btn-primary" disabled>{{ __('Book tickets') }}</button>
                                @else
                                <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Register now') }}</a>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('bottom')
<script type="text/javascript">
function toggleFormSubmit(form, b){  
  var $form = $(`#${form}`);
  $form.attr('disabled', !!b);
  $form.find('button[type=submit]').attr('disabled', !!b);
}

toggleFormSubmit('booking-form', true);

$(document).ready(function(){

  $('#cinema-select').change(function(){
    var $select,cinema_id,$film_select,$film_select_cont;
    
    $select = $(this);
    cinema_id = parseInt($(this).val());
    $film_select_cont = $('#film-select-cont');
    $('#timeslot-select-cont, #ticket-input-cont, #alert-sold_out, #alert-tickets_available').hide();
    
    if(cinema_id){
      $film_select = $('#film-select');  
      $film_select.html('');
      $select.attr('disabled', true);
      $.ajax({
        url: "{{ route('list.films') }}",
        data: {
          cinema: cinema_id
        },
        success: function(res) {
          var json,html;
          try {
            json = (typeof res == 'object') ? res : JSON.parse(res);
          }
          catch(e){
            json = {};
          }
          if(json.data && Array.isArray(json.data)){
            html = '<option>Select film</option>';
            json.data.forEach(function(row){
              html += `<option value="${row.id}">${row.name} (${row.genre}) ${row.run_time}mins - Rating: (${row.rating})</option>`;
            });
            $film_select.html(html);
            $film_select_cont.show();
          }
        },
        error: function(res) {
          alert('Could not retrieve info. Please try again later.');
          $select.val(null);
        },
        complete: function() {
          $select.attr('disabled', false);
        }
      });
    }
    else {
      $film_select_cont.hide();
    }
  });
  
  $('#film-select').change(function(){
    var $select,cinema_id,film_id,$timeslot_select,$timeslot_select_cont;
    
    $select = $(this);
    cinema_id = parseInt($('#cinema-select').val());
    film_id = parseInt($(this).val());
    $timeslot_select_cont = $('#timeslot-select-cont');
    $timeslot_select = $('#timeslot-select');
    $timeslot_select.html('');
    $('#ticket-input-cont, #alert-sold_out, #alert-tickets_available').hide();
    
    if(cinema_id && film_id){
      $select.attr('disabled', true);
      $.ajax({
        url: "{{ route('list.timeslots') }}",
        data: {
          cinema: cinema_id,
          film: film_id
        },
        success: function(res) {
          var json,html;
          try {
            json = (typeof res == 'object') ? res : JSON.parse(res);
          }
          catch(e){
            json = {};
          }
          if(json.data && Array.isArray(json.data)){
            html = '<option>Select time slot</option>';
            json.data.forEach(function(row){
              html += `<option value="${row.id}">${row.text}</option>`;
            });
            $timeslot_select.html(html);
            $timeslot_select_cont.show();
          }
        },
        error: function(res) {
          alert('Could not retrieve info. Please try again later.');
          $select.val(null);
        },
        complete: function() {
          $select.attr('disabled', false);
        }
      });
    }
    else {
      $timeslot_select_cont.hide();
    }
  });
  
  $('#timeslot-select').change(function(){
    var $select,timeslot_id,$ticket_input,$ticket_input_cont,$alert_sold_out,$tickets_available,$alert_tickets_available;
    
    $select = $(this);
    timeslot_id = parseInt($(this).val());
    $ticket_input_cont = $('#ticket-input-cont');
    $ticket_input = $('#ticket-input');
    $ticket_input.val(1);
    $alert_sold_out = $('#alert-sold_out');
    $alert_sold_out.hide();
    $alert_tickets_available = $('#alert-tickets_available');
    $alert_tickets_available.fadeOut();
    
    if(timeslot_id){  
      $select.attr('disabled', true);
      $.ajax({
        url: "{{ route('available.timeslots') }}",
        data: {
          timeslot: timeslot_id
        },
        success: function(res) {
          var json,html;
          try {
            json = (typeof res == 'object') ? res : JSON.parse(res);
          }
          catch(e){
            json = {};
          }

          if(json.data && json.data > 0){
            @if(Auth::user())
              $ticket_input.attr('max', json.data);
              $ticket_input_cont.show();
            @else
              $('#tickets-available').html(json.data);
              $alert_tickets_available.fadeIn();
            @endif
          }
          else if(json.data === 0){
            $alert_sold_out.show();
          }
        },
        error: function(res) {
          alert('Could not retrieve info. Please try again later.');
          $select.val(null);
        },
        complete: function() {
          toggleFormSubmit('booking-form');
          $select.attr('disabled', false);
        }
      });
    }
    else {
      $ticket_input_cont.hide();
    }
  });

});
</script>
@endpush
