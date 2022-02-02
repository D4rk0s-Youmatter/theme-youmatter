<section class="jobs__contact">
  <div class="wrapper">
    <h2 class="jobs__contact__title">
      {!! $contacts_title !!}
      <span>
          {!! $contacts_subtitle !!}
      </span>
    </h2>
    <a href="{{ $contacts_link }}?opt={{$contacts_dropdown_order?$contacts_dropdown_order:0}}" class="btn btn--blue_dark jobs__contact__button">{{ $contacts_link_label }}</a>
  </div>
</section>