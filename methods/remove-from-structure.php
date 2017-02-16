<?php

$kirby->set('page::method', 'removeFromStructure', function($page, $field, $data){

  $fieldData = $page->$field()->yaml();
  foreach (array_keys($fieldData, $data) as $key) {
    unset($fieldData[$key]);
  }
  $fieldData = yaml::encode($fieldData);
  try {
    $page->update(array($field => $fieldData));
    return true;
  } catch(Exception $e) {
    return $e->getMessage();
  }

});
