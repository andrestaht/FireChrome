<div id="user-control">
	<form id="user-control-form" action='<?php echo base_url() . "user_control/update_users" ?>' method="post">
		<table id="user-control-table">
			<tr>
				<th>Kasutajanimi</th>
				<th>Email</th>
				<th>Kasutajatase</th>
				<th>Kustuta</th>
			</tr>
			<?php
				foreach ( $users as $row ) {

					echo "<tr>";
					echo "<td>" . $row->username . "</td>";
					echo "<td>" . $row->email . "</td>";

					echo "<td><input type='radio' name='" . $row->id . "' value=1";

					if ($row->level == 1) {
						echo " checked>1";
					}
					else {
						echo " >1";
					}

					echo "<input type='radio' name='" . $row->id . "' value=5";
			
					if ($row->level == 5) {
						echo " checked>5";
					}
					else {
						echo ">5";
					}

					echo "<input type='radio' name='" . $row->id . "' value=10";

					if ($row->level == 10) {
						echo " checked>10</td>";
					}
					else {
						echo ">10</td>";
					}

					echo "<td><a class='delete-user-btn' href='" . base_url()."user_control/delete_user/" . $row->id . "'>Kustuta</a></td>";
					echo "</tr>";
				}
			?>
		</table>
		<?php
			echo "<p>";
			echo form_submit('change-levels-submit-btn', 'Salvesta');
			echo "</p>";
		?>
	</form>
	<?php echo $confirmation ?>
</div>