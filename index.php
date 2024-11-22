<?php

if (file_exists(__DIR__ . "/autoload.php")) {
    require_once __DIR__ . "/autoload.php";
}


$sql = 'SELECT * FROM devs WHERE trash=false';


$statement =  connectDb()->prepare($sql);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_OBJ);





if (!empty($_GET["delete_id"])) {


    $userId = $_GET["delete_id"];

    $delete_sql = "SELECT * FROM devs WHERE id = '$userId'";
    $delete_statement =  connectDb()->prepare($delete_sql);
    $delete_statement->execute();
    $delete_data = $delete_statement->fetch(PDO::FETCH_OBJ);


    if (empty($delete_data)) {
        header("location:index.php");
    } elseif (!empty($delete_data)) {
        $sql = "UPDATE devs SET trash=:trash WHERE id=:id";
        $statement = connectDb()->prepare($sql);
        $statement->execute([
            ':trash' => 1,
            ':id' => $userId,
        ]);
        header("location:index.php");
    }
}


if (!empty($_GET["status_id"])) {


    $userId = $_GET["status_id"];

    $status_sql = "SELECT * FROM devs WHERE id = '$userId'";
    $status_statement =  connectDb()->prepare($status_sql);
    $status_statement->execute();
    $status_data = $status_statement->fetch(PDO::FETCH_OBJ);


    if (empty($status_data)) {
        header("location:index.php");
    } elseif (!empty($status_data)) {



        $sql = "UPDATE devs SET status=:status WHERE id=:id";
        $statement = connectDb()->prepare($sql);
        $statement->execute([
            ':status' => $status_data->status == 1 ? 0 : 1,
            ':id' => $userId,
        ]);

        header("location:index.php");
    }
}



if (!empty($_GET["back_id"])) {


    $userId = $_GET["back_id"];

    $back_sql = "SELECT * FROM devs WHERE id = '$userId'";
    $back_statement =  connectDb()->prepare($back_sql);
    $back_statement->execute();
    $back_data = $back_statement->fetch(PDO::FETCH_OBJ);


    if (empty($back_data)) {
        header("location:index.php");
    } elseif (!empty($back_data)) {
        $sql = "UPDATE devs SET trash=:trash WHERE id=:id";
        $statement = connectDb()->prepare($sql);
        $statement->execute([
            ':trash' => 0,
            ':id' => $userId,
        ]);
    }
}





if (!empty($_GET["remove_id"])) {

    $userId = $_GET["remove_id"];


    $remove_sql = "SELECT * FROM devs WHERE id = '$userId'";
    $remove_statement =  connectDb()->prepare($remove_sql);
    $remove_statement->execute();
    $remove_data = $remove_statement->fetch(PDO::FETCH_OBJ);

    if (empty($remove_data)) {
        header("location:index.php");
    } elseif (!empty($remove_data)) {
        unlink("media/devs/" . $remove_data->photo);
    }



    $remove_sql = "DELETE FROM devs WHERE id = '$userId'";
    $remove_statement =  connectDb()->prepare($remove_sql);
    $remove_statement->execute();
}



$sql = 'SELECT * FROM devs WHERE trash=false';


$statement =  connectDb()->prepare($sql);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_OBJ);

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
        <a href="./create-dev.php" class="btn btn-primary">Create a dev</a>
        <div class="row py-5">

            <?php
            if (empty($data)) {
                echo "<h1> Data Not Found </h1>";
            }
            ?>

            <?php if (!empty($data)): ?>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Photo</th>
                            <th scope="col">name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Skill</th>
                            <th scope="col">Location</th>
                            <th scope="col">Age</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($data as $key => $value) : ?>

                            <tr class="">
                                <th scope="row"> <?php echo $key + 1 ?></th>
                                <td>
                                    <img style="width: 50px; height: 50px; object-fit: cover; object-position: top;"
                                        class="rounded-circle" src="media/devs/<?php echo $value->photo ?>" alt="">

                                </td>
                                <td><?php echo $value->name ?></td>
                                <td><?php echo $value->email ?></td>
                                <td><?php echo $value->phone ?></td>
                                <td><?php echo $value->skill ?></td>
                                <td><?php echo $value->location ?></td>
                                <td><?php echo $value->age ?></td>
                                <td><?php echo $value->gender ?></td>
                                <td>

                                    <a href="index.php?status_id=<?php echo $value->id ?>"
                                        class="btn btn-sm <?php echo $value->status == false ? "btn-danger" : "btn-primary" ?>">
                                        <i style="<?php echo $value->status == false ? "rotate: 180deg;" : "" ?> "
                                            class="fa-solid fa-thumbs-up fa-fw"></i>
                                    </a>
                                </td>
                                <td>

                                    <a href="./edit-dev.php?edit_id=<?php echo $value->id ?>" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <a href="index.php?delete_id=<?php echo $value->id ?>" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>


            <?php
            endif;





            $sql = 'SELECT * FROM devs WHERE trash=true';
            $statement =  connectDb()->prepare($sql);
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_OBJ);







            if (!empty($data)):

            ?>


                <h1 class="mt-5 pt-5">Trash Data</h1>
                <hr>




                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Photo</th>
                            <th scope="col">name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Skill</th>
                            <th scope="col">Location</th>
                            <th scope="col">Age</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($data as $key => $value) : ?>

                            <tr class="">
                                <th scope="row"> <?php echo $key + 1 ?></th>
                                <td>
                                    <img style="width: 50px; height: 50px; object-fit: cover; object-position: top;"
                                        class="rounded-circle" src="media/devs/<?php echo $value->photo ?>" alt="">

                                </td>
                                <td><?php echo $value->name ?></td>
                                <td><?php echo $value->email ?></td>
                                <td><?php echo $value->phone ?></td>
                                <td><?php echo $value->skill ?></td>
                                <td><?php echo $value->location ?></td>
                                <td><?php echo $value->age ?></td>
                                <td><?php echo $value->gender ?></td>
                                <td>

                                    <a href="index.php?status_id=<?php echo $value->id ?>"
                                        class="btn btn-sm <?php echo $value->status == false ? "btn-danger" : "btn-primary" ?>">
                                        <i style="<?php echo $value->status == false ? "rotate: 180deg;" : "" ?> "
                                            class="fa-solid fa-thumbs-up fa-fw"></i>
                                    </a>
                                </td>
                                <td>

                                    <a href="index.php?back_id=<?php echo $value->id ?>" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-arrow-rotate-left"></i>
                                    </a>

                                    <a href="index.php?remove_id=<?php echo $value->id ?>" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

            <?php endif ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>