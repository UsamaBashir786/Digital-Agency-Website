<?php
// ============================================================
// ADMIN/BLOG-PREVIEW.PHP - Preview Blog Post
// ============================================================

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once '../config/connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// ============================================================
// GET BLOG POST DATA
// ============================================================

$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$blog_data = null;

if ($blog_id > 0) {
    $sql = "SELECT * FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog_data = $result->fetch_assoc();
    $stmt->close();
}

if (!$blog_data) {
    header('Location: blogs.php');
    exit();
}

// Increment view count
$update_views = "UPDATE blogs SET views = views + 1 WHERE id = ?";
$views_stmt = $conn->prepare($update_views);
$views_stmt->bind_param("i", $blog_id);
$views_stmt->execute();
$views_stmt->close();

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Preview: <?php echo htmlspecialchars($blog_data['title']); ?> — 4 Digi Sol</title>
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .preview-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }
        .preview-header {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .preview-header .badge {
            padding: 0.2rem 0.7rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 600;
        }
        .badge-published { background: rgba(52, 211, 153, 0.15); color: #34d399; }
        .badge-draft { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }
        .badge-featured { background: rgba(166, 241, 59, 0.15); color: #A6F13B; }
        
        .preview-content {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1.5rem;
            padding: 2.5rem;
        }
        .preview-content h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #ffffff;
        }
        .preview-content .meta {
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .preview-content .meta .author-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .preview-content .meta .author-info img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        .preview-content .featured-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
        }
        .preview-content .content {
            color: #d0d0d0;
            font-size: 1rem;
            line-height: 1.8;
        }
        .preview-content .content h2 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 1.5rem 0 0.5rem;
        }
        .preview-content .content h3 {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 600;
            margin: 1.25rem 0 0.5rem;
        }
        .preview-content .content p {
            margin-bottom: 1rem;
        }
        .preview-content .content ul, .preview-content .content ol {
            margin: 0.5rem 0 1rem 1.5rem;
        }
        .preview-content .content ul li, .preview-content .content ol li {
            margin-bottom: 0.25rem;
        }
        .preview-content .content blockquote {
            border-left: 4px solid #A6F13B;
            padding-left: 1rem;
            margin: 1rem 0;
            color: #aaa;
            font-style: italic;
        }
        .preview-content .content img {
            max-width: 100%;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        .preview-content .content code {
            background: #1a1a1a;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.9rem;
            color: #A6F13B;
        }
        .preview-content .content pre {
            background: #1a1a1a;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1rem 0;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .preview-content .content pre code {
            background: transparent;
            padding: 0;
            color: #d0d0d0;
        }
        .preview-content .tags {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .preview-content .tags .tag {
            background: rgba(166, 241, 59, 0.08);
            color: #A6F13B;
            padding: 0.2rem 0.8rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            border: 1px solid rgba(166, 241, 59, 0.1);
        }
        
        .btn-primary {
            background: #A6F13B;
            color: #0c0c0c;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            border: none;
            font-size: 0.85rem;
            transition: background 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-primary:hover { background: #8BD82E; }
        .btn-secondary {
            background: transparent;
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.2); }
        
        @media (max-width: 768px) {
            .preview-container { padding: 1rem; }
            .preview-content { padding: 1.5rem; }
            .preview-content h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

<!-- ============ PREVIEW CONTAINER ============ -->
<div class="preview-container">

    <!-- Preview Header -->
    <div class="preview-header">
        <div>
            <span class="text-xs text-gray-500">Preview Mode</span>
            <span class="badge <?php echo $blog_data['status'] === 'published' ? 'badge-published' : 'badge-draft'; ?>">
                <?php echo ucfirst($blog_data['status']); ?>
            </span>
            <?php if ($blog_data['is_featured']): ?>
            <span class="badge badge-featured">★ Featured</span>
            <?php endif; ?>
            <span class="text-xs text-gray-500 ml-2">Views: <?php echo number_format($blog_data['views']); ?></span>
        </div>
        <div class="flex gap-2">
            <a href="blog-edit.php?id=<?php echo $blog_data['id']; ?>" class="btn-primary">
                <i class='bx bx-edit'></i> Edit
            </a>
            <a href="blogs.php" class="btn-secondary">
                <i class='bx bx-arrow-back'></i> Back
            </a>
        </div>
    </div>

    <!-- Blog Content -->
    <div class="preview-content">
        
        <!-- Featured Image -->
        <?php if (!empty($blog_data['featured_image'])): ?>
        <img src="../uploads/blogs/<?php echo $blog_data['featured_image']; ?>" alt="<?php echo htmlspecialchars($blog_data['title']); ?>" class="featured-image">
        <?php endif; ?>
        
        <!-- Title -->
        <h1><?php echo htmlspecialchars($blog_data['title']); ?></h1>
        
        <!-- Meta -->
        <div class="meta">
            <div class="author-info">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($blog_data['author']); ?>&background=A6F13B&color=0c0c0c&size=32" alt="<?php echo htmlspecialchars($blog_data['author']); ?>">
                <span>By <strong><?php echo htmlspecialchars($blog_data['author']); ?></strong></span>
            </div>
            <span>•</span>
            <span><?php echo date('F d, Y', strtotime($blog_data['created_at'])); ?></span>
            <span>•</span>
            <span><?php echo htmlspecialchars($blog_data['category']); ?></span>
            <span>•</span>
            <span><i class='bx bx-time'></i> <?php echo round(str_word_count($blog_data['content']) / 200) . ' min read'; ?></span>
        </div>
        
        <!-- Excerpt -->
        <?php if (!empty($blog_data['excerpt'])): ?>
        <div class="text-gray-400 text-sm border-l-4 border-lime pl-4 py-2 mb-4 bg-[#1a1a1a] rounded-r-lg">
            <?php echo htmlspecialchars($blog_data['excerpt']); ?>
        </div>
        <?php endif; ?>
        
        <!-- Content -->
        <div class="content">
            <?php echo $blog_data['content']; ?>
        </div>
        
        <!-- Tags -->
        <?php if (!empty($blog_data['meta_keywords'])): ?>
        <div class="tags">
            <?php 
            $tags = array_map('trim', explode(',', $blog_data['meta_keywords']));
            foreach ($tags as $tag): 
            ?>
            <span class="tag">#<?php echo htmlspecialchars($tag); ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
    </div>

</div>

<!-- ============ FOOTER ACTIONS ============ -->
<div style="max-width: 900px; margin: 1rem auto 2rem; padding: 0 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
    <a href="blog-edit.php?id=<?php echo $blog_data['id']; ?>" class="btn-primary">
        <i class='bx bx-edit'></i> Edit Post
    </a>
    <a href="blogs.php" class="btn-secondary">
        <i class='bx bx-arrow-back'></i> Back to Blogs
    </a>
    <a href="../blog-details.php?slug=<?php echo $blog_data['slug']; ?>" target="_blank" class="btn-secondary">
        <i class='bx bx-link-external'></i> View on Site
    </a>
    <button onclick="window.print()" class="btn-secondary">
        <i class='bx bx-printer'></i> Print
    </button>
</div>

</body>
</html>