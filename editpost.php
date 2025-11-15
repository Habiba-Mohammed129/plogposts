<?php
// admin/editpost.php
require_once '../config.php';
include './includes/header.php';
include './includes/sidebar.php';

// Initialize
$message = '';
$message_type = '';

// Get post id
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($post_id <= 0) {
    echo "<script>window.location.href = 'posts.php';</script>";
    exit();
}

// Fetch post
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "<script>window.location.href = 'posts.php';</script>";
    exit();
}

// Fetch categories for select
$catStmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_post'])) {
    // Collect input & sanitize
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['draft', 'published']) ? $_POST['status'] : 'draft';

    // Validation
    if ($title === '' || $content === '') {
        $message = "Title and content are required!";
        $message_type = "danger";
    } else {
        // Handle image upload (optional)
        $newImageName = $post['image']; // default keep old
        if (!empty($_FILES['image']['name'])) {
            // Basic checks (you can extend: file type, size limits, etc.)
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $originalName = basename($_FILES['image']['name']);
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $ext;
            $targetPath = $uploadDir . $safeName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image file if exists and is different
                if (!empty($post['image']) && file_exists($uploadDir . $post['image'])) {
                    @unlink($uploadDir . $post['image']);
                }
                $newImageName = $safeName;
            } else {
                $message = "Failed to upload image.";
                $message_type = "danger";
            }
        }

        // If no upload error, update DB
        if ($message_type !== 'danger') {
            $updateStmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, image = ?, category_id = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $updateStmt->execute([$title, $content, $newImageName, $category_id, $status, $post_id]);

            $message = "Post updated successfully!";
            $message_type = "success";

            // redirect back to posts list after short delay (or immediately)
            echo "<script>window.location.href = 'posts.php';</script>";
            exit();
        }
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><i class="bi bi-pencil-square"></i> Edit Post</h1>
            <a href="posts.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Posts
            </a>
        </div>

        <!-- Messages -->
        <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Blog Post</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Post Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="content" rows="8" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                    </div>

                    <div class="row">
                        <!-- Category -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $post['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="draft" <?php echo ($post['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo ($post['status'] === 'published') ? 'selected' : ''; ?>>Published</option>
                            </select>
                        </div>

                        <!-- Image -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Featured Image (optional)</label>
                            <input type="file" class="form-control" name="image">
                            <?php if (!empty($post['image'])): ?>
                                <div class="mt-2">
                                    <small>Current image:</small><br>
                                    <img src="../uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="current image" width="150" class="rounded">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" name="update_post" class="btn btn-warning w-100">
                        <i class="bi bi-pencil-square"></i> Update Post
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include './includes/footer.php'; ?>
