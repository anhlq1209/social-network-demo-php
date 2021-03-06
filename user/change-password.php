<?php
    require_once '../config/init.php';
    $page = 'Đổi mật khẩu';
?>

<?php include '../layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) { ?>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pass = $_POST['password-old'];
            $newpass = $_POST['password-new'];
            $c_newpass = $_POST['password-new-confirm'];
            if ($pass == '' || $newpass == '' || $c_newpass == '') { ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Không được để trống thông tin!!!
                </div>
            <?php
            } elseif (checkPassword($pass)) {
                if ($newpass == $c_newpass) { 
                    $hashNewPassword = password_hash($newpass, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET password=? WHERE id=?";
                    $stmt= $db->prepare($sql);
                    $stmt->execute([$hashNewPassword, $_SESSION['userId']]);
        ?>
                    <div class="alert alert-success mt-3" role="alert">
                        Mật khẩu đã được thay đổi.
                    </div>
        <?php   
                }
            } else {
        ?>
            <div class="alert alert-danger mt-3" role="alert">
                Mật khẩu khẩu (cũ hoặc mới) không đúng!!!
            </div>
        <?php
            }
        }
    ?>
    <form method="POST">
        <div class="mb-3">
            <label for="password-old" class="form-label">Mật khẩu cũ</label>
            <input type="password" class="form-control" id="password-old" name="password-old">
        </div>
        <div class="mb-3">
            <label for="password-new" class="form-label">Mật khẩu mới</label>
            <input type="password" class="form-control" id="password-new" name="password-new">
        </div>
        <div class="mb-3">
            <label for="password-new-confirm" class="form-label">Mật khẩu mới (nhập lại)</label>
            <input type="password" class="form-control" id="password-new-confirm" name="password-new-confirm">
        </div>
        <button type="submit" class="btn btn-primary" name="form_change_password_click">Đổi mật khẩu</button>
    </form>
<?php } else { ?>
    <h3>Bạn chưa đăng nhập. Không thể tiếp tục hành động này!!!!</h3>
<?php } ?>

<?php include '../layouts/footer.php' ?>