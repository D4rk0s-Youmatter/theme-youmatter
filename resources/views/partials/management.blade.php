<section class="management">
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <h2 class="management__title">{!! $management_section_title !!}</h2>
        <div class="management__content">{!! $management_section_content !!}</div>
      </div>
      <div class="col-xs-12 col-md-6 management__image">
        @php echo wp_get_attachment_image( $management_section_image, 'large' ) @endphp
      </div>
    </div>
  </div>
</section>

<section class="jobs__contact">
  <div class="wrapper">
    <h2 class="jobs__contact__title">
      {!! $contact_title !!}
      <span>
          {!! $contact_subtitle !!}
      </span>
    </h2>
    <a href="{{ $contact_link }}?opt={{$contacts_dropdown_order?$contacts_dropdown_order:0}}" class="btn btn--blue_dark jobs__contact__button">{{ $contact_link_label }}</a>
  </div>
</section>