<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TransitionsTax extends Controller
{
    use Partials\Hero;
    use Partials\Transitions;

    function data()
    {
      return self::getRandomTransitions();
    }

    function filters()
    {
      $items = get_field('filters', false, false);

      if($items) {
        return array_map(function($tax) {
          return array(
            'name' => $tax,
            'items' => self::getTax($tax)
          );
        }, $items);
      }

      return null;
    }

    function filterLabel() {
      return get_field('label');
    }
}