<div id="UserControlDiv">

	<form id="UserControlForm" action='<?php echo base_url()."userControl/updateUsers"?>' method="post">
		<table id="UserControlTable">

			<tr>
				<th>Kasutajanimi</th>
				<th>Email</th>
				<th>Kasutajatase</th>
			</tr>

 <?php
	foreach ( $users as $row ) {
		echo "<tr>";
		echo "<td>" . $row->username . "</td>";
		echo "<td>" . $row->email . "</td>";
		echo "<td><input type='radio' name='" . $row->username . "' value=1";
		if ($row->level == 1) {
			echo " checked>1";
		} else {
			echo " >1";
		}
		;
		echo "<input type='radio' name='" . $row->username . "' value=5";
		if ($row->level == 5) {
			echo " checked>5";
		} else {
			echo ">5";
		}
		;
		echo "<input type='radio' name='" . $row->username . "' value=10";
		if ($row->level == 10) {
			echo " checked>10</td>";
		} else {
			echo ">10</td>";
		}
		;
		echo "</tr>";
	}
	?>

		</table>
		<input type="submit" value="Salvesta">
	</form>
<?php echo $confirmation?>
</div>