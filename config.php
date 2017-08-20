<?php
define('BLUDIT', true);
define('DS', DIRECTORY_SEPARATOR);
define('PATH_ROOT', __DIR__.DS);
define('CHARSET', 'UTF-8');
define('DOMAIN', 'https://plugins.bludit.com');
define('FILES', PATH_ROOT.'files'.DS);

// Language
$defaultLanguage = 'en';
$acceptedLanguages = array('en', 'de', 'es');
if (isset($_GET['l'])) {
	if (in_array($_GET['l'], $acceptedLanguages)) {
		$defaultLanguage = $_GET['l'];
	}
}

$jsonData = file_get_contents(PATH_ROOT.'languages'.DS.$defaultLanguage.'.json');
$languageArray = json_decode($jsonData, true);

function l($key, $print=true) {
	global $languageArray;
	$key = mb_strtolower($key, CHARSET);
	$key = str_replace(' ','-',$key);
	if (isset($languageArray[$key])) {
		if ($print) {
			echo $languageArray[$key];
		} else {
			return $languageArray[$key];
		}
	}
}

$defaultLocale = 'en_US';
if ($defaultLanguage == "es") {
        $defaultLocale = 'es_ES';
} elseif ($defaultLanguage == "de") {
        $defaultLocale = 'de_DE';
}

//
function listDirectories($path, $regex='*', $sortByDate=false) {
        $directories = glob($path.$regex, GLOB_ONLYDIR);
        if(empty($directories)) {
                return array();
        }
        if($sortByDate) {
                usort($directories, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
        }
        return $directories;
}