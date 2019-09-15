<?php
$title = 'Журналы';
require_once('layout.php');
?>
	<div class="container">
		<div class="main">
			<h2>Журналы</h2>
			<select class="filter" id="courses">
				<option>2019-2020</option>
				<option>2018-2019</option>
				<option>2017-2018</option>
				<option>2016-2017</option>
				<option>2015-2016</option>
			</select>
			<div id="journals"></div>
		</div>
	</div>
	<script type="text/javascript">
		Load('journal/getjournal.php?kurs='+$('#courses').val(), '#journals');
		$('#courses').change(function() {
			Load('journal/getjournal.php?kurs='+$('#courses').val(), '#journals');
		});
	</script>
</body>
</html>