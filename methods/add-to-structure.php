<?php

$kirby->set('page::method', 'addToStructure', function($page, $field, $data){

  $fieldData = $page->$field()->yaml();
  if ( in_array($data, $fieldData) === FALSE ) {
    $fieldData[] = $data;
    $fieldData = yaml::encode($fieldData);
    try {
      $page->update(array($field => $fieldData));
      return true;
    } catch(Exception $e) {
      return $e->getMessage();
    }
  }

});
