<?php
    require_once '../config/init.php';
    $page = 'Đăng trạng thái';
?>

<?php include '../layouts/header.php' ?>

<?php if (isset($_SESSION['userId'])) {
        $userCur = getUserById($_SESSION['userId']);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $content = $_POST['content_post'];            
            
            if ($_FILES['imagesPost']['name'][0] == "" && $content == "") { ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Bạn chưa nhập trạng thái!!
                </div>
            <?php
            } else {
                $queryPost = $db->prepare("INSERT INTO posts(user_id, content) VALUES(?, ?)");
                $queryPost->execute(array($userCur['id'], $content));
                $postCur = $db->lastInsertId();

                if ($_FILES['imagesPost']['name'][0] != "") {
                    $files = $_FILES['imagesPost'];
                    
                    for ($i = 0; $i < count($files['name']); $i++) {
                        $fileName = $files['name'][$i];
                        $fileTemp = $files['tmp_name'][$i];
                        
                        $queryIamge = $db->prepare("INSERT INTO images_post(post_id, image) VALUES(?, ?)");
                        $queryIamge->execute(array($postCur, $fileName));
                        $result = move_uploaded_file($fileTemp, '../assets/images/images-post/' . $fileName);
                    }
                }

                showAlertSuccess("Trạng thái được đăng tải thành công.");
            }
        }
    ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="align-center my-2">
            <div class="avatar avatar--super-small rounded-circle dp--inline-block" style="background-image:url('../assets/images/avatars/<?php echo $userCur['avatar'] ?>')"></div>
            <label for="content_post">Bạn đang nghĩ gì?</label>
        </div>
        <div class="mb-3">
            <textarea class="form-control" id="content_post" name="content_post" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <input class="form-control" type="file" id="images_post" name="imagesPost[]" multiple accept="image/png, image/jpeg">
        </div>
        <button type="submit" class="btn btn-primary float-end" name="form_post_click">Đăng</button>
    </form>
<?php } else { ?>
    <h3>Bạn chưa đăng nhập. Không thể tiếp tục hành động này!!!!</h3>
<?php } ?>

<?php include '../layouts/footer.php' ?>