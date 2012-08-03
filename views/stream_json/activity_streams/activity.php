<?php
/**
 * An AS activity entry
 *
 * @see http://activitystrea.ms/specs/json/1.0/#activity
 *
 * @uses ElggRiverItem $vars['item']    If passed, will detect the values for the above. Any values passed in have priority.
 *
 * @uses AS/Object    $vars['actor']        The entity who performed the action. Usually an AS Person.
 * @uses string       $vars['content']      Natural language describing the action. HTML ok.
 * @uses AS/Object    $vars['generator']    Describes the application that generated the content. Defaults to Elgg.
 * @uses AS/MediaLink $vars['icon']         An icon representing the activity. Aspect is 1:1.
 * @uses string       $vars['id']           An IRI to this activity's HTML representation.
 * @uses AS/Object    $vars['object']       The primary object of the activity.
 * @uses string       $vars['published']    The RFC3339 date-time stamp for when this activity was published.
 * @uses AS/Object    $vars['provider']     The application that published the activity.
 * @uses AS/Object    $vars['target']       The target of the verb for the actor. <actor> <verb>'d to <target>
 * @uses string       $vars['title']        Natural language title or headline. HTML ok.
 * @uses string       $vars['updated']      The RFC3339 date-time stamp for when this activity was updated.
 * @uses string       $vars['activity_url'] An IRI to the HTML representation of the activity.
 * @uses string       $vars['verb']         A verb describing the activity. See the list above.
 */

extract($vars);

$map = array(
	'actor',
	'content',
	'generator',
	'icon',
	'id',
	'object',
	'published',
	'provider',
	'target',
	'title',
	'updated',
	'activity_url' => 'url',
	'verb'
);

if ($item) {
	if (!$actor) {
		$actor_entity = $item->getSubjectEntity();
		if ($actor_entity) {
			$vars['actor'] = elgg_view_entity($actor_entity);
		}
	}

	if (!$object) {
		$object_entity = $item->getObjectEntity();
		if ($object_entity) {
			$vars['object'] = elgg_view_entity($object_entity);
		}
	}

	if (!$target) {
		$object_entity = $item->getObjectEntity();
		$target_entity = get_entity($object_entity->container_guid);
		// elgg's default is to make the container the owner.
		// don't need to send target in this context
		if ($target_entity && $target_entity != $object_entity) {
			$vars['target'] = elgg_view_entity($target_entity);
		}
	}

	if (!$content) {
		// we need to resolve the actual view for elgg_view_river_item() here.
		// this is probably less useful than just getting the summary.
		//$vars['content'] = elgg_view($item->getView(), $vars);
//		$vars['content'] = elgg_view('river/elements/content', $vars);
	}

	if (!$id) {
		// @todo implement.
		// need to expose a single river entry route
	}

	if (!$published) {
		$vars['published'] = ActivityStreams::formatDate($item->getPostedTime());
	}

	if (!$title) {
//		$vars['title'] = elgg_view('river/elements/summary', $vars, false, false, 'default');
//		$vars['title'] = elgg_view('river/elements/title', $vars);
	}

	if (!$activity_url) {
		$vars['activity_url'] = elgg_http_remove_url_query_element(current_page_url(), 'view');
	}

	if (!$verb) {
		$vars['verb'] = elgg_echo("activity_streams:verb:$item->action_type");
	}
}

$activity = activity_streams_build_array($map, $vars);
$activity['_elgg_river_item'] = $item;

echo activity_streams_json_encode($activity, false);