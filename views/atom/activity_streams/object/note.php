<?php

$note = $vars['entity'];

// find parent
if ($vars['top_level'] && $note->reply) {
	$parents = $note->getEntitiesFromRelationship('parent');
	if ($parents)
		$parent = $parents[0];
}

?>

<id><?php echo ActivityStreams::getEntityAtomID($note); ?></id>
<content><![CDATA[<?php 
	echo elgg_view('output/longtext', array('value' => $note->description)); 
?>]]></content>
<published>
	<?php echo date(DATE_ATOM, $note->time_created); ?>
</published>
<updated>
	<?php echo date(DATE_ATOM, $note->time_updated); ?>
</updated>
<link rel="preview" type="image/png" href="<?php echo htmlspecialchars($note->getIcon('small')); ?>" />
<link rel="alternate" type="text/html" href="<?php echo htmlspecialchars($note->getURL()); ?>" />
<activity:object-type>http://activitystrea.ms/schema/1.0/note</activity:object-type>
<?php
if ($parent) {
?>
<thr:in-reply-to>
	<?php echo elgg_view_entity($parent); ?>
</thr:in-reply-to>
<?php
}
