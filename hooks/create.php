<?php

return function (Kirby\Cms\Page $page,) {
    $site = $this->site();
    $fieldName = option('julien-gargot.linkedPages.fieldName');
    
    $newCollection = $page->$fieldName()->toPages()->keys();

    foreach ($newCollection as $newRelation) {
      updatePageRelation($site, $fieldName, $newRelation, $page, 'add');
    }
};