<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body
    @php body_class(App::themeColor()) @endphp
    data-lang="{{ App::currentLanguage() }}"
  >
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div class="wrap container" role="document">
      <div class="content">
        <main class="main">
          @yield('content')
        </main>
        @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
      </div>
    </div>
    <div class="popins" data-control="lightbox">
      @include ('partials.popin-login')
      @include ('partials.popin-login-email')
      @include ('partials.popin-reset-pass')
      @include ('partials.popin-register')
      @include ('partials.popin-locked')
      @if(App::displayShare())
      @include ('partials.popin-share')
      @endif
    </div>
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
  </body>
</html>
