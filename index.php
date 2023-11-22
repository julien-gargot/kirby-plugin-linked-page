<?php

function updatePageRelation($site, $fieldName, $relationId, $currentPage, $action)
{
    $page = $site->page($relationId) ?? $site->draft($relationId);

    if ($page) {
        $collection = $page->$fieldName()->toPages();
        $updatedCollection = $collection->$action($currentPage);

        $updatedValues = array_map(
            fn ($p) => "page://{$p->uuid()->id()}",
            iterator_to_array($updatedCollection)
        );

        try {
            $page->update([
                $fieldName => yaml::encode($updatedValues)
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

Kirby::plugin('julien-gargot/linkedPages', [
  'blueprints' => [
		'fields/linkedPage' => function($kirby) {
			return Data::read(__DIR__ . '/blueprints/fields/linkedPage.yml');
		},
	],
  'hooks' => [
    'page.update:after' => include_once __DIR__ . "/hooks/update.php",
    'page.create:after' => include_once __DIR__ . "/hooks/create.php",
  ],
  'options' => [
    'fieldName' => 'relatedPages',
    'mode' => 'normal', // normal || force
  ]
]);