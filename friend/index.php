<?php
    require_once '../config/init.php';
    $page = 'Danh sách bạn bè';
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
                        <div class="card-body my-row space-between">
                            <div class="align-center">
                                <a class="card-avatar card-avatar--small rounded-circle me-2" href="/user/wall.php?id=<?php echo $f_user['id'] ?>" class="avatar avatar--small rounded-circle dp--inline-block" style="background-image:url('/assets/images/avatars/<?php echo $f_user['avatar'] ?>')"></a>
                                <a class="card-name" href="/user/wall.php?id=<?php echo $f_user['id'] ?>" class="card-title"><?php echo $f_user['displayname'] ?></a>
                            </div>
                            <div class="pull-right my-col justify-align-center">
                                <form class="align-center" method="POST" action="/friend/friend-req-handle.php">
                                    <input type="hidden" name="handle_name" value="unfriend">
                                    <input type="hidden" name="user_id" value="<?php echo $userCur['id'] ?>">
                                    <input type="hidden" name="friend_id" value="<?php echo $f_user['id'] ?>">
                                    <button type="submit" class="btn btn-outline-primary" name="form_unfriend">
                                        <i class="fas fa-user-check"></i>
                                        Bạn bè
                                    </button>
                                </form>
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
    header('Location: login.php');
    exit();
} ?>

<?php include '../layouts/footer.php' ?>