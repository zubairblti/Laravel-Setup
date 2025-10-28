@extends('master')
@section('content')
<div class="container height-100 d-flex justify-content-center align-items-center">
  <div class="position-relative">
    <div class="card p-2 text-center">
      <h6>Please enter the one time password <br> to verify your account </h6>
      <div>
        <span>A code has been sent to</span>
        <small>{{ request()->email }}</small>
      </div>
      <form action="{{ route('verify.otp.submit') }}" method="POST" class="mt-4">
      @csrf
      <input type="hidden" name="email" value="{{ request()->email }}">
      <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
        <input class="m-2 text-center form-control rounded" type="text" name="otp[]" id="first" maxlength="1" />
        <input class="m-2 text-center form-control rounded" type="text" name="otp[]" id="second" maxlength="1" />
        <input class="m-2 text-center form-control rounded" type="text" name="otp[]" id="third" maxlength="1" />
        <input class="m-2 text-center form-control rounded" type="text" name="otp[]" id="fourth" maxlength="1" />
        <input class="m-2 text-center form-control rounded" type="text" name="otp[]" id="fifth" maxlength="1" />
        <input class="m-2 text-center form-control rounded" type="text" name="otp[]" id="sixth" maxlength="1" />
      </div>
       @error('otp')
        <small class="text-danger d-block mt-2">{{ $message }}</small>
      @enderror
      <div class="mt-4">
        <button type="submit" class="btn btn-danger px-4 validate">Validate</button>
      </div>
      </form>
    </div>
    <div class="card-2">
      <div class="content d-flex justify-content-center align-items-center">
        <span>Didn't get the code</span>
        <a href="#" class="text-decoration-none ms-3">Resend(1/3)</a>
      </div>
    </div>
  </div>
</div>
@endsection
@push('style')
   <link rel="stylesheet" href="{{ asset('assets/css/email-verification.css') }}">
@endpush
@push('script')
   <script src="{{ asset('assets/js/email-verification.js') }}"></script>
@endpush