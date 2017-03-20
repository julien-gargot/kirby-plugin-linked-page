<?php
/**
 * Kirby Linked Pages Plugin
 *
 * @version   0.0.1
 * @author    Julien Gargot <julien@g-u-i.me>
 * @copyright Julien Gargot <julien@g-u-i.me>
 * @link      https://github.com/julien-gargot/kirby-plugin-linked-pages
 * @license   CC BY-SA
 */

// Blueprints
$kirby->set('blueprint', 'fields/linkedPage', __DIR__ . '/blueprints/fields/linkedPage.yml');

// Methods
require_once __DIR__.DS.'methods'.DS.'add-to-structure.php';
require_once __DIR__.DS.'methods'.DS.'remove-from-structure.php';
require_once __DIR__.DS.'methods'.DS.'structure-to-json.php';

// Hooks
require_once __DIR__.DS.'hooks'.DS.'update.php';

// Helpers
// function debug_hook($data) {
//   $file = kirby()->roots()->index() . DS . 'panel.page.update.txt';
//   // $content = yaml::encode($data) . "\n";
//   $content = print_r($data, true);
//   $content .= "\n";
//   f::write($file, $content, true);
// }
