<?php
$folder = 'internal'; // Folder containing files
$imageFolder = 'images'; // Folder containing associated images

// Function to list files in a directory
function listFiles($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<option value='$file'>" . pathinfo($file, PATHINFO_FILENAME) . "</option>";
        }
    }
}

// Function to edit file content
function editFile($filename) {
    if (isset($_POST['content'])) {
        $content = $_POST['content'];
        file_put_contents("internal/$filename", $content);
        echo "<p>File updated successfully.</p>";
    }
    $content = file_get_contents("internal/$filename");
    echo "<div class='container editbox'><div class='row justify-content-center'><div class='col-md-6'><div class='form-group'><form method='post' class='form-control editbox'><textarea name='content' rows='10' cols='50'>$content</textarea><br><br><button type='submit' class='btn btn-success'><img src='./images/save.png' class='buttonimg' alt='submit'> Save</button>&nbsp;<button type='button' class='btn btn-warning' value='Cancel' onclick='window.history.back();'><img src='./images/cancelled.png'  class='buttonimg' > Cancel</button></div></form></div></div></div></div>";
}

// Function to delete file and associated image
function deleteFile($filename) {
    $filePath = "internal/$filename";
    $imagePath = "images/" . pathinfo($filename, PATHINFO_FILENAME) . ".png";
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "<p>File '$filename' deleted successfully.</p>";
    }
    if (file_exists($imagePath)) {
        unlink($imagePath);
        echo "<p>Associated image deleted successfully.</p>";
    }
}

if (isset($_POST['filename'])) {
    $selectedFile = $_POST['filename'];
    $action = $_POST['action'];

    switch ($action) {
        case 'edit':
            editFile($selectedFile);
            break;
        case 'delete':
            deleteFile($selectedFile);
            break;
    }
}

?>
<?php include 'header.php';?>
    <h2>File Manager</h2>
    <form method="post">
        <div class="form-group">
            <label for="filename">Select a file:</label>
            <select name="filename" class="form-control">
                <?php listFiles($folder); ?>
            </select>
        </div>
        <button type="submit" name="action" class="btn btn-info" value="edit"><img src='./images/edit-text.png' class='buttonimg' alt='submit'> Edit</button>
        <button type="submit" name="action" class="btn btn-danger" value="delete"><img src='./images/delete.png' class='buttonimg' alt='submit'> delete</button>
    </form>
<?php include 'footer.php';?>
