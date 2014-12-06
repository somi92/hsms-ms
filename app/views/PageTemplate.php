<?php 

	class PageTemplate {

		public function showHeader($data = "") {
			$logout = "";
			$navigation = "";
			if($data != "") {
				$logout = "<a href='/HSMS-MS/public/home/logout'>Logout</a>";
				$navigation = "<div id='navbar'>
									<div class='nav_button'><a href='/HSMS-MS/public/home/index'>Pocetna</a></div>
								</br>";
			}
			echo "<div id='header'>
					<img id='logo' src=\"../../../app/views/res/logo.png\" alt=\"ERORR\" />
					<h1 id='header_title'>HSMS Management System</h1>
					<div id='user_session'>
						<p>".$data."</p></br></br></br>
						".$logout."
					</id>
				</div>";
			echo $navigation;
		}

		public function showFooter() {

		}

		public function showWelcome() {
			
		}

		public function showManagementPanel() {
			echo '</br></br>';
			echo '<a href="/HSMS-MS/public/data/index">Data management</a>';
			echo '</br></br>';
		}

		public function showLoginForm() {
			echo '<form action="/HSMS-MS/public/home/login" method="post">
						Unesite vas ID:<br>
						<input type="text" name="userid" value="">
						<br>
						<input type="submit" value="Submit">
				   </form>';
		}

		public function showTable($data) {

		}

		public function loadHSMSAddForm() {

		}
	}

?>