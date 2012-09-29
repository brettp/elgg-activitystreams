<?php

$person = $vars['entity'];
$host = parse_url(elgg_get_site_url(), PHP_URL_HOST);

?>

<id><?php echo $person->getURL(); ?></id>
<uri><?php echo $person->getURL(); ?></uri>
<name><?php echo elgg_view('output/text', array('value' => $person->name)); ?></name>
<summary><?php echo elgg_view('output/text', array('value' => $person->briefdescription)); ?></summary>
<link href="<?php echo htmlspecialchars($person->getIcon('small')); ?>" rel="preview" type="image/png" media:height="40" media:width="40" />
<link href="<?php echo htmlspecialchars($person->getIcon('small')); ?>" rel="avatar" type="image/png" media:height="40" media:width="40" />
<link href="<?php echo htmlspecialchars($person->getURL()); ?>" rel="alternate" type="text/html" />
<activity:object-type>http://activitystrea.ms/schema/1.0/person</activity:object-type>
