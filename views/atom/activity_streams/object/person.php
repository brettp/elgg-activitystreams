<?php

$person = $vars['entity'];
$host = parse_url(elgg_get_site_url(), PHP_URL_HOST);

$name = $person->name;
$username = $person->username;
$description = $person->description;
$website = $person->website;

?>

<id><?php echo $person->getURL(); ?></id>
<uri><?php echo $person->getURL(); ?></uri>
<name><?php echo elgg_view('output/text', array('value' => $person->name)); ?></name>
<summary><?php echo elgg_view('output/text', array('value' => $person->briefdescription)); ?></summary>
<link href="<?php echo htmlspecialchars($person->getIcon('small')); ?>" rel="preview" type="image/png" media:height="40" media:width="40" />
<link rel="avatar" type="image/png" media:width="25" media:height="25" href="<?php echo htmlspecialchars($person->getIcon('tiny')); ?>" />
<link rel="avatar" type="image/png" media:width="40" media:height="40" href="<?php echo htmlspecialchars($person->getIcon('small')); ?>" />
<link rel="avatar" type="image/png" media:width="100" media:height="100" href="<?php echo htmlspecialchars($person->getIcon('medium')); ?>" />
<link rel="avatar" type="image/png" media:width="200" media:height="200" href="<?php echo htmlspecialchars($person->getIcon('large')); ?>" />
<link rel="avatar" type="image/png" media:width="550" media:height="550" href="<?php echo htmlspecialchars($person->getIcon('master')); ?>" />
<poco:preferredUsername><?php echo $username; ?></poco:preferredUsername>
<poco:displayName><?php echo $name; ?></poco:displayName>
<?php
if ($description) {
?>
<poco:note><?php echo $description; ?></poco:note>
<?php
}
if ($website) {
?>
<poco:urls>
  <poco:type>homepage</poco:type>
  <poco:value><?php echo $website; ?></poco:value>
  <poco:primary>true</poco:primary>
</poco:urls>
<?php
}
?>

<link href="<?php echo htmlspecialchars($person->getURL()); ?>" rel="alternate" type="text/html" />
<activity:object-type>http://activitystrea.ms/schema/1.0/person</activity:object-type>
