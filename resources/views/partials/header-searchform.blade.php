<div class="form-banner">@include('partials.svg.header-search')
<form role="search" class="header__form" method="get" action="{{ esc_url(home_url('/')) }}"
  autocomplete="off">
  <label class="screen-reader-text"
    for="search-input">{{ pll__('Search for:') }}</label>
  <input type="search" class="header__form__field" autocomplete="off" id="search-input"
    placeholder="{{ pll__('Look for an article, theme...') }}"
    value="{!! get_search_query() !!}" name="s" />
</form>
</div> <!-- .form-banner -->