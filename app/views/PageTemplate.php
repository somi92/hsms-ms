<?php 

	class PageTemplate {

		public function showHeader($data = "") {
			$logout = "";
			$navigation = "";
			if($data != "") {
				$logout = "<a href='/HSMS-MS/public/home/logout'>Logout</a>";
				$navigation = "<div id='navbar'>
									<div class='nav_button'><a href='/HSMS-MS/public/home/index'>Pocetna</a>
								</div>
								</br>";
			}
			echo "<div id='header'>
					<img id='logo' src=\"../../app/views/res/logo.png\" alt=\"\" />
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
					<a href="/HSMS-MS/public/data/index"><img src="../../app/views/res/stats.png"></a>
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

		public function showTable($data) {

		}

		public function loadHSMSAddForm() {

		}
	}

?>