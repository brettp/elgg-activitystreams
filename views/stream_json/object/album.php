<?php
/**
 * The AS JSON view for an image album
 *
 * @todo There is nothing that matches this in the AS spec so I'm using a generic object.
 * It could also probably be a collection, but that'd be slow.
 *
 * @uses $vars['entity'] The album entity
 */

$album = elgg_extract('entity', $vars);

// elgg_view_entity() doesn't support specifying viewtype.
$vt = elgg_get_viewtype();
elgg_set_viewtype('default');
$content = elgg_view_entity($album);
elgg_set_viewtype($vt);

$cover_image_ml = elgg_view_entity_icon($album);

$vars = array(
	'author' => $author,
	'content' => $content,
	'display_name' => $album->getTitle(),
	'image' => $cover_image_ml,
	'published' => ActivityStreams::formatDate($album->time_created),
	'summary' => $album->description,
	'updated' => ActivityStreams::formatDate($album->time_updated),
	'url' => $album->getURL()
);

echo elgg_view('activity_streams/object/elements/base', $obj_vars);