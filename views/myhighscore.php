<?php
	require("pandakapall/database.php");
	$db = new Database();
	$scores = $db->getMyHighestScores();
?>

<main>
	<div class="content">
		<h2>Stigataflan mín</h2>
		<table role="grid" aria-readonly="true">
			<thead role="rowgroup">
				<tr role="row">
					<th role="columnheader">Nafn:</th>
					<th role="columnheader">Stig:</th>
				</tr>
			</thead>
			<tbody role="rowgroup">
				<?php 
					foreach ($scores as $key => $line) {
						echo "<tr>";
						echo "<td role='gridcell'><strong>" . $line['name'] . "</strong></td>";
						echo "<td role='gridcell'>" . $line['score'] . "</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
		<button id="resetTable" role="button">Hreinsa</button>
	</div>
</main>