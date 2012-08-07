<?php
/**
 * Valid Verbs
 * @see http://activitystrea.ms/head/activity-schema.html#verbs
 *
 *	add
	cancel
	checkin
	delete
	favorite
	follow
	give
	ignore
	invite
	join
	leave
	like
	make-friend
	play
	receive
	remove
	remove-friend
	request-friend
	rsvp-maybe
	rsvp-no
	rsvp-yes
	save
	share
	stop-following
	tag
	unfavorite
	unlike
	unsave
	update
 *
 */
$en = array(
	'activity_streams:verb:create' => 'post',
	'activity_streams:verb:comment' => 'post',
	'activity_streams:verb:friend' => 'make-friend',
);

add_translation('en', $en);