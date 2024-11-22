<?php

/**
 * Create a alert for any validation 
 * @param $msg 
 * @param $type  
 */
function createAlert($msg, $type = "danger")
{
    return "<p class=\"alert alert-{$type} d-flex justify-content-between\">{$msg}<button class=\"btn-close\" data-bs-dismiss=\"alert\"></button></p>";
}

/**
 * Get old form values after submit a form 
 */
function old($field_name)
{
    return $_POST[$field_name] ?? '';
}


/**
 * Reset  form old data after a successful submit
 */
function reset_form()
{
    return $_POST = [];
}


/**
 * File Uploading Function 
 */

function fileUplaod(array $files, string $path = "media/")
{
    // file manage 
    $tmp_name = $files['tmp_name'];
    $file_name = $files['name'];


    // get file extension  
    $file_arr = explode('.', $file_name);
    $file_ext =  strtolower(end($file_arr));

    // file name unique 
    $unique_filename =  time() . '_' . rand(100000, 10000000) . '_' . str_shuffle('1234567890') . '.' . $file_ext;

    // uplaod fie 
    move_uploaded_file($tmp_name, $path . $unique_filename);

    // return file name 
    return $unique_filename;
}




function createID($prefix = 'USER')
{
    // Use the current timestamp
    $timestamp = time();

    // Generate a random string
    $randomString = bin2hex(random_bytes(5));

    // Combine prefix, timestamp, and random string to form a unique ID
    $uniqueID = $prefix . '_' . $timestamp . '_' . $randomString;

    return $uniqueID;
}



function checkFileType($mimeType)
{

    $imageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
    $videoTypes = ['video/mp4', 'video/ogg', 'video/webm', 'video/quicktime'];


    if (in_array($mimeType, $imageTypes)) {
        return 'image';
    } elseif (in_array($mimeType, $videoTypes)) {
        return 'video';
    } else {
        return 'unknown';
    }
}


/**
 * Time ago function from timestamp
 */
function timeAgo($timestamp)
{
    // Convert the timestamp from milliseconds to seconds
    $timestamp = $timestamp;
    $timeNow = time();
    $timeDiff = $timeNow - $timestamp;

    if ($timeDiff < 60) {
        return 'just now';
    } elseif ($timeDiff < 3600) {
        $minutes = floor($timeDiff / 60);
        return $minutes == 1 ? '1 minute ago' : "$minutes minutes ago";
    } elseif ($timeDiff < 86400) {
        $hours = floor($timeDiff / 3600);
        return $hours == 1 ? '1 hour ago' : "$hours hours ago";
    } elseif ($timeDiff < 604800) {
        $days = floor($timeDiff / 86400);
        return $days == 1 ? '1 day ago' : "$days days ago";
    } elseif ($timeDiff < 2419200) {
        $weeks = floor($timeDiff / 604800);
        return $weeks == 1 ? '1 week ago' : "$weeks weeks ago";
    } else {
        $months = floor($timeDiff / 2419200);
        return $months == 1 ? '1 month ago' : "$months months ago";
    }
}
