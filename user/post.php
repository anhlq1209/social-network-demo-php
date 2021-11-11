<?php
    require_once '../config/init.php';
    $page = 'Đăng trạng thái';
?>

<?php include '../layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) {
        $userCur = getUserById($_SESSION['userId']);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $content = $_POST['content_post'];
            
            if ($content == '') { ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Bạn chưa nhập trạng thái!!
                </div>
            <?php
            } else {
                $stmt = $db->prepare("INSERT INTO posts(user_id, content) VALUES(?, ?)");
                $stmt->execute(array($userCur['id'], $content)); ?>
                    <div class="alert alert-success mt-3" role="alert">
                        Trạng thái của bạn đã được đăng thành công :P
                    </div>
            <?php
            }
        }
    ?>
    <form method="POST">
        <div class="mb-3">
            <div class="avatar avatar--super-small rounded-circle dp--inline-block" style="background-image:url('../assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></div>
            <label for="content_post" class="form-label">Bạn đang nghĩ gì?</label>
            <textarea class="form-control" id="content_post" name="content_post" rows="4"></textarea>
            </div>
        <button type="submit" class="btn btn-primary float-end" name="form_post_click">Đăng</button>
    </form>
<?php } else { ?>
    <h3>Bạn chưa đăng nhập. Không thể tiếp tục hành động này!!!!</h3>
<?php } ?>

<?php include '../layouts/footer.php' ?>