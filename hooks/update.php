<?php

return function (Kirby\Cms\Page $newPage, Kirby\Cms\Page $oldPage) {
    $site = $this->site();
    $mode = option('julien-gargot.linkedPages.mode');
    $fieldName = option('julien-gargot.linkedPages.fieldName');

    $oldCollection = $oldPage->$fieldName()->toPages()->keys();
    $newCollection = $newPage->$fieldName()->toPages()->keys();

    switch ($mode) {
        case "normal":
            $removed = array_diff($oldCollection, $newCollection);
            $added = array_diff($newCollection, $oldCollection);

            foreach ($removed as $oldRelation) {
                updatePageRelation($site, $fieldName, $oldRelation, $newPage, 'remove');
            }

            foreach ($added as $newRelation) {
                updatePageRelation($site, $fieldName, $newRelation, $newPage, 'add');
            }
            break;
        case "force":
            foreach ($oldCollection as $oldRelation) {
                updatePageRelation($site, $fieldName, $oldRelation, $newPage, 'remove');
            }

            foreach ($newCollection as $newRelation) {
                updatePageRelation($site, $fieldName, $newRelation, $newPage, 'add');
            }
            break;
    }
};
