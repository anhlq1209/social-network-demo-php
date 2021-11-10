<?php
    require_once 'init.php';
    $page = 'Đăng nhập';
?>

<?php include 'header.php' ?>

<?php if (!isset($_SESSION['userId'])) {
        if (isset($_POST['form_login_click'])) {
            $mail = $_POST['email'];
            $pass = $_POST['password'];
            $user = getUserByEmail($mail);
            if ($user && password_verify($pass, $user['password'])) {
                $_SESSION['userId'] = $user['id'];
                header('Location: ./index.php');
                exit();
            } else { ?>
            <div class="alert alert-danger mt-3" role="alert">
                Email hoặc mật khẩu không đúng!
            </div>
    <?php } } ?>
    <h3 class="mt-3">Mời bạn đăng nhập</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="form_login_click">Đăng nhập</button>
    </form>
<?php } else { ?>
    <h3>Bạn đã đăng nhập. Không thể tiếp tục hành động này!!!!</h3>
<?php } ?>

<?php include 'footer.php' ?>