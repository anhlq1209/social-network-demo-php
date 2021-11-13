<?php
    require_once '../config/init.php';
    $page = 'Bài đăng';
?>

<?php include '../layouts/header.php' ?>

<?php
if (isset($_SESSION['userId'])) {
    $userCur = getUserById($_SESSION['userId']);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
    }
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['post'])) {
            $post = getPostById($_GET['post']);
            $p_user = getUserById($post['user_id']);
            $liked = isUserLikePost($userCur['id'], $post['id']);
            ?>
            <div class="card mt-3">
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
                                <img src="../assets/images/images-post/<?php echo $image['image']; ?>" alt="" style="max-width: 100%; width: auto; max-height: 650px; height: auto;">
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
                                <input type="hidden" name="page" value="post">
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
            <div class="card mt-1">
                <div class="card-body">
                    <form action="/handle-post-actions.php" method="post" class="mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" name="content" placeholder="Bình luận của bạn">
                            <input type="hidden" name="action" value="comment">
                            <input type="hidden" name="page" value="post">
                            <input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
                            <input type="hidden" name="user_id" value="<?php echo $userCur['id'] ?>">
                            <button class="btn btn-outline-dark" type="submit" id="button-addon2">Bình luận</button>
                        </div>
                    </form>
                    <?php
                    if (getCommentByPost($post['id'])) {
                        $comments = getCommentByPost($post['id']);
                        foreach ($comments as $comment) {
                            $cm_user = getUserById($comment['user_id']);
                            ?>
                            <div class="card mt-1">
                                <div class="card-body my-col">
                                    <div class="my-row align-center">
                                        <a href="./user/wall.php?id=<?php echo $cm_user['id'] ?>" class="avatar avatar--super-small rounded-circle dp--inline-block" style="background-image:url('/assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></a>
                                        <div class="my-col ms-2">
                                            <a href="/user/wall.php?id=<?php echo $cm_user['id'] ?>" class="card-title mp-0"><?php echo $cm_user['displayname'] ?></a>
                                            <h6 class="card-sub_title mp-0"><?php echo $comment['created_at'] ?></h6>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="my-col">
                                        <p class="card-text"><?php echo $comment['content'] ?></p>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php
        }
    }
    ?>
<?php } else { ?>
    <h3>Bạn chưa đăng nhập. Không thể tiếp tục hành động này!!!!</h3>
<?php } ?>

<?php include '../layouts/footer.php' ?>