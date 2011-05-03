<h1>BBC Top 100 List</h1>

<ul class="tabs">
<li class="tab-selected"><a href="#all" id="show-all" class="with-icon all-books">All(100)</a></li>
<li><a href="#read" id="show-read" class="with-icon read-books">Read(<span id="read-count"><?php echo count($user_read); ?></span>)</a></li>
<li><a href="#unread" id="show-unread" class="with-icon unread-books">Unread(<span id="unread-count"><?php echo 100-count($user_read); ?></span>)</a></li>
</ul>

<table>
<?php
$count = 0;
foreach($items as $item) { 
	$count++;
?>
<tr class="<?php echo ($count % 2) ? 'odd' : 'even'?> item-row">
<td class="count"><?php echo $count ?></td>
<td><span class="title"><?php echo $item['name'] ?></span><br />
<span class="author"><?php echo $item['author'] ?></span></td>

<td><span class="details"></span></td>
<td><span class="action"><input type="checkbox" name="item[<?php echo $item['id'] ?>]" id="item-<?php echo $item['id'] ?>" class="read" <?php 
	if(!empty($user_read[$item['id']])) echo 'checked="checked"';
?> /></span>
</td>
</tr>
<?php } ?>
</table>

