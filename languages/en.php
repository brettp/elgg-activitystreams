<?php
/**
 * Valid Verbs
 * @see http://activitystrea.ms/specs/json/schema/activity-schema.html#verbs
 */
$en = array(
	'activity_streams:verb:create' => 'post',
	'activity_streams:verb:comment' => 'post',

	// we use follow model here.
	'activity_streams:verb:friend' => 'follow',
);

add_translation('en', $en);