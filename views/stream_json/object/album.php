<?php
/**
 * The AS JSON view for an image album
 *
 * @uses $vars['entity'] The album entity
 */

$album = elgg_extract('entity', $vars);

// the object view has its own logic for icons
$ci = $album->getCoverImageGUID();
if ($ci) {
	$ci_entity = get_entity($ci);
	$cover_image_ml = elgg_view_entity_icon($ci_entity);
}


$obj_vars = array(
	'display_name' => $album->getTitle(),
	'image' => $cover_image_ml,
	'published' => ActivityStreams::formatDate($album->time_created),
	'summary' => $album->description,
	'updated' => ActivityStreams::formatDate($album->time_updated),
	'url' => $album->getURL()
);

echo elgg_view('activity_streams/object/collection', $obj_vars);