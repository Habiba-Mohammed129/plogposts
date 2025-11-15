<?php
require_once("./config.php");
$posts = $pdo->query("SELECT * FROM posts WHERE 
status='puplished' ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fa-solid fa-gauge"></i> My Blog
            </a>
            
        </div>
    </nav><!--end navbar-->
    <div class="container mt-4">
    <h1 class="mb-4">Latest Posts</h1>
    <?php foreach ($posts as $post): ?>
        <div class="d-flex border-bottom pb-4 mb-3">
            <?php if (!empty($post['image'])): ?> 
            <div class="flex-shrink-0 me-3"> 
                <img src="uploads/<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>" width="150" class="rounded"> 
            </div> 
            <?php endif; ?> 
             <div class="flex-grow-1"> 
                <h4><?php echo $post['title']; ?></h4> 
                <p class="text-muted mb-2"> 
                    <?php echo date('F j, Y', strtotime($post['created_at'])); ?> 
                </p> 
                <p class="mb-2"> 
                    <?php  
                    $content = strip_tags($post['content']); 
                    echo substr($content, 0, 200) . '...';  
                    ?> 
                </p>
                 <a href="posts.php?id=<?php echo $post['id']; ?>" class="btn btn outline-primary btn-sm">Read More</a> 
            </div> 
        </div> 
        <?php endforeach; ?> 
    </div>
     <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; 2025 PHP Plog Dashboared</p>
    </footer>
    <script src="./assets/js/bootstrap.bundle.js"></script>
</body>
</html>


