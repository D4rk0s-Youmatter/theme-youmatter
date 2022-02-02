<form role="search" class="form" method="get" action="{{ esc_url(home_url('/')) }}"
  autocomplete="off">
  <label class="screen-reader-text"
    for="search-input">{{ pll__('Search for:') }}</label>
  <input type="search" class="form__field" autocomplete="off" id="search-input"
    placeholder="{{ pll__('Your search term') }}"
    value="{!! get_search_query() !!}" name="s" />
  <button type="submit" class="form__search">
    <span class="screen-reader-text">{!! pll__('Search') !!}</span>
  </button>
</form>
