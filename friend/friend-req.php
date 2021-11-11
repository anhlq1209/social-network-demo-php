<?php
    require_once '../config/init.php';
    $page = 'Danh sách bạn bè';
?>

<?php include '../layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) {
    $userMain = getUserById($_SESSION['userId']); ?>
    <div class="content">
        <?php
            $list_req = getFriendRequest($userMain['id']);
            if ($list_req) {
        ?>
            <div class="friend_req">
                <?php
                    foreach ($list_req as $req) {
                        $fr_user = getUserById($req['user_id']);

                ?>
                    <div class="card mt-3">
                        <div class="card-body my-row">
                            <div class="align-center">
                                <a class="card-avatar card-avatar--small me-2" href="/user/wall.php?id=<?php echo $fr_user['id'] ?>" class="avatar avatar--small rounded-circle dp--inline-block" style="background-image:url('/assets/images/avatars/<?php echo $fr_user['avatar'] ?>')"></a>
                                <a class="card-name" href="/user/wall.php?id=<?php echo $fr_user['id'] ?>" class="card-title"><?php echo $fr_user['displayname'] ?></a>
                            </div>
                            <div class="pull-right my-col">
                                <form class="align-center" method="POST" action="/friend/friend-req-handle.php">
                                    <input type="hidden" name="handle_name" value="accept_friend_request">
                                    <input type="hidden" name="user_id" value="<?php echo $userMain['id'] ?>">
                                    <input type="hidden" name="friend_id" value="<?php echo $fr_user['id'] ?>">
                                    <button type="submit" class="btn btn-outline-primary" name="form_accept_friend_request">Chấp nhận</button>
                                </form>
                                <form class="align-center" method="POST" action="/friend/friend-req-handle.php">
                                    <input type="hidden" name="handle_name" value="decline_friend_request">
                                    <input type="hidden" name="user_id" value="<?php echo $userMain['id'] ?>">
                                    <input type="hidden" name="friend_id" value="<?php echo $fr_user['id'] ?>">
                                    <button type="submit" class="btn btn-outline-secondary" name="form_decline_friend_request">Từ chối</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?> 
            <h5>Không có lời mời kết bạn</h5>
        <?php } ?>
    </div>
<?php } else {
    header('Location: /login.php');
    exit();
} ?>

<?php include '../layouts/footer.php' ?>