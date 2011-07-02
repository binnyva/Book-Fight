<h1><?php echo $list_details['name']; ?></h1>
<h2><?php 
$users_names = array();
foreach($users as $user_details) $users_names[] = $user_details['details']['name'];
echo implode(' Vs ', $users_names);
?></h2>

<table>
<tr><th><h3><?php echo $users[0]['details']['name'] .'('.count($users[0]['read']).')'; ?></h3></th>
<th style="text-align:center;"><h3>Both</h3></th>
<th style="text-align:right;"><h3><?php echo $users[1]['details']['name'] .'('.count($users[1]['read']).')'; ?></h3></th></tr>

<tr><td valign="top">
<?php showBookCollection($user_0_only); ?>
</td><td valign="top">
<?php showBookCollection($both_read); ?>
</td><td valign="top">
<?php showBookCollection($user_1_only); ?>
</td></tr>
</table>


<?php
function showBookCollection($collection) {
	global $items, $config;
	echo '<table>';
	$count = 0;
	foreach($collection as $book_id) {
		$count++;
		$item = $items[$book_id]
?>
<tr id="item-<?php echo $item['id'] ?>" class="<?php echo ($count % 2) ? 'odd' : 'even'?> item-row">
<td class="count"><?php echo $count ?></td>
<td class="image"><?php if($item['image']) echo "<img src='" . $config['site_url'] . str_replace('/big/', '/small/', $item['image']) . "' alt='$item[name]' />"; ?></td>
<td><span class="title"><?php echo $item['name']; ?></span><br />
<span class="author"><?php echo $item['author'] ?></span></td>
</tr>
<?php 
	}
	echo '</table>';
}