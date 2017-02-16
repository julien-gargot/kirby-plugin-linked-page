<?php

$kirby->set('hook', ['panel.page.create', 'panel.page.update'], function($page, $oldPage = null) {

  $site = $this->site();

  switch ( c::get('linked.pages.field') ) {

    case 'use.convention':
      $relatedField = 'related' . $page->intendedTemplate() . 's';
      break;

    default:
      $relatedField = c::get('linked.pages.field', 'relatedPages');
      break;

  }

  /* Look for realations trough page fields
   * NB: refere to README.md for more informations
   */
  foreach ($page->content()->toArray() as $key => $value) {

    if ( preg_match('/related\w+/', $key, $matchedField) ) {

      $field = $matchedField[0];
      $collection = $page->$field()->toStructure();
      if ($oldPage) {
        $oldCollection = $oldPage->$field()->toStructure();
      }

      // Look for relation(s) to remove.
      foreach ($oldCollection as $item) {
        $result = $collection->filterBy('related', 'in', $item->related()->value() );
        if( !$result->count() && $linkedPage = $site->page( $item->related()->value() ) ) {
          // Remove relation:
          // For each relation, try to update the linked page.
          $linkedPage->removeFromStructure($relatedField, array(
            "related" => $page->uri()
          ));
        }
      }

      // Look for relation(s) to add.
      foreach ($collection as $item) {

        if ( c::get('linked.pages.mode','normal') == 'normal' ) {
          $result = $oldCollection->filterBy('related', 'in', $item->related()->value() );
          $extraCondition = !$result->count();
        } if ( c::get('linked.pages.mode') == 'force.creation' ) {
          $extraCondition = true;
        }

        if( $extraCondition && $linkedPage = $site->page( $item->related()->value() ) ) {
          // Add relation:
          // For each relation, try to update the linked page.
          $linkedPage->addToStructure($relatedField, array(
            "related" => $page->uri()
          ));
        }
      }

    }
  }

});
