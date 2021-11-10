<?php
    require_once 'init.php';
    $page = 'Đăng trạng thái';
?>

<?php include 'header.php' ?>

<?php if (isset($_SESSION['userId'])) {
        $userCur = getUserById($_SESSION['userId']);
        if (isset($_POST['form_post_click'])) {
            $content = $_POST['content_post'];
            $sql = "INSERT INTO posts(user_id, content) VALUES(?, ?)";
            $stmt= $db->prepare($sql);
            $stmt->execute([$_SESSION['userId'], $content]);
    ?>
            <div class="alert alert-success mt-3" role="alert">
                Trạng thái của bạn đã được đăng thành công :>
            </div>
    <?php
        }
    ?>
    <form method="POST">
        <div class="mb-3">
            <div class="avatar avatar--super-small rounded-circle dp--inline-block" style="background-image:url('./assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></div>
            <label for="content_post" class="form-label">Bạn đang nghĩ gì?</label>
            <textarea class="form-control" id="content_post" name="content_post" rows="4"></textarea>
            </div>
        <button type="submit" class="btn btn-primary float-end" name="form_post_click">Đăng</button>
    </form>
<?php } else { ?>
    <h3>Bạn chưa đăng nhập. Không thể tiếp tục hành động này!!!!</h3>
<?php } ?>

<?php include 'footer.php' ?>