<?php
/**
 * The base class for an activity stream JSON object
 *
 * @uses AS/collection    $vars['attachments']           JSON-encoded array of other AS objects.
 * @uses AS/Object/Person $vars['author']                An AS 'person' json object idenfitying the creator of the object.
 * @uses string           $vars['content']               Natural langauge. HTML ok.
 * @uses string           $vars['display_name']          Natural language name of the object. No HTML.
 * @uses array            $vars['downstream_duplicates'] JSON-encoded array of IRIs that duplicate this object's content.
 * @uses string           $vars['id']                    The absolute, permanent IRI of the object.
 * @uses AS/media_link    $vars['image']                 A visual representation of the object
 * @uses string           $vars['type']                  A valid AS object type.
 * @uses string           $vars['published']             The RFC3339 date-time when the object was published.
 * @uses string           $vars['summary']               Natural language summary of the object. HTML ok.
 * @uses string           $vars['updated']               The RFC3339 date-time when the object was updated.
 * @uses array            $vars['upstream_duplicates']   JSON-encoded array of IRIs whose content this object duplicates.
 * @uses string           $vars['url']                   An IRI to the HTML representation of the object. Can be non-unique.
 */

$map = array(
	'attachments',
	'author',
	'content',
	'display_name' => 'displayName',
	'downstream_duplicates' => 'downstreamDuplicates',
	'id',
	'image',
	'type',
	'published',
	'summary',
	'updated',
	'upstream_duplicates' => 'upstreamDuplicates',
	'url'
);

$object = activity_streams_build_array($map, $vars);

echo activity_streams_json_encode($object, false);