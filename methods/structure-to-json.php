<?php

$kirby->set('field::method', 'structureToJson', function($field){

  $array = array();
  foreach ($field->toStructure() as $item):
    $array[] = str::slug($item->related()->value());
  endforeach;

  return htmlentities(a::json($array), ENT_QUOTES, 'UTF-8');

});
