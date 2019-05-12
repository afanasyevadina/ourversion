<?php
if(!empty($_POST)) {
	file_put_contents('../config.json', json_encode($_POST));
}
?>