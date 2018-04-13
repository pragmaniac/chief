@extends('back._layouts.master')

@section('title')
  Login
@endsection

@section('content')
  <div class="login-wrapper">
    <div class="login-block">
      <h1>Inloggen</h1>

      <form class="form" id="valid" role="form" method="POST" action="{{ route('login.store') }}">
        {{ csrf_field() }}
        <div class="form-wrapper">
          @if($errors and count($errors) > 0)
            <div class="message error squished">
              @foreach($errors->all() as $error)
                <span class="lnr lnr-warning lnr-margin"></span>{{ $error }}<br>
              @endforeach
            </div>
          @endif
          <div class="squished">
            <div class="input-group-prefix relative">
              <span class="input-prefix"><span class="lnr lnr-user"></span></span>
              <input type="email" class="validate[required]" name="email" placeholder="E-mail" id="identity" value="{{ old('email') }}" autofocus>
            </div>
          </div>
          <div class="squished">
            <div class="input-group-prefix relative">
              <span class="input-prefix"><span class="lnr lnr-lock"></span></span>
              <input type="password" class="validate[required]" name="password" placeholder="Wachtwoord" id="password">
            </div>
          </div>
          <div class="squished">
            <label for="rememberCheckbox" class="remember">
              <input id="rememberCheckbox" {{ old('remember') ? 'checked=checked':null  }} type="checkbox" name="remember">
              Hou me ingelogd
            </label>
          </div>
        </div>

        <div class="squished">
          <button type="submit" class="btn btn-block submitForm">Inloggen</button>
        </div>
        <div class="squished">
          <div class="message"><a href="{{ route('password.request') }}">Wachtwoord vergeten?</a></div>
        </div>
      </form>

    </div>
  </div>
@stop
