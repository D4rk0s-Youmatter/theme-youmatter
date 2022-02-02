{{--
  Template Name: Account Template
--}}

@extends('layouts.app')

@section('content')
  

  <div class="wrapper wrapper--bg wrapper--spacer row--grid-column">
    <h1 class="title title--spacer">{!! pll__('My account', 'youmatter') !!}</h1>
    @if(App::canInteract())
    <div class="row--grid-two">
      <div data-control="profile" data-id="{!! $user['ID'] !!}">
        <h2 class="title--medium title--spacer">{!! pll__('Personal data', 'youmatter') !!}</h2>
        <form class="row--grid-column">
          <div>
            <label for="first_name_input">{{ pll__('First Name', 'youmatter') }}:</label>
            <input type="text" class="form__field" id="first_name_input" value="{{$user['first_name']}}" name="first_name_input" required />
          </div>
          <div>
            <label for="last_name_input">{{ pll__('Last name', 'youmatter') }}:</label>
            <input type="text" class="form__field" id="last_name_input" value="{{$user['last_name']}}" name="last_name_input" required />
          </div>
          <div>
            <label for="description_input">{{ pll__('Description', 'youmatter') }}:</label>
            <textarea type="text" class="form__field" id="description_input" name="description_input" required>
              {{$user['description']}}
            </textarea>
          </div>
          <div class="form__control">
            <input type="checkbox" id="acceptance" value="true" name="acceptance" @if( $user['acceptance']){ checked } @endif required />
            <label for="acceptance">{!! pll__('I accept the term and conditions', 'youmatter') !!}</label>
          </div>
          <div class="form__control">
            <p><a class="title--small title--highlight" href="{{App::options()['terms_and_conditions_link']}}" target="_blank">{!! pll__('Read here our terms and conditions','youmatter') !!}</a></p>
          </div>
          <div>
            {{do_action('oa_social_link')}}
          </div>
          <button type="submit" class="form__submit">
            {!! pll__('Submit', 'youmatter') !!}
          </button>
        </form>
        <p class="update-profile-message hidden"></p>
      </div>
      <div data-control="changePass" data-id="{!! $user['ID'] !!}">
        <h2 class="title--medium title--spacer">{!! pll__('Change password', 'youmatter') !!}</h2>
        <form class="row--grid-column">
          <div>
            <label for="password_input">{{ pll__('Password', 'youmatter') }}:</label>
            <input type="password" class="form__field" id="password_input" value="" name="password_input" required />
          </div>
          <div>
            <label for="confirm_password_input">{{ pll__('Last name', 'youmatter') }}:</label>
            <input type="password" class="form__field" id="confirm_password_input" value="" name="confirm_password_input" required />
          </div>
          <button type="submit" class="form__submit">
            {!! pll__('Submit', 'youmatter') !!}
          </button>
        </form>
        <p class="change-password-message hidden"></p>
      </div>
    </div>
    @else
      <p>{!! pll__('You are not logged in', 'youmatter') !!}</p>
    @endif
  </div>
@endsection
