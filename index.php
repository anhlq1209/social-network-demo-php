<?php
    require_once 'config/init.php';
    $page = 'Trang chủ';
?>

<?php include 'layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) {
    $userCur = getUserById($_SESSION['userId']); ?>
    <h3 id="h333" class="mt-2">Chào mừng <?php echo $userCur['displayname'] ?> đã đăng nhập!</h3>
    <div class="content">
        <?php
            $posts = getPostAll();
            if ($posts) {
        ?>
            <div class="posts">
                <?php
                    foreach ($posts as $post) {
                        $p_user = getUserById($post['user_id']);
                        $liked = isUserLikePost($userCur['id'], $post['id']);
                ?>
                    <div id="<?php echo $post['id'] ?>" class="card mt-3">
                        <div class="card-body row">
                            <div class="col-9">
                                <a href="/user/wall.php?id=<?php echo $p_user['id'] ?>" class="card-title"><?php echo $p_user['displayname'] ?></a>
                                <h6 class="card-sub_title"><?php echo $post['created_at'] ?></h6>
                                <p class="card-text"><?php echo $post['content'] ?></p>
                            </div>
                            <div class="col-3 pull-items-right">
                                <a href="/user/wall?id=<?php echo $p_user['id'] ?>" class="avatar avatar--small rounded-circle dp--inline-block" style="background-image:url('/assets/images/avatars/<?php echo $p_user['avatar'] ?>')"></a>
                            </div>
                            <?php
                                if (getImagesByPost($post['id'])){
                                    $images = getImagesByPost($post['id']);
                                    foreach ($images as $image) { ?>
                                    <div class="col-12 justify-center bg-post-image my-1">
                                        <img src="./assets/images/images-post/<?php echo $image['image']; ?>" alt="" style="max-width: 100%; width: auto; max-height: 500px; height: auto;">
                                    </div>
                                    <?php
                                    }
                                } ?>
                            <div class="col-12 row">
                                <div class="col-6 pull-items-left">
                                    <span class="likes"><?php echo $post['count_likes'] ?></span>
                                </div>
                                <div class="col-6  pull-items-right">
                                    <span class="comments"><?php echo $post['count_comments'] ?> Bình luận</span>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 row">
                                <div class="col-4 justify-align-center">
                                    <form action="/handle-post-actions.php" method="post">
                                        <input type="hidden" name="action" value="<?php echo $liked ? "unlike" : "like" ?>">
                                        <input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $userCur['id'] ?>">
                                        <input type="hidden" name="page" value="index">
                                        <button type="submit" class="btn-none">
                                            <i class="<?php echo $liked ? "fas" : "far" ?> fa-thumbs-up font-size-25 post-icon"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-4 justify-align-center">
                                    <a href="/user/post.php?post=<?php echo $post['id'] ?>" class="a-none">
                                        <i class="far fa-comment font-size-25 post-icon"></i>
                                    </a>
                                </div>
                                <div class="col-4 justify-align-center">
                                    <i class="far fa-share-square font-size-25 post-icon"></i>
                                </div>
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

<script>
    const likes = document.getElementsByClassName('likes');
    const likesQuery = document.querySelector('.likes');
    console.log('1: ',likes, '2: ', likesQuery);
    var cookie = document.cookie.split('; ');
    console.log(cookie);
</script>

<?php include 'layouts/footer.php' ?>