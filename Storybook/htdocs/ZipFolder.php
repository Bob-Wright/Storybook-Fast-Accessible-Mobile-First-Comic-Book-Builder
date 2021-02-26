<?php
/*
 * Zip a folder recursively
 *
 *
If the zip file exists the file will be overwritten.
Usage:
    Zip('/path/to/maindirectory','/path/to/compressed.zip',true);
 *
Third argrument `true` zip structure:
 set third argrument to `true` all the files will be added under
 the main directory rather than directly in the zip folder.
    maindirectory
    --- file 1
    --- file 2
    --- subdirectory 1
    ------ file 3
    ------ file 4
    --- subdirectory 2
    ------ file 5
    ------ file 6
 *
Third argrument `false` or missing zip structure:
    file 1
    file 2
    subdirectory 1
    --- file 3
    --- file 4
    subdirectory 2
    --- file 5
    --- file 6

Code from: https://stackoverflow.com/users/89771/alix-axel *
*/

function Zip($source, $destination, $include_dir = false) {

		if (!extension_loaded('zip') || !file_exists($source)) {
			return false;
		}

		if (file_exists($destination)) {
			unlink ($destination);
		}

		$zip = new ZipArchive();
		if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
			return false;
		}
		$source = str_replace('\\', '/', realpath($source));

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

		return $zip->close();
}
