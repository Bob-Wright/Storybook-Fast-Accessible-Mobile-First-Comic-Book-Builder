<?php
/*
* 	ZIP a list of files and folders
	-------------------------------
*
	Folders will be zipped recursively.
	If the destination zip file exists the file will be overwritten.
	Usage:
		Zip('$ziplist,'/path/to/compressed.zip',true);
	where $ziplist is a comma and space separated list of the form
		$ziplist = '../ItFigures, ../ItFigures.html, ../favicon.ico';
					^ a folder		^ a file			^ a file
	*
	*
	Third argrument sets zip structure:

	 IF third argrument to `true` files and subfolders will be added recursively under
	 each directory in $ziplist rather than in the zip folder root.
		ItFigures directory
		--- file 1
		--- file 2
		--- ItFigures subdirectory 1
		------ file 3
		------ file 4
		--- ItFigures subdirectory 2
		------ file 5
		------ file 6
		ItFigures.html file
		favicon.ico file

	IF the third argrument `false` or omitted, files and subfolders will be added
	recursively in the zip folder root:
		file 1
		file 2
		ItFigures subdirectory 1
		--- file 3
		--- file 4
		ItFigures subdirectory 2
		--- file 5
		--- file 6
		ItFigures.html file
		favicon.ico file
*
	Code modified from <https://stackoverflow.com/users/89771/alix-axel>
	by Bob Wright, 10/2019
*/

// disable the following error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

function Zip($sources, $destination, $include_dir = false) {
		// convert sources list to array
		$source_arr = explode(', ', $sources);
		//echo print_r($source_arr).'<br>';
		if (!extension_loaded('zip')) {
			return false;
		}

		if (file_exists($destination)) {
			unlink ($destination);
		}

		$zip = new ZipArchive();
		if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
			return false;
		}

    foreach ($source_arr as $source) {
        if (!file_exists($source)) continue;
		$source = str_replace('\\', '/', realpath($source));
		//echo '<br>Adding: '.$source;
		if (is_dir($source) === true)
		{

			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

			if ($include_dir) {

				$arr = explode("/",$source);
				$maindir = $arr[count($arr)- 1];

				$source = "";
				for ($i=0; $i < count($arr) - 1; $i++) { 
					$source .= '/' . $arr[$i];
				}

				$source = substr($source, 1);

				$zip->addEmptyDir($maindir);

			}

			foreach ($files as $file)
			{
				$file = str_replace('\\', '/', $file);

				// Ignore "." and ".." folders
				if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
					continue;

				$file = realpath($file);

				if (is_dir($file) === true)
				{
					$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
				}
				else if (is_file($file) === true)
				{
					$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
				}
			}
		}
		else if (is_file($source) === true)
		{
			$zip->addFromString(basename($source), file_get_contents($source));
		}

	}
//echo '<br>'.$destination.' Archive written.';
return $zip->close();
}

//$ziplist = '../ItFigures, ../ItFigures.html, ../favicon.ico';
// OR
//$ziplist = '../ItFigures';
//Zip($ziplist, 'ItFigures2.zip', true);
//exit;

?>