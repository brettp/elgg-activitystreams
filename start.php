<?php
/**
 * Random thoughts
 *
 * JSON encoding can only be done one level at a time.
 *
 * The lowest level of a view chain needs to do a deep encoding
 *	This is the object/* views
 * 
 * Every other level needs to do a shallow encoding.
 * 
 * Entity views (<type>/<subtype>) are used for the AS objects.
 *
 * River views (river/<type>/<subtype>/action) are (will be) used for the content.
 *
 * River summary language strings (river:action:type:subtype) are (will be) used for the title.
 *
 * References:
 *  General specs: http://activitystrea.ms/head/activity-schema.html
 *  JSON specs:    http://activitystrea.ms/specs/json/1.0/
 */



/**
 * Start with the river
 *
 * Override list views
 */

function activity_streams_init() {
	elgg_extend_view('page/elements/head', 'activity_streams/head_ext');
	
	elgg_register_viewtype_fallback('atom');
//	elgg_register_viewtype_fallback('stream_json');
}

elgg_register_event_handler('init', 'system', 'activity_streams_init');

/**
 * Return
 *
 * @param mixed $data      Data to encode
 * @param bool  $recursive Recursively encode arrays or objects, or just the first level?
 *                         If not recursive, then assume strings, bools, or ints
 * @param int   $options   Bitwise encoding options. @see json_encode. WARNING: ignored if not recursive.
 *
 * @return string
 */
function activity_streams_json_encode($data, $recursive = true, $options = 0) {
	// no other modifications needed.
	if ($recursive) {
		return json_encode($data, $options);
	}

	$is_array = is_array($data);
	$is_object = is_object($data);

	if (!$is_array && !$is_object) {
		return json_encode($data, $options);
	}

	if ($is_object && method_exists($data, 'jsonSerialize')) {
		// if the object defines its own json serialization method, use it.
		return json_encode($object);
	}

	// json encode only the first level of items

	$is_assoc_array = activity_streams_is_assoc($data);;
	$json = array();

	if ($is_object || $is_assoc_array) {
		foreach ($data as $k => $v) {
			// keys. don't handle exotic keys.
			// if you make objects keys you don't deserve to json encode stuff.
			if (is_string($k)) {
				$k = json_encode($k);
//				$k = str_replace('"', '\"', $k);
//				$k = activity_streams_fix_newlines($k);
			}
			$v = activity_streams_return_json_value($v, $options);
			
			$json[] = "$k:$v";
		}
		$json = implode(',', $json);
		return '{' . $json . '}';
	} else {
		foreach ($data as $v) {
			$json[] = activity_streams_return_json_value($v, $options);
		}
		$json = implode(',', $json);
		return "[$json]";
	}
}

/**
 * Return the correct quoting for a to-be-json-encoded value.
 *
 * @param mixed $v
 * @return string
 */
function activity_streams_return_json_value($v, $options = 0) {
	$is_json = json_decode($v);

	if ($is_json) {
		return $v;
	} else {
		return json_encode($v, $options);
	}

	return;
	$is_json = json_decode($v);

	if (is_string($v) && !$is_json) {
		$v = activity_streams_fix_newlines($v);
		$v = str_replace('"', '\"', $v);
	}

	if ($is_json || is_int($v)) {
		// int and json don't need extra "s.
		return $v;
	} elseif (is_bool($v)) {
		// rewrite to js-style bools
		$v = ($v) ? 'true' : 'false';
		return $v;
	} else {
		// assume a string. this will probably break things. teehee!
		return "\"$v\"";
	}
}

/**
 * Check if $array is not an array with consecutive keys starting at 0.
 *
 * @param mixed $array
 * @return boolean
 */
function activity_streams_is_assoc($array) {
	if (!is_array($array)) {
		return false;
	}
	
	return array_keys($array) !== range(0, sizeof($array) - 1);
}

/**
 * @Todo
 *
 * @param type $str
 * @return type
 */
function activity_streams_fix_newlines($str) {
	// replace newlines with a marker
	$str = str_replace(array("\n", "\r", "\t"), '__ELGG_AS_SPACE__', $str);
	// replace all marked occurances with a single space
	$str = preg_replace('/(__ELGG_AS_SPACE__)+/', ' ', $str);

	return $str;
}

/**
 * Takes an map of keys in $vars and maps them to keys in the returned array with values
 * extracted from $vars.
 *
 * Maps should looke like array('key_in_vars' => 'key_in_return');
 *
 * @param array $map
 * @param array $vars
 */
function activity_streams_build_array($map, $vars) {
	$r = array();
	foreach ($map as $vars_key => $return_key) {
		// if the vars key is int, this is a shortcut definition.
		// use the value for both keys
		if (is_numeric($vars_key)) {
			$vars_key = $return_key;
		}
		// set even if it's falsey.
		if (array_key_exists($vars_key, $vars)) {
			$r[$return_key] = $vars[$vars_key];
		}
	}

	return $r;
}

function as_is_json($data) {
	if (json_decode($data)) {
		return true;
	}
	return false;
}

/**
 * Returns a title suitable for use as an activity title.
 *
 * This is usually some form of a river summary.
 * Checks for <$item->view>/title under the stream_json viewtype.
 * Will use river/elements/summary under the default viewtype otherwise.
 *
 * @param array $vars Vars that include ElggRiverItem $vars['item']
 * @return string
 */
function activity_streams_get_activity_title($vars) {
	$item = elgg_extract('item', $vars);

	if (!$item) {
		return false;
	}

	if (elgg_view_exists($item->view . '/title')) {
		return elgg_view($item->view . '/title', $vars);
	}

	return elgg_view('river/elements/summary', $vars, false, false, 'default');
}