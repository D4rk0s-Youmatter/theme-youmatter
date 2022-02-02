<?php 
    // @greg ici je patche temporairement les datas pour permettre une MAJ manuelle 
    // le temps que tu puisses checker pourquoi le plugin analytics fait des siennes
    $meta = get_post_meta($post->ID);

    if(isset($meta["data_section_manual_data"][0])) {
        $pageviews['current'] = $meta["data_section_this_year"][0] ? $meta["data_section_this_year"][0] : "";
        $pageviews['previous'] = $meta["data_section_last_year"][0] ? $meta["data_section_last_year"][0] : "";
        $pageviews['difference'] = $meta["data_section_since_last_year"][0] ? $meta["data_section_since_last_year"][0] : "";
        //var_dump($meta);
    } else {
        $pageviews = App::pageviews();
    }
?>

<section class="home--stats">
  <div class="wrapper row home--stats_row">
    <div class="home--stats_figures" data-control="FIGURES">
      <ul class="home--stats_figures_values row">
        <li class="home--stats_figures_values-list">
          <div class="home--stats_figures_values-list-data">{{ $pageviews['current'] }}</div>
          <span class="home--stats_figures_values-list-data-description">{{ pll__('this month', 'youmatter') }}</span>
        </li>
        <li class="home--stats_figures_values-list">
          <div class="home--stats_figures_values-list-data">{{ $pageviews['previous'] }}</div>
          <span class="home--stats_figures_values-list-data-description">{{ pll__('last month', 'youmatter') }}</span>
        </li>
        <li class="home--stats_figures_values-list">
          <div class="home--stats_figures_values-list-data">{{ $pageviews['operator'] }} {{ $pageviews['difference'] }} %</div>
          <span class="home--stats_figures_values-list-data-description">{{ pll__('since last month', 'youmatter') }}</span>
        </li>
      </ul>
    </div>
    <div class="home--stats_text">
      <h2>{!! $data_section_title !!}</h2>
    </div>
  </div>
</section>