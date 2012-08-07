<?php
/**
 * The basis for an AS JSON document.
 *
 * @see http://activitystrea.ms/specs/json/1.0/#collection
 *
 * Mandatory
 * @uses AS/collection $vars['items'] JSON-encoded array of items
 *
 * Optional
 * @uses int    $vars['total_items']    The total number of items in the list
 * @uses string $vars['collection_url'] IRI to a JSON document of the full collection. NOTE THE NAME.
 */

$map = array(
	'items' => 'items',
	'total_items' => 'totalItems',
	'collection_url' => 'url'
);

$collection = activity_streams_build_array($map, $vars);
$collection['type'] = 'collection';

echo activity_streams_json_encode($collection, false);
echo elgg_view('activity_streams/elements/base', $vars);