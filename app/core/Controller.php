<?php

	class Controller {
		
		public function getModel($model) {
			// file check!
			require_once '../app/models/'.$model.'.php';
			// return new $model();
		}

		public function getView($view, $data = "") {
			// file check!
			require_once '../app/views/'.$view.'.php';
		}
	}

?>