<?php
    require_once 'config/init.php';
    $page = 'Quên mật khẩu';
?>

<?php include 'layouts/header.php' ?>

<?php
if (!isset($_SESSION['userId'])) {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
        
            if (checkCode($code)) { ?>
                <h3 class="mt-3">Mời bạn nhập mật khẩu mới</h3>
                <form method="post">
                    <input type="hidden" id="code" name="code" value="<?php echo $code ?>">
                    <div class="mb-3">
                        <label for="passwordRS" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="passwordRS" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" class="form-control" id="confirmPasswordRS" name="confirmPassword">
                    </div>
                    <button type="submit" class="btn btn-primary disabled" name="form_forgot_password" id="btnChangePasswordRS">Đặt lại mật khẩu</button>
                </form>
                <?php
            } else { ?>
                <h3>Đường dẫn không chính xác!!!</h3>
                <?php
            }
        } else { ?>
            <h3>Đường dẫn không chính xác!!!</h3>
            <?php
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $code = $_POST['code'];
        $pass = $_POST['password'];
        
        updatePasswordByCode($code, $pass);

        header('Location: /');
    }
} else { ?>
    <h3>Không thể tiếp tục hành động này!!!!</h3>
<?php
} ?>

<?php include 'layouts/footer.php' ?>