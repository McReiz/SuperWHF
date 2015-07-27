<?php
	global $wpdb;
	$whf_client = $wpdb->prefix. "whf_client";

	$query = $wpdb->get_results("SELECT * FROM $whf_client ORDER BY jobs_client_id DESC", ARRAY_A);

	
?>
<div id="jobs">
	<div class="head">
		<div class="administrar"></div>
		<div class="user">User: </div>
		<div class="name">Name: </div>
		<div class="email">Email: </div>
		<div class="rank">Rank: </div>
	</div>
	<?php
		foreach($query as $row){
		?>
			<div class="items">
				<div class="administrar"><a href="<?= URLADMIN ?>jobs-id=<?= $row['jobs_client_id'] ?>">Manager</a></div>
				<div class="user"><?= $row['jobs_client_user'] ?></div>
				<div class="name"><?= $row['jobs_client_name'] ?></div>
				<div class="email"><a href="mailto:<?= $row['jobs_client_email'] ?>"><?= $row['jobs_client_email'] ?></a></div>
				<div class="rank"><?= $row['jobs_client_rank'] ?></div>
			</div>
		<?php
		}
	?>
</div>