<?php
    require_once 'init.php';
    $page = 'Thông tin cá nhân';
?>

<?php include 'header.php' ?>

<?php
if (isset($_SESSION['userId'])) {
    $userCur = getUserById($_SESSION['userId']);
    if (isset($_POST['form_update_profile_click'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $file = 'avatar-default';

        if (isset($_FILES['avatar'])) {
            unlink("./assets/images/avatars/".$userCur['avatar']);
            $fileName = $_FILES['avatar']['name'];
            $fileName = $userCur['id'].substr($fileName, strpos($fileName, '.', strlen($fileName) - 5), strlen($fileName));
            $fileTemp = $_FILES['avatar']['tmp_name'];
            $result = move_uploaded_file($fileTemp, './assets/images/avatars/' . $fileName);
            $file = $fileName;
        }

        $stmt= $db->prepare("UPDATE users SET displayname=?, phone=?, avatar=? WHERE id=?");
        $stmt->execute(array($name, $phone, $file, $_SESSION['userId']));
        $userCur = getUserById($_SESSION['userId']);
        ?>
        <div class="alert alert-success mt-3" role="alert">
            Thông tin cá nhân đã được cập nhật ;)
        </div>
    <?php
    }
    ?>
    <div class="avatar rounded-circle mx-auto my-3" style="background-image:url('./assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></div>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <input class="form-control" type="file" name="avatar">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Họ Tên</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $userCur['displayname'] ?>">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $userCur['phone'] ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="form_update_profile_click">Cập nhật</button>
    </form>
<?php } else { ?>
    <h3>Bạn chưa đăng nhập. Không thể tiếp tục hành động này!!!!</h3>
<?php } ?>

<?php include 'footer.php' ?>