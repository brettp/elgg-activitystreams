<?php

$article = $vars['entity'];

?>

<id><?php echo ActivityStreams::getEntityAtomID($article); ?></id>
<title>
	<?php echo elgg_view('output/text', array('value' => $article->title)); ?>
</title>
<content type="html">
	<?php echo elgg_view('output/text', array('value' => $article->description)); ?>
</content>
<published>
	<?php echo date(DATE_ATOM, $article->time_created); ?>
</published>
<updated>
	<?php echo date(DATE_ATOM, $article->time_updated); ?>
</updated>
<activity:object-type>article</activity:object-type>
<link rel="preview" type="image/png" href="<?php echo htmlspecialchars($article->getIcon('small')); ?>" />
<link rel="alternate" type="text/html" href="<?php echo htmlspecialchars($article->getURL()); ?>" />
