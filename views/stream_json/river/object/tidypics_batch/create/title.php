<?php
/**
 * Title view for TP batch items
 */

$batch = $vars['item']->getObjectEntity();

// Get images related to this batch
$images = elgg_get_entities_from_relationship(array(
	'relationship' => 'belongs_to_batch',
	'relationship_guid' => $batch->getGUID(),
	'inverse_relationship' => true,
	'type' => 'object',
	'subtype' => 'image',
	'offset' => 0,
));

$album = $batch->getContainerEntity();
$album_link = elgg_view('output/url', array(
	'href' => $album->getURL(),
	'text' => $album->getTitle(),
	'is_trusted' => true,
));

$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

if (count($images)) {
	$attachments = '<ul class="tidypics-river-list">';
	foreach($images as $image) {
		$attachments .= '<li class="tidypics-photo-item">';
		$attachments .= elgg_view_entity_icon($image, 'tiny');
		$attachments .= '</li>';
	}
	$attachments .= '</ul>';
}

if (count($images) == 1) {
	$summary = elgg_echo('image:river:created', array($subject_link, $album_link));
} else {
	$summary = elgg_echo('image:river:created:multiple', array($subject_link, count($images), $album_link));
}

echo $summary;
