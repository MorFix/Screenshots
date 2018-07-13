<?php
function build_command($options, $url, $path) {
	$command = $options['executable'];
	
	foreach($options as $key => $value) {
		if ($key != 'executable') {
			$command .= ' --' . $key . ' ' . $value;
		}
	}
	
	return $command . ' "' . $url . '" ' . $path;
}

function generate_path($output_dir, $filename = null) {		
	if(empty($filename) || !preg_match('/^\w+$/', $filename)) {
		return build_path($output_dir, uniqid(rand(), true));
	}
	
	$counter = 0;
	$name = $filename;
	$path = build_path($output_dir, $name);
	
	while (file_exists($path)) {
		$name = $filename . '_' . ++$counter;
		$path = build_path($output_dir, $name);
	}
	
	return $path;
}

function build_path($output_dir, $filename) {
	return $output_dir . DIRECTORY_SEPARATOR . $filename . '.' . get_format_options()['extension'];
}

function extract_options() {
	$options = array();

	$options['executable'] = get_format_options()['executable'];
	
	if (!empty($_GET['wait']) && is_numeric($_GET['wait'])) {
		$options['javascript-delay'] = $_GET['wait'];
	}
	
	return $options;
}

function get_format_options() {
	$options = array();
	
	if (isset($_GET['format']) && $_GET['format'] == 'image') {
		$options['executable'] =  'wkhtmltoimage';
		$options['extension'] = 'jpeg';
	} else {
		$options['executable'] = 'wkhtmltopdf';
		$options['extension'] = 'pdf';
	}
	
	return $options;
}
?>