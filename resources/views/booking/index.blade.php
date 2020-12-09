@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
      <h2>{{ __('Bookings') }}</h2>
    </div>
    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">{{ __('Code') }}</th>
        <th scope="col">{{ __('Tickets') }}</th>
        <th scope="col">{{ __('Cinema') }}</th>
        <th scope="col">{{ __('Film') }}</th>
        <th scope="col">{{ __('Timeslot') }}</th>
        <th scope="col">{{ __('Actions') }}</th>
      </tr>
    </thead>
    <tbody>
      @forelse($bookings as $booking)
      <tr>
        <td>{{ $booking->hash }}</td>
        <td class="text-center">{{ $booking->ticket_count }}</td>
        <td>{{ $booking->cinema->name }}</td>
        <td>{{ $booking->film->name }}</td>
        <td>{{ $booking->timeslot->text }}</td>
        <td>
          @if($booking->timeslot->cancelable())
          <button type="button" class="btn btn-danger booking-delete" data-id="{{ $booking->id }}">{{ __('Cancel booking') }}</button>
          @else
          <div class="btn btn-danger disabled" title="{{ __('Unable to cancel booking') }}">{{ __('Cancel booking') }}</div>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6">{{ __('No bookings found') }}</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection

@push('bottom')
<script type="text/javascript">
$(document).ready(function(){

  $('.booking-delete').click(function(){
    var id = parseInt($(this).data('id'));
    if(id && confirm("{{ __('Are you sure you want to cancel this booking?') }}")){
      console.log(id);
      window.location.href = `{{ route('booking.cancel') }}?booking=${id}`;
    }
  });

});
</script>
@endpush
