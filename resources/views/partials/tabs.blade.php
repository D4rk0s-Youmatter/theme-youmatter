<section class="tabs" data-control="tabs" data-authors="{!!$authors!!}" data-tab="{{$organization_tab}}" data-commit="{{$organization_commitment}}">
  <nav class="tabs__nav">
    @php $k = 0; @endphp
    @foreach($tabs as $tab)
      <a href="?tab={{$tab['url']}}" data-url="{{$tab['url']}}" class="js-tab {{$tab['class']}} @if($k===0) active @endif">{{$tab['title']}}</a>
      @php $k++; @endphp
    @endforeach
  </nav>
  <div class="tabs__content">
    <div class="tabs__content__wrap">
      <section class="tab__content">
        <article class="article__content">
          <h2 class="tab__title">{{ pll_e('About', 'youmatter') }} {!!$post->post_title!!}</h2>
          @php the_content() @endphp
        </article>
        <footer class="article__footer article__footer--organizations">
          <h3>{{pll__('Facts && Figures')}}</h3>
          <p>{{pll__('Sector')}}:</p>
          <p>{{$organisation_sector}}</p>
          <p><a href="{!!$association_site_web!!}" target="blank">{{pll__('Site web')}}: {!!$association_site_web!!}</a></p>
          <p>{{pll__('Creation Year')}}: {!!$association_date_de_creation!!}</p>
          <p>{{pll__('Employees')}}: {!!$association_employes!!}</p>
          <p>{{pll__('Head Office')}}: {!!$association_siege_social!!}</p>
          <p>{{pll__('Revenues')}}: {!!$association_ca!!}</p>
        </footer>
      </section>
      <section class="tab__content hidden">
        <nav class="sidenav sidenav__commits">
          @php $k = 0; @endphp
          @foreach(Single::getCommitments() as $commit)
            <a href="?tab={{$tabs[1]['url']}}&commitment={{$commit['nav']}}" data-url="{{$commit['nav']}}" class="sidenav__item @if($k===0) active @endif">{!!$commit['title']!!}</a>
            @php $k++; @endphp
          @endforeach
        </nav>
        @php $k = 0; @endphp
        @foreach(Single::getCommitments() as $commit)
          @if(strlen($commit['content']) > 0)
            <article class="article__content @if($k!==0) hidden @endif">
              <h2 class="tab__title ">{!!$commit['title']!!}</h2>
              {!!$commit['content']!!}
              @php $k++; @endphp
            </article>
          @endif
        @endforeach
      </section>

      <section class="tab__content hidden">
        <article class="article__content">
          @if(isset($user_intro))
            {!! $user_intro !!}
          @endif
          <div class="article__content__contributors">
            @foreach($organisation_users as $contributor)
              @include('partials.contributor')  
            @endforeach
          </div>
        </article>
      </section>

      <section class="tab__content hidden">
        <article class="article__content">
          @if ($news)
            <div class="row--grid-three row--grid-large js-list">
              @php $i = 1; @endphp
              @php global $post; @endphp
              
              
                @foreach ($news->posts as $post) 
                  @php setup_postdata($post) @endphp
                  @include('partials.card', App::getCardDetails($post, $i > 1 ? 'classique' : 'large', false))
                  @php $i++; @endphp
                @endforeach
                @php wp_reset_postdata(); @endphp
              
              
            </div>
            @if($news->query_vars['paged'] < $news->max_num_pages)
              <button
                class="col--center-main btn btn--border btn--highlight-color js-more">{{ pll__('Load more', 'youmatter') }}</button>
              @endif
          @endif
        </article>
      </section>

      <section class="tab__content hidden">
        <nav class="sidenav sidenav__faqs">
          @php $k = 0; @endphp
          @if(!empty($faqs))
            @foreach($faqs as $faq)
              @if(strlen($faq['content']) > 0)
                <a href="#" class="sidenav__item @if($k===0) active @endif" data-cat="{{implode(',',$faq['category'])}}">{!!$faq['question']!!}</a>
              @endif
              @php $k++; @endphp
            @endforeach
          @endif
        </nav>
        <div>
          <form class="form form--alt" novalidate>
            <div class="form__row">
              <label class="screen-reader-text">
                {{ pll__('I am interested in', 'youmatter') }}
              </label>
              <select
                class="form__hidden js-faq"
                name="faq_categories"
                placeholder="{!! sprintf(pll__('Select a %s'), pll__('faq category','youmatter')) !!}"
                data-empty="{!! pll__('No items found') !!}"
              >
                <option value="-1">{{pll__('Choose a category', 'youmatter')}}</option>
                @if(!empty($faq_categories))
                  @foreach($faq_categories as $cat => $value)
                    <option value="{!!$cat!!}">{!!$value!!}</option>
                  @endforeach 
                @endif
              </select>
            </div>
          </form>
          @php $k = 0; @endphp
          @if(!empty($faqs))
            @foreach($faqs as $faq)
              @if(strlen($faq['content']) > 0)
                <article class="article__content @if($k!==0) hidden @endif" data-cat="{{implode(',',$faq['category'])}}">
                  {!!$faq['content']!!}
                  @php $k++; @endphp
                </article>
              @endif
            @endforeach
          @endif
        </div>
      </section>
      
    </div>
  </div>
</section>