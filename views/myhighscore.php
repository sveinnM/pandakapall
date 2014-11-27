<?php
	require("pandakapall/database.php");
	$db = new Database();
	$scores = $db->getMyHighestScores();
?>

<main>
	<div class="content">
		<h2>Stigataflan mín</h2>
		<table>
			<thead>
				<tr>
					<th>Nafn:</th>
					<th>Stig:</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($scores as $key => $line) {
						echo "<tr>";
						echo "<td><strong>" . $line['name'] . "</strong></td>";
						echo "<td>" . $line['score'] . "</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
		<button id="resetTable">Hreinsa</button>
	</div>
</main>