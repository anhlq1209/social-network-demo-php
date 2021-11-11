<?php
    require_once '../config/init.php';
    $page = 'Tường';
?>

<?php include '../layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) {
    if (isset($_POST['form_add_friend'])) {
        var_dump($_POST['form_add_friend']);
    }
    if (isset($_GET['id'])) {
        $userCur = getUserById($_GET['id']);
        if (!$userCur) { ?>
            <div class="alert alert-danger mt-3" role="alert">
                Không tìm thấy người dùng có ID: <?php echo $_GET['id'] ?>!
            </div>    
        <?php
            exit();
        }
    } else {
        $userCur = getUserById($_SESSION['userId']);
    } ?>
    <div class="content">
        <div class="info">
            <div class="avatar rounded-circle" style="background-image:url('./assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></div>
            <h4 class="mt-3"><?php echo $userCur['displayname'] ?></h4>
            <?php
                if ($_SESSION['userId'] != $userCur['id']) {
                    if (!checkFriend($_SESSION['userId'], $userCur['id'])) { ?>
                        <form method="POST" action="add-friend.php">
                            <input type="hidden" class="form-control" id="userCur" name="userCur" value="<?php echo $_SESSION['userId'] ?>">
                            <input type="hidden" class="form-control" id="userFriend" name="userFriend" value="<?php echo $userCur['id'] ?>">
                            <button type="submit" class="btn btn-outline-primary" name="form_add_friend">Thêm bạn</button>
                        </form>
                    <?php
                    } else { ?>
                        <div class="btn btn-outline-primary disabled">Đã là bạn bè</div>
                    <?php
                    }
                }
            ?>
        </div>
        <?php
            $posts = getPostById($userCur['id']);
            if ($posts) {
        ?>
            <div class="posts">
                <?php
                    foreach ($posts as $post) {
                ?>
                    <div class="card mt-3">
                        <div class="card-body row">
                            <div class="col-9">
                                <a href="./wall.php?id=<?php echo $userCur['id'] ?>" class="card-title"><?php echo $userCur['displayname'] ?></a>
                                <h6 class="card-sub_title"><?php echo $post['created_at'] ?></h6>
                                <p class="card-text"><?php echo $post['content'] ?></p>
                            </div>
                            <div class="col-3 pull-items-right">
                                <a href="./wall.php?id=<?php echo $userCur['id'] ?>" class="avatar avatar--small rounded-circle dp--inline-block" style="background-image:url('./assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?> 
            <h5>Hiện chưa có trạng thái nào được đăng tải. :(</h5>
        <?php } ?>
    </div>
    <?php } else {
    header('Location: ./login.php');
    exit();
} ?>

<?php include '../layouts/footer.php' ?>