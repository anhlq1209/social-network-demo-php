<?php
    require_once '../config/init.php';
    $page = 'Trang chủ';
?>

<?php include '../layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) {
    $userCur = getUserById($_SESSION['userId']); ?>
    <div class="content">
        <?php
            $friends = getFriendsById($userCur['id']);
            if ($friends) {
        ?>
            <div class="posts">
                <?php
                    foreach ($friends as $friend) {
                        $f_user = getUserById($friend['friend_id']);
                ?>
                    <div class="card mt-3">
                        <div class="card-body row">
                            <div class="col-3 pull-items-right">
                                <a href="./wall?id=<?php echo $f_user['id'] ?>" class="avatar avatar--small rounded-circle dp--inline-block" style="background-image:url('./assets/images/avatars/<?php echo $f_user['avatar'] ?>')"></a>
                            </div>
                            <div class="col-9">
                                <a href="./wall.php?id=<?php echo $f_user['id'] ?>" class="card-title"><?php echo $f_user['displayname'] ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?> 
            <h5>Danh sách bạn bè rỗng</h5>
        <?php } ?>
    </div>
<?php } else {
    header('Location: ./login.php');
    exit();
} ?>

<?php include '../layouts/footer.php' ?>