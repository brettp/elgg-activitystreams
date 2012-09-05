<?php

$person = $vars['entity'];

?>

<id><?php echo ActivityStreams::getEntityAtomID($person); ?></id>
<name><?php echo elgg_view('output/text', array('value' => $person->name)); ?></name>
<summary><?php echo elgg_view('output/text', array('value' => $person->briefdescription)); ?></summary>
<link href="<?php echo htmlspecialchars($person->getIcon('small')); ?>" rel="preview" type="image/png" media:height="40" media:width="40" />
<link href="<?php echo htmlspecialchars($person->getIcon('small')); ?>" rel="avatar" type="image/png" media:height="40" media:width="40" />
<link href="<?php echo htmlspecialchars($person->getURL()); ?>" rel="alternate" type="text/html" />
<activity:object-type>person</activity:object-type>
