<?php
/**
 * An activity stream Person object type.
 *
 * @uses ElggUser $vars['entity'] If this is set, the relevant info is extracted
 *
 * Mandatory - See AS/objects/elements/base for descriptions.
 * @uses string        $vars['display_name']
 * @uses AS/media_link $vars['image']
 * @uses string        $vars['id']
 * @uses string        $vars['url']
 *
 * Optional-ish (The spec in one place says these are required, then below that says they're optional)
 * @uses string        $vars['published']
 * @uses string        $vars['updated']
 *
 * All other valid AS/Object attributes are accepted as optional attributes.
 */

$map = array(
	'display_name' => 'displayName',
	'image',
	'id',
	'url',
	'published',
	'updated'
);

unset($vars['url']);
extract($vars);

if ($entity instanceof ElggUser) {
	if (!$display_name) {
		$vars['display_name'] = $entity->name;
	}

	if (!$image) {
		$vars['image'] = elgg_view_entity_icon($entity);
	}

	if (!$id) {
		$vars['id'] = $entity->getURL();
	}

	if (!$url) {
		$vars['url'] = $entity->getURL();
	}

	if (!$published) {
		$vars['published'] = ActivityStreams::formatDate($entity->time_created);
	}

	if (!$updated) {
		$vars['updated'] = ActivityStreams::formatDate($entity->time_updated);
	}
}
$vars['type'] = 'person';

echo elgg_view('activity_streams/object/elements/base', $vars);