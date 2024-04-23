<?php include 'header.php';?>
	<?php
	$ipath = "internal";
	$imagepath = "./images/";
	if ($ihandle = opendir($ipath)) {
		while (false !== ($ientry = readdir($ihandle))) {
			if ($ientry != "." && $ientry != "..") {
				$ititle = explode(".", $ientry);
				$ifile = fopen($ipath . '/' . $ientry, 'r');
				$iurl = fgets($ifile);
				$defaultImage = "Default.png";
				$imageFile = $imagepath . $ititle[0] . '.png';

				if (file_exists($imageFile)) {
					$imageSrc = $imageFile;
				} else {
					$imageSrc = $imagepath . $defaultImage;
				}

				echo '<div class="box"><a href="' . $iurl . '" target="_blank" rel="noopener noreferrer"><img src="' . $imageSrc . '"><br/><span class="tilelabel">' . $ititle[0] . '</span></a></div>';
				/*echo '<div class="pulser"><div class="box"><a href="' . $iurl . '" target="_blank" rel="noopener noreferrer"><img src="' . $imagepath . $ititle[0] . '.png"><BR/><span class="tilelabel">' . $ititle[0] . '</span></a></div>';*/
				fclose($ifile);
				}
			}
			closedir($ihandle);
		}
	?>
	</div>
	<div class="admin-cog"><a href="tileadmin.php" target="_self"><img src="./images/cog-2.png"></a></div>
<?php include 'footer.php';?>