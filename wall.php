<?php
    require_once 'init.php';
    $page = 'Tường';
?>

<?php include 'header.php' ?>

<?php if (isset($_SESSION['userId'])) {
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
                                <h6 class="card-sub_title"><?php echo $post['createAt'] ?></h6>
                                <p class="card-text"><?php echo $post['content'] ?></p>
                            </div>
                            <div class="col-3 pull-items-right">
                                <a href="./wall?id=<?php echo $userCur['id'] ?>" class="avatar avatar--small rounded-circle dp--inline-block" style="background-image:url('./assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></a>
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

<?php include 'footer.php' ?>