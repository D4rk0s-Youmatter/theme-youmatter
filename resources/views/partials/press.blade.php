<div class="wrapper wrapper--bg wrapper--spacer row--grid-column" data-control="newsroom">
  <h2 class="title title--center">{!! pll__("What's new", 'youmatter') !!}
    <span>{{ pll__('with us', 'youmatter') }}</span>
  </h2>
  <form class="form form--alt form--alt-single js-form" novalidate>
    <div class="form__row">
      <select
        class="form__hidden js-choice-category"
        name="taxonomy[]"
        multiple
        placeholder="{!! pll__('Select one', 'youmatter') !!}"
        data-empty="{!! pll__('No items found', 'youmatter') !!}"
      >
      @foreach(TemplateNewsroom::getCategories() as $cat)
        <option value="{{ $cat->term_id }}">{{ $cat->name }}</option>
      @endforeach
      </select>
    </div>
    <input type="hidden" name="taxonomy" value="{{ TemplateNewsroom::taxonomy() }}" />
  </form>

  @if(count(TemplateNewsroom::getPress()) > 0)
    <section class="row--grid-three row--grid-large js-list">
      @php $i = 1; @endphp
      @php global $post; @endphp
      @foreach(TemplateNewsroom::getPress() as $article)
        @include('partials.card', App::getCardDetails($article, $i > 1 ? 'classique' : 'large', false))
        @php $i++; @endphp
      @endforeach
    </section>
    @if(TemplateNewsroom::getPageCount() > TemplateNewsroom::getCurrentPage())
    <button
      class="col--center-main btn btn--border btn--highlight-color js-more">{{ pll__('Load more', 'youmatter') }}</button>
    @endif
    @else
    <span
      class="title--small js-label">{{ pll__('No articles were found.', 'youmatter') }}</span>
    @endif
</div>
