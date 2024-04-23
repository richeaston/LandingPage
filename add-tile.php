<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are filled
    if (empty($_POST["tile_title"]) || empty($_POST["url"]) || empty($_FILES["tile_image"]["name"])) {
        echo "All fields are required.";
    } else {
        $tile_title = $_POST["tile_title"];
        $url = $_POST["url"];
        $tile_image = $_FILES["tile_image"];

        // Check if the image file is a PNG
        $imageFileType = strtolower(pathinfo($tile_image["name"], PATHINFO_EXTENSION));
        if ($imageFileType != "png") {
            echo "Only PNG files are allowed.";
        } else {
            $target_dir = "Internal/";
            $target_file = $target_dir . $tile_title . ".bob";
            $image_dir = "Images/";
            $image_file = $image_dir . $tile_title . ".png";

            // Move the image file to Images folder
            if (move_uploaded_file($tile_image["tmp_name"], $image_file)) {
                // Create and write URL to .bob file
                if (file_put_contents($target_file, $url)) {
                    echo "Tile added successfully.";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Failed to create .bob file.";
                }
            } else {
                echo "Failed to upload image file.";
            }
        }
    }
}
?>

    <?php include 'header.php'; ?>
    <h1>Add Tile</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
			<label for="TileTitle">Tile Title:</label>
			<input class="form-control" type="text" name="tile_title">
		</div>
        <div class="form-group">
			<label for="TileURL">URL:</label>
			<input class="form-control" type="text" name="url">
        </div>
		<div class="form-group">
			<label>Tile Image:</label>
			<input class="form-control" type="file" name="tile_image">
		</div>
        <button type="submit" class="btn btn-default">Submit</button>
		<button type="reset" class="btn btn-danger">Reset</button>
    </form>
    <?php include 'footer.php'; ?>

