<?php
    require_once 'config/init.php';
    $page = 'Quên mật khẩu';
?>

<?php include 'layouts/header.php' ?>

<?php
if (!isset($_SESSION['userId'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['email'] == "") {
            showAlertDanger("Không được để trống email!!!"); ?>
            <a href="/forgot-password.php" class="btn btn-primary">
                <i class="fas fa-undo-alt"></i>
                Quay lại
            </a>
            <?php
        } else {
            $email = $_POST['email'];
            sendForgotPasswordEmail($email);
            showAlertSuccess("Email khôi phục đã được gửi.");
        }
    } elseif (!isset($_GET['code'])) { ?>
            <h3 class="mt-3">Mời bạn nhập email để lấy lại mật khẩu</h3>
            <form method="POST">
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <button type="submit" class="btn btn-primary" name="form_forgot_password">Quên mật khẩu</button>
            </form>
            <?php
    } else { ?>
        <h3>Không thể tiếp tục hành động này!!!!</h3>
        <?php
    }
} else { ?>
    <h3>Không thể tiếp tục hành động này!!!!</h3>
<?php
} ?>

<?php include 'layouts/footer.php' ?>