<?php 

	class PageTemplate {

		public function showHeader($data = "", $isIndex = false) {
			$logout = "";
			$navigation = "";
			if($data != "") {
				$logout = "<a href='/HSMS-MS/public/home/logout'>Logout</a>";
				$navigation = "<div id='navbar'>
									<div class='nav_button'><a href='/HSMS-MS/public/home/index'>Početna</a></div>
									<div class='nav_button'><a href='/HSMS-MS/public/data/index'>Upravljanje podacima</a></div>
									<div class='nav_button'><a href='/HSMS-MS/public/data/view/stats'>Statistički podaci</a></div>
								</div>
								</br>";
			} else {
				$navigation = "<div id='navbar'>
									<div class='nav_button'><a href='/HSMS-MS/public/home/index'>Početna</a></div>
									<div class='nav_button'><a href='/HSMS-MS/public/data/view/hsms'>Humanitarne akcije</a></div>
									<div class='nav_button'><a href='/HSMS-MS/public/data/view/stats'>Statistički podaci</a></div>
									<div class='nav_button'><a href='/HSMS-MS/public/home/index/admin'>Administracija</a></div>
								</div>
								</br>";
			}
			$src = "../../../app/views/res/logo.png";
			if($isIndex == true) {
				$src = "../../app/views/res/logo.png";
			}
			echo "<div id='header'>
					<img id='logo' src=\"".$src."\" alt=\"\" />
					<h1 id='header_title'>HSMS Management System</h1>
					<div id='user_session'>
						<p>".$data."</p></br></br></br>
						".$logout."
					</id>
				</div>";
			echo $navigation;
		}

		public function showFooter() {
			echo "<div id='footer'><p>Copyright HSMS Management System</p></div>";
		}

		public function showWelcome() {
			
		}

		public function showManagementPanel() {
			echo '<div id="management_panel"></br>';
			echo '<div class="man_button">
					<p>Upravljanje podacima</p>
					<a href="/HSMS-MS/public/data/index"><img src="../../app/views/res/data.png"></a>
				</div>';
			echo '<div class="man_button">
					<p>Statistički podaci</p>
					<a href="/HSMS-MS/public/data/view/stats"><img src="../../app/views/res/stats.png"></a>
				</div>';
			echo '</br></div>';
		}

		public function showLoginForm() {
			echo '
					<form action="/HSMS-MS/public/home/login" method="post">
						ID korisnika:<br>
						<input type="text" name="userid" value="">
						<br>
						<br>
						Lozinka:
						<input type="password" name="password" value="">
						<br>
						<input type="submit" value="Prijavi se" style="float: right; margin-top: 20px;">
				   </form>';
		}

		public function showInfo() {
			echo '<p style="padding: 10 10 10 10;">HSMS Management System je web aplikacija za upravljanje bazom humanitarnih SMS brojeva
				mobilnih operatera. Ova aplikacija omogućava unos novih, ažuriranje i održavanje podataka o humanitarnim
				akcijama u Srbiji za koje postoje humanitarni SMS brojevi, kao i održavanje podataka o povezanim
				organizacijama. Ideja je da se podaci web aplikacije izlože kroz REST API kako bi se podaci mogli iskoristiti
				za razvoj drugih (prvenstveno mobilnih) aplikacija.</p>';
		}

		public function showTable($data) {

		}

		public function loadHSMSAddForm() {

		}
	}

?>