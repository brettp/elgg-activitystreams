<?php

$group = $vars['entity'];

?>

<id><?php echo ActivityStreams::getEntityAtomID($group); ?></id>
<title><?php echo elgg_view('output/text', array('value' => $group->name)); ?></title>
<summary><?php echo elgg_view('output/text', array('value' => $group->briefdescription)); ?></summary>
<content><?php echo elgg_view('output/text', array('value' => $group->description)); ?></content>
<published>
	<?php echo date(DATE_ATOM, $group->time_created); ?>
</published>
<updated>
	<?php echo date(DATE_ATOM, $group->time_updated); ?>
</updated>
<link rel="preview" type="image/png" href="<?php echo htmlspecialchars($group->getIcon('small')); ?>" />
<link rel="alternate" type="text/html" href="<?php echo htmlspecialchars($group->getURL()); ?>" />
<activity:object-type>http://activitystrea.ms/schema/1.0/group</activity:object-type>
