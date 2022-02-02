<section class="newsletter newsletter--{{ $layout }}">
  <h5 class="newsletter__title">{!! pll__('Interested by<br/> this theme?', 'youmatter') !!}</h5>
  <p class="newsletter__subtitle">{!! pll__('Subscribe to our newsletter to receive the latest news about that matter!', 'youmatter') !!}</p>
  <form class="form form--newsletter" data-control="newsletter" data-invalid="{{ pll__('Please fill in this field', 'youmatter') }}">
    <div class="form__row">
      @foreach(App::newsletterCategories() as $key => $category)
      <div class="form__control">
        <input type="checkbox" id="category-{{ $key }}" value={{ $category['name'] }} name="CATEGORY" required />
        <label for="category-{{ $key }}">
          <img src="{!! $category['icon'] !!}" alt="" class="form__icon" /> {{--  TODO USE SVG --}}
          {{ $category['name'] }}
        </label>
      </div>
      @endforeach
    </div>
    <label for="contact-email" class="screen-reader-text">{{ pll__('Email', 'youmatter') }}</label>
    <input id="contact-email" name="EMAIL" placeholder="{{ pll__('your email', 'youmatter') }}" class="form__field form__field--large" required type="email" />
    <button type="submit" class="form__submit">{{ pll__('Subscribe', 'youmatter') }}</button>
  </form>
</section>
