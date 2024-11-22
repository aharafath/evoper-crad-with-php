<?php

if (file_exists(__DIR__ . "/autoload.php")) {
    require_once __DIR__ . "/autoload.php";
}





$userId = $_GET["edit_id"];

$sql = "SELECT * FROM devs WHERE id = '$userId'";
$statement =  connectDb()->prepare($sql);
$statement->execute();
$data = $statement->fetch(PDO::FETCH_OBJ);


if (empty($data)) {
    header("location:index.php");
} elseif (!empty($data)) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update-dev-form"])) {



        //Get Form Data
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $skill = $_POST["skill"];
        $location = $_POST["location"];
        $age = $_POST["age"];
        $gender =  $_POST["gender"]  ?? '';
        $photo = $data->photo;





        if (
            empty($name) || empty($email) || empty($phone) || empty($skill) ||    empty($age) ||  empty($location)

        ) {
            $msg = createAlert("All Fields Are Required");
        } else {


            if (!empty($_FILES["photo"]["name"])) {
                $photo = fileUplaod([
                    "name" => $_FILES["photo"]["name"],
                    "tmp_name" => $_FILES["photo"]["tmp_name"]
                ], "media/devs/");
                unlink("media/devs/" . $data->photo);
            }

            $sql = "UPDATE devs SET name=:name, email=:email, phone=:phone, skill=:skill, location=:location, age=:age, gender=:gender, photo=:photo WHERE id=:id";
            $statement = connectDb()->prepare($sql);
            $statement->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':skill' => $skill,
                ':location' => $location,
                ':age' => $age,
                ':gender' => $gender,
                ':photo' => $photo,
                ':id' => $userId,
            ]);
            header("location:index.php");
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container py-5">

        <div class="row">

            <div class="col-md-5 mx-auto shadow p-3">
                <?php echo $msg ?? "" ?>
                <div class="py-3">
                    <a href="./" class="btn btn-primary"><i class="fa-solid fa-arrow-left-long"></i> Back</a>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <label class="w-100">
                        Name
                        <input class="form-control" type="text" name="name" value="<?php echo $data->name ?>">
                    </label>
                    <label class="w-100">
                        Email
                        <input class="form-control" type="text" name="email" value="<?php echo $data->email ?>">
                    </label>
                    <label class="w-100">
                        Phone
                        <input class="form-control" type="text" name="phone" value="<?php echo $data->phone ?>">
                    </label>
                    <label class="w-100">
                        Skill
                        <input class="form-control" type="text" name="skill" value="<?php echo $data->skill ?>">
                    </label>
                    <label class="w-100">
                        Location
                        <input class="form-control" type="text" name="location" value="<?php echo $data->location ?>">
                    </label>
                    <label class="w-100">
                        Age
                        <input class="form-control" type="text" name="age" value="<?php echo $data->age ?>">
                    </label>
                    <label class="w-100">
                        Photo
                        <input class="form-control" type="file" name="photo">
                    </label>
                    <div class="d-flex gap-2 align-items-end">
                        <label class="">
                            Gender <br>
                            <input <?php echo $data->gender == "Male" ? "checked" : "" ?> value="Male" type="radio"
                                name="gender"> Male
                        </label>
                        <label class="">
                            <input <?php echo $data->gender == "Female" ? "checked" : "" ?> value="Female" type="radio"
                                name="gender"> Female
                        </label>
                    </div>


                    <div class="py-3">
                        <button class="btn btn-primary" name="update-dev-form" type="submit">Update</button>
                        <button class="btn btn-warning" type="reset">Reset</button>
                    </div>

                </form>
            </div>




        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>