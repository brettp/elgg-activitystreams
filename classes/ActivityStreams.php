<?php
/**
 * Static helper methods
 */
class ActivityStreams {
	public static function getEntityAtomID(ElggEntity $entity) {
		$host = parse_url(elgg_get_site_url(), PHP_URL_HOST);
		$date = date('Y-m-d', $entity->time_created);
		$type = $entity->getType();
		$guid = $entity->getGUID();

		$id = "tag:$host,$date:/$type/$guid";
		$params = array('entity' => $entity);

		// allow plugins to override default id
		$atom_id = elgg_trigger_plugin_hook('activitystreams:id', 'entity', $params, $id);
		
		return $atom_id;
	}
	
	public static function getRiverAtomID(ElggRiverItem $item) {
		$host = parse_url(elgg_get_site_url(), PHP_URL_HOST);
		$date = date('Y-m-d', $item->posted);
		$id = $item->id;
		
		$atom_id = "tag:$host,$date:/river/$id";
		$params = array('item' => $item);

		// allow plugins to override default id
		$atom_id = elgg_trigger_plugin_hook('activitystreams:id', 'river', $params, $atom_id);
		return $atom_id;
	}

	public static function formatDate($date) {
		return date(DATE_ATOM, $date);
	}

	public static function formatTags($entity) {
		$tags = $entity->getTags();
		if (!$tags) {
			return "";
		}
		$output = "";
		foreach ($tags as $tag) {
			$tag = htmlspecialchars($tag);
			$output .= '<category scheme="urn:tag" term="'.$tag.'" label="'.$tag.'" />';
		}
		return $output;
	}
}
