<?php

if (file_exists(__DIR__ . "/autoload.php")) {
    require_once __DIR__ . "/autoload.php";
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create-dev-form"])) {

    //Get Form Data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $skill = $_POST["skill"];
    $location = $_POST["location"];
    $age = $_POST["age"];
    $gender =  $_POST["gender"]  ?? '';
    $photo = '';





    if (
        empty($name) || empty($email) || empty($phone) || empty($skill) ||    empty($age) ||  empty($location)

    ) {
        $msg = createAlert("All Fields Are Required");
    } else {


        if (isset($_FILES["photo"]["name"])) {
            $photo = fileUplaod([
                "name" => $_FILES["photo"]["name"],
                "tmp_name" => $_FILES["photo"]["tmp_name"]
            ], "media/devs/");
        }

        $sql = "INSERT INTO devs (name, email, phone, skill, location, age, gender, photo) VALUES (:name,:email,:phone,:skill,:location,:age,:gender,:photo) ";

        $statement =  connectDb()->prepare($sql);

        $statement->bindParam(":name", $name, PDO::PARAM_STR);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->bindParam(":phone", $phone, PDO::PARAM_STR);
        $statement->bindParam(":skill", $skill, PDO::PARAM_STR);
        $statement->bindParam(":location", $location, PDO::PARAM_STR);
        $statement->bindParam(":age", $age, PDO::PARAM_INT);
        $statement->bindParam(":gender", $gender, PDO::PARAM_STR);
        $statement->bindParam(":photo", $photo, PDO::PARAM_STR);

        $statement->execute();
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
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
                    <label class="w-100">
                        Name
                        <input class="form-control" type="text" name="name">
                    </label>
                    <label class="w-100">
                        Email
                        <input class="form-control" type="text" name="email">
                    </label>
                    <label class="w-100">
                        Phone
                        <input class="form-control" type="text" name="phone">
                    </label>
                    <label class="w-100">
                        Skill
                        <input class="form-control" type="text" name="skill">
                    </label>
                    <label class="w-100">
                        Location
                        <input class="form-control" type="text" name="location">
                    </label>
                    <label class="w-100">
                        Age
                        <input class="form-control" type="text" name="age">
                    </label>
                    <label class="w-100">
                        Photo
                        <input class="form-control" type="file" name="photo">
                    </label>
                    <div class="d-flex gap-2 align-items-end">
                        <label class="">
                            Gender <br>
                            <input value="Male" type="radio" name="gender"> Male
                        </label>
                        <label class="">
                            <input value="Female" type="radio" name="gender"> Female
                        </label>
                    </div>


                    <div class="py-3">
                        <button class="btn btn-primary" name="create-dev-form" type="submit">Submit</button>
                        <button class="btn btn-warning" type="reset">Reset</button>
                    </div>

                </form>
            </div>




        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>