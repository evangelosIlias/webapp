<?php 

 // Define allowed file types
 $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/pdf", "image/eps"];

 // Define maximum file size in bytes (5 MB)
 $max_size = 5242880;

 if (empty($post_image)) {
     // Image is not uploaded
     $error[] = "Please choose an image to upload";
 } elseif (!in_array($_FILES['image']['type'], $allowed_types)) {
     // Invalid file type
     $error[] = "Invalid image file type. Please upload a valid image file 'jpg' 'png', 'jpeg', 'gif', 'pdf', 'eps'";
 } elseif ($_FILES['image']['size'] > $max_size) {
     // File size is too large
     $error[] = "File size exceeds the maximum limit of 5 MB";
 } else {
     // Upload the file to server
     $target_dir = "./admin_upload_images/$post_image";
     move_uploaded_file($post_image_temp, $target_dir);
 }