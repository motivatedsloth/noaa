<?php

spl_autoload_register(
		function($class){
				$class = str_replace("\\", "/", $class);
				@include dirname(__DIR__). "/" . $class . ".php";
		}
);
