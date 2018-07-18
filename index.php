<?php
error_reporting(0);
require_once('./functions.php');
require_once('./config.php');

if (!isset($_GET["url"])) {
	http_response_code(400);
	exit(0);
}

$url = str_replace('"', '', $_GET['url']);
$path = generate_path($config['output_dir'], $_GET['filename']);
$command = build_command(extract_options(), $url, $path);

$status = 0;
$result = exec($command, $output, $status);

var_dump($status);

if ($status === 0) {
	echo $path;
	exit();
}

http_response_code(500);
echo "Failed";
?>