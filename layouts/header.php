<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noir Lee<?php echo $page == 'Trang chủ' ? '' : ' - '.$page ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
    <!-- <link rel="stylesheet" href="../assets/css/my-style.css"> -->
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/index.php">Noir Lee</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link <?php echo $page == "Trang chủ" ? "active" : "" ?>" aria-current="page" href="/index.php">Trang chủ</a>
                    </li>
                    <?php if (isset($_SESSION['userId'])) {
                        $userCur = getUserById($_SESSION['userId']);
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $userCur['displayname'] ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li class="dropdown-item">
                                    <a class="nav-link <?php echo $page == "Thông tin cá nhân" ? "active" : "" ?>" href="/user/profile.php">Thông tin cá nhân</a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="nav-link <?php echo $page == "Đăng trạng thái" ? "active" : "" ?>" href="/user/up-post.php">Đăng trạng thái</a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="nav-link <?php echo $page == "Tường" ? "active" : "" ?>" href="/user/wall.php">Tường</a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="nav-link <?php echo $page == "Đổi mật khẩu" ? "active" : "" ?>" href="/user/change-password.php">Đổi mật khẩu</a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="nav-link <?php echo $page == "" ? "active" : "" ?>" href="/logout.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Bạn bè
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li class="dropdown-item">
                                    <a class="nav-link <?php echo $page == "Danh sách bạn bè" ? "active" : "" ?>" href="/friend/index.php">Danh sách bạn bè</a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="nav-link <?php echo $page == "Lời mời kết bạn" ? "active" : "" ?>" href="/friend/friend-req.php">Lời mời kết bạn</a>
                                </li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == "Đăng ký" ? "active" : "" ?>" href="/register.php">Đăng ký</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == "Đăng nhập" ? "active" : "" ?>" href="/login.php">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page == "Quên mật khẩu" ? "active" : "" ?>" href="/forgot-password.php">Quên mật khẩu</a>
                        </li>
                    <?php } ?>
                </ul>
                </div>
            </div>
        </nav>