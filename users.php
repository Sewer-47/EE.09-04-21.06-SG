<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Panel administratora</title>
	<link rel="stylesheet" type="text/css" href="styl4.css">
</head>
<body>
	<header>
		<h3>Portal Społecznościowy - panel administratora</h3>
	</header>
	<div id="content"><!--nie wiem czy to jest poprawne-->
		<nav><!--lewy-->
				<h4>Użytkownicy</h4>
				<?php
					require_once 'connection.php';

					$connection = @new mysqli($host, $user, $password, $database);
					if ($connection -> connect_errno != 0) {
						echo "Blad polaczenia db";
						exit();
					}

					$result = $connection -> query('SELECT * FROM osoby');
					//lista nie miesci sie na stronie, a imiona i nazwiska sie powtarzaja idk czy tak ma byc
					while ($row = mysqli_fetch_assoc($result)) {
						$wiek = 2022 - (int) $row['rok_urodzenia'];
						echo $row['id'] . '. ' . $row['imie'] . ' ' . $row['nazwisko'] . " , " . $wiek . " lat<br>";
					}
				?>
				<a href="settings.html">Inne ustawienia</a>
		</nav>
		<aside><!--prawy-->
			<h4>Podaj id użytkownika</h4>
			<form method="POST">
					<input type="number" name="userId">
					<input type="submit" name="userIdSubmit" value="ZOBACZ" id="userSubmit">
			</form>
			<hr>
			<?php
				require_once 'connection.php';

				if (!empty($_POST['userId'])) {
					$id = $_POST['userId'];

					$connection = @new mysqli($host, $user, $password, $database);
					$result = $connection -> query("SELECT * FROM osoby WHERE id LIKE $id");

					while($row = mysqli_fetch_assoc($result)) {
						echo '<h2>' . $id . ". " . $row['imie'] . ", " . $row['nazwisko'] . '</h2>';
						$img_src = $row['zdjecie'];
						echo "<img src='img/$img_src' alt='$img_src'>";
						echo "<p>Rok urodzenia: " . $row['rok_urodzenia'] . "</p>";
						echo "<p>Opis: " . $row['opis'] . "</p>";
						//Mozliwe, ze mozna to zrobic lepiej
						$hobbyResult = $connection -> query('SELECT * FROM hobby WHERE id LIKE ' . $row['Hobby_id']);
						while ($hobbyRow = mysqli_fetch_assoc($hobbyResult)) {
							echo "<p>Hobby: " . $hobbyRow['nazwa'] . "</p>";
						}	
					}
					$connection -> close();
				}
			?>
		</aside>
	</div>
	<footer>
		Stronę wykonał: Seweryn
	</footer>
</body>
</html>