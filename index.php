<?php
    require_once 'config/init.php';
    $page = 'Trang chủ';
?>

<?php include 'layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) {
    $userCur = getUserById($_SESSION['userId']); ?>
    <h3 class="mt-2">Chào mừng <?php echo $userCur['displayname'] ?> đã đăng nhập!</h3>
    <div class="content">
        <?php
            // $posts = getPostForUser($userCur['id']);
            $posts = getPostAll();
            if ($posts) {
        ?>
            <div class="posts">
                <?php
                    foreach ($posts as $post) {
                        $p_user = getUserById($post['user_id']);
                ?>
                    <div class="card mt-3">
                        <div class="card-body row">
                            <div class="col-9">
                                <a href="./wall.php?id=<?php echo $p_user['id'] ?>" class="card-title"><?php echo $p_user['displayname'] ?></a>
                                <h6 class="card-sub_title"><?php echo $post['created_at'] ?></h6>
                                <p class="card-text"><?php echo $post['content'] ?></p>
                            </div>
                            <div class="col-3 pull-items-right">
                                <a href="./wall?id=<?php echo $p_user['id'] ?>" class="avatar avatar--small rounded-circle dp--inline-block" style="background-image:url('./assets/images/avatars/<?php echo $p_user['avatar'] ?>')"></a>
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

<?php include 'layouts/footer.php' ?>