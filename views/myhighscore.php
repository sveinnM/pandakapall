<?php
require("pandakapall/database.php");
$db = new Database();
$scores = $db->getMyHighestScores();
?>

<main>
	<div class="content highscore">
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
		<button id='resetTable'>Reset</button>
		<?php
			if (isset($_POST['resetTable'])) {
				$db->resetMyScores($_COOKIE['login_cookie']);
				echo "PERRAVERTADUR";
			}else {
				echo "HOLOASDA";
			}
		?>
	</div>
</main>