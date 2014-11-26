<?php
require("pandakapall/Database.php");
$db = new Database();
$scores = $db->getMyHighestScores();
?>

<main>
	<div class="content">
		<h2>MY HIGHSCORE</h2>
		<table>
			<thead>
				<tr>
					<th>Nafn:</th>
					<th>Stig:</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($scores as $key => $line ) {
						echo "<tr> <td><strong>" . $line['name'] . "</strong></td> <td>" . $line['score'] . "</td></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</main>