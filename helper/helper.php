<?php
function post($key)
{
    return $_POST[$key] ?? null;
}

function fileUpload($uploadDir, $file)
{
    $dirCheck = file_exists($uploadDir);
    if (!$dirCheck) {
        mkdir($uploadDir, 0777, true);
    }

    $name = $file['name'];
    $tmpName = $file['tmp_name'];
    $fileExtension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $allowedExtensions = ['png', 'jpeg', 'jpg', 'webp'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = uniqid('', true) . "_" . time() . "." . $fileExtension;

        if (move_uploaded_file($tmpName, $uploadDir . $newFileName)) {
            return $newFileName;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function validation($keys)
{
    $errors = [];
    foreach ($keys as $key) {
        $keyy = trim(strtolower($key));
        if ($key == "password_confirm") {
            $key = "Password Confirmation";
        }
        elseif ($keyy == "gender") {
            if (!isset($_POST['gender']) || $_POST['gender'] === '') {
                $errors['gender'] = "$key field is required";
            }
        } 
        elseif ($key == "Date of Birth") {
            if (!strtotime($_POST['date'])) {
                $errors[$keyy] = "$key field is required";
            }
        }
        elseif (!isset($_POST[$keyy]) || empty($_POST[$keyy])) {
            $errors[$keyy] = "$key field is required";
        }
    }
    return $errors;
}

function auth(){
    if(isset($_SESSION['user_id'])){
        return true;
    }else{
        return false;
    }
}

function dd($parameter){
    echo "<pre>";
    print_r($parameter);
    echo "</pre>";
    die();
}
