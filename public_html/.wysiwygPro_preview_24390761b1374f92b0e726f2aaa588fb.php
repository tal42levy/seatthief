<?php
if ($_GET['randomId'] != "PPCTRuhgKWVz0EqBj1cLJlXB2SkV1RwpunBHLECIczEODvLsijPURDDTZtU0sHdI") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
