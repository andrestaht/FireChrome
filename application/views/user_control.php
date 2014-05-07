<div id="user-control">
	<form id="user-control-form" action="<?php echo base_url() . "user_control/update_users" ?>" method="post">
		<table id="user-control-table">
			<tr>
				<th>Kasutajanimi</th>
				<th>Email</th>
				<th colspan="3">Kasutajatase</th>
				<th colspan="2">Uudiskiri</th>
				<th>Kustuta</th>
			</tr>
			<?php
				foreach ($users as $row) {
					echo "<tr>";
						echo "<td>" . $row->username . "</td>";
						echo "<td>" . $row->email . "</td>";

						echo "<td><input type='radio' name='" . "$row->id[level]" . "' value='1'" . ($row->level == 1 ? "checked" : "") . ">1</td>";
						echo "<td><input type='radio' name='" . "$row->id[level]" . "' value='5'" . ($row->level == 5 ? "checked" : "") . ">5</td>";
						echo "<td><input type='radio' name='" . "$row->id[level]" . "' value='10'" . ($row->level == 10 ? "checked" : "") . ">10</td>";

						echo "<td><input type='hidden' name='" . "$row->id[wants_newsletter]" . "' value='0'" . ($row->wants_newsletter != null ? "checked" : "") . "></td>";
						echo "<td><input type='checkbox' name='" . "$row->id[wants_newsletter]" . "' value='1'" . ($row->wants_newsletter != null ? "checked" : "") . "></td>";

						echo "<td><a class='delete-user-btn' href='" . base_url() . "user_control/delete_user/" . $row->id . "'>Kustuta</a></td>";
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