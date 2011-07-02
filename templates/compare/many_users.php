<h1><?php echo $list_details['name']; ?></h1>
<h2><?php 
$users_names = array();
foreach($users as $user_details) $users_names[] = $user_details['details']['name'];
echo implode(' Vs ', $users_names);
?></h2>

<table>
<tr><th></th><th></th><th></th><?php
foreach($users as $user_details) print "<th>{$user_details['details']['name']}</th>";
print "</tr>";

$count = 0;
foreach($items as $item) { 
	$count++;
	$read = false;
	if(!empty($user_read[$item['id']])) $read = true;
?>
<tr id="item-<?php echo $item['id'] ?>" class="<?php echo ($count % 2) ? 'odd' : 'even'?> item-row">
<td class="count"><?php echo $count ?></td>
<td class="image"><?php if($item['image']) echo "<img src='" . $config['site_url'] . str_replace('/big/', '/small/', $item['image']) . "' alt='$item[name]' />"; ?></td>
<td><span class="title <?php if($read) echo 'read'; ?>"><?php echo $item['name']; ?></span><br />
<span class="author"><?php echo $item['author'] ?></span></td>

<?php foreach($users as $user_details) { ?>
<td><?php echo (in_array($item['id'], $user_details['read'])) ? '<span class="icon active">Read</span>' : '<span class="icon deactive">Unread</span>'; ?></td>
<?php } ?>

</tr>
<?php } ?>
</table>
