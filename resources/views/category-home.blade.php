{{--
  Template used for category info page
  Category controller is used here
--}}

@extends('layouts.app')

@section('content')
@include('partials.hero')
@if($latest_articles)
<section class="wrapper wrapper--bg row--grid-column">
  <div class="row--grid-row">
    @foreach ($latest_articles as $article)
    @include('partials.card', App::getCardDetails($article, 'minimal', false))
    @endforeach
  </div>
  <a href="{{ Category::articlesUrl() }}" class="btn btn--blue_dark col--center-main">{{ pll__('Read all articles') }}</a>
</section>
@endif
@if(isset($why_matter) && $why_matter->display)
<section class="matters" data-control="expandable">
  <h2 class="title title--bold title--highlight">{!! $why_matter->title !!}</h2>
  <div class="matters__text js-expandable">{!! $why_matter->text !!}</div>
  <button class="matters__button js-expand open">{{ pll__('Load more') }}</button>
  @if($why_matter->video_id)
  @include('partials.video',
  [
  'video_id' => $why_matter->video_id
  ]
  )
  @endif
</section>
@endif
@if(isset($how_matters) && $how_matters->display)
<section class="matters matters--alt" data-control="expandable" data-limit="3">
  <header>
    <h2 class="title title--white title--spacer">{!! $how_matters->title !!}</h2>
    <div class="matters__text open">{!! $how_matters->text !!}</div>
  </header>
  @include('partials.likes', ['layout' => 'light'])
  @if($how_matters->block)
  @foreach($how_matters->block as $block)
  <section class="matters__column">
    <h3 class="title">{!! $block->title !!}</h3>
    @foreach(Category::getRandomArticles($block->articles, 3) as $article)
    @include('partials.card', App::getCardDetails($article, 'minimal', true))
    @endforeach
  </section>
  @endforeach
  @endif
  <button class="matters__button js-expand open">{{ pll__('Load more') }}</button>
</section>
@endif
@if(isset($questions) && $questions->display)
<section class="matters matters--faq" data-control="expandable" data-limit="3">
  <header class="matters__header">
    <h2 class="title title--highlight title--spacer">{!! $questions->title !!}</h2>
    <div class="matters__text open">{!! $questions->text !!}</div>
  </header>
  @foreach(Category::getRandomArticlesFaq($questions->articles, 3) as $article)
  @include('partials.card', App::getCardDetails($article, 'classique', false))
  @endforeach
  <button class="matters__button js-expand open">{{ pll__('Load more') }}</button>
</section>
@endif
@include('partials.sponsored', ['column' => false])
@include('partials.matters-most', [
  'layout' => 'light'
])
@if(isset($take_action) && $take_action->display)
<section class="matters matters--action" data-control="expandable" data-limit="3">
  <header class="matters__header">
    <h2 class="title title--white title--spacer">{!! $take_action->title !!}</h2>
  </header>
  @foreach($latest_articles_action as $key => $article)
  @include('partials.card', App::getCardDetails($article, $key > 0 ? 'classique' : 'large', false))
  @endforeach
  <button class="matters__button js-expand open">{{ pll__('Load more') }}</button>
</section>
@endif
@include('partials.action', [
  'title' => true,
  'sections' => ['likes', 'manifesto', 'articles', 'newsletter']
])
<!-- @include('partials.follow') -->
@include('partials.discover', [
'title' => true,
'items' => $discover_items,
'layout' => 'large'
])
@endsection
