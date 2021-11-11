<?php
    require_once '../config/init.php';
    $page = 'Tường';
?>

<?php include '../layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) {
    $userMain = getUserById($_SESSION['userId']); 
    if (isset($_GET['id'])) {
        $userCur = getUserById($_GET['id']);
        if (!$userCur) {
            showAlertDanger("Không tìm thấy người dùng có ID: " . $_GET['id'] . "!!!");
            exit();
        }
    } else {
        $userCur = $userMain;
    } ?>
    <div class="content">
        <div class="info">
            <div class="avatar rounded-circle" style="background-image:url('/assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></div>
            <h4 class="mt-3"><?php echo $userCur['displayname'] ?></h4>
            <?php
                if ($userMain['id'] != $userCur['id']) {
                    if (!checkFriend($userMain['id'], $userCur['id'])) {
                        if (!checkRequestFriend($userMain['id'], $userCur['id'])) { ?>
                            <form method="POST" action="/friend/friend-req-handle.php">
                                <input type="hidden" name="handle_name" value="add_friend">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['userId'] ?>">
                                <input type="hidden" name="friend_id" value="<?php echo $userCur['id'] ?>">
                                <button type="submit" class="btn btn-outline-primary" name="form_add_friend">
                                    <i class="fas fa-user-plus"></i>
                                    Thêm bạn
                                </button>
                            </form>
                    <?php } else { ?>
                            <form method="POST" action="/friend/friend-req-handle.php">
                                <input type="hidden" name="handle_name" value="cancel_friend_request">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['userId'] ?>">
                                <input type="hidden" name="friend_id" value="<?php echo $userCur['id'] ?>">
                                <button type="submit" class="btn btn-outline-primary" name="form_cancel_friend_request">
                                    <i class="fas fa-user-times"></i>
                                    Hủy lời mời
                                </button>
                            </form>
                    <?php }
                    } else { ?>
                        <form method="POST" action="/friend/friend-req-handle.php">
                            <input type="hidden" name="handle_name" value="unfriend">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['userId'] ?>">
                            <input type="hidden" name="friend_id" value="<?php echo $userCur['id'] ?>">
                            <button type="submit" class="btn btn-outline-primary" name="form_unfriend">
                                <i class="fas fa-user-check"></i>
                                Đã là bạn bè
                            </button>
                        </form>
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
                                <a href="/user/wall.php?id=<?php echo $userCur['id'] ?>" class="card-title"><?php echo $userCur['displayname'] ?></a>
                                <h6 class="card-sub_title"><?php echo $post['created_at'] ?></h6>
                                <p class="card-text"><?php echo $post['content'] ?></p>
                            </div>
                            <div class="col-3 pull-items-right">
                                <a href="./user/wall.php?id=<?php echo $userCur['id'] ?>" class="avatar avatar--small rounded-circle dp--inline-block" style="background-image:url('/assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></a>
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
    header('Location: login.php');
    exit();
} ?>

<?php include '../layouts/footer.php' ?>