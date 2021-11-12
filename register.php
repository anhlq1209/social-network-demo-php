<?php
    require_once 'config/init.php';
    $page = 'Đăng ký';
?>

<?php include 'layouts/header.php' ?>

<?php if (!isset($_SESSION['userId'])) { ?>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $mail = $_POST['email'];
            $phone = $_POST['phone'];
            $pass = $_POST['password'];
            $cpass = $_POST['confirmPassword'];
            
            if ($name == '' || $mail == '' || $phone == '' || $pass == '' || $cpass == '') { ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Không được để trống thông tin!!!
                </div>
            <?php
            } elseif (checkUser($mail)) { ?>
                <div class="alert alert-danger mt-3" role="alert">
                    Email đã được đăng ký!
                </div>
    <?php   } elseif ($pass != $cpass) { ?>
                <div class="alert alert-danger mt-3" role="alert">
                    Mật khẩu xác nhận không đúng!
                </div>
            <?php            
            } else {
                insertUser($name, $mail, $phone, $pass) ?>
                <div class="alert alert-success mt-3" role="alert">
                    Đăng ký tài khoản thành công ;)
                </div>
                <?php
            }
        }
    ?>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Họ Tên</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Mật khẩu (nhập lại)</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
        </div>
        <button type="submit" class="btn btn-primary" name="form_register_click">Đăng ký</button>
    </form>
<?php } else { ?>
    <h3>Bạn đã đăng nhập. Không thể tiếp tục hành động này!!!!</h3>
<?php } ?>

<?php include 'layouts/footer.php' ?>