<?php
// ============================================================
// BLOG-DETAILS.PHP - Single Blog Post Page
// ============================================================

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include "config/connection.php";

// Get blog slug from URL
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

// Initialize variables
$blog = null;
$not_found = true;
$related_result = null;

// If slug is provided, fetch the blog
if (!empty($slug)) {
    // Get blog post
    $sql = "SELECT * FROM blogs WHERE slug = ? AND status = 'published'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
        $not_found = false;
        
        // Update view count
        $update_sql = "UPDATE blogs SET views = views + 1 WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $blog['id']);
        $update_stmt->execute();
        $update_stmt->close();

        // Get related posts
        $related_sql = "SELECT * FROM blogs WHERE category = ? AND id != ? AND status = 'published' ORDER BY created_at DESC LIMIT 3";
        $related_stmt = $conn->prepare($related_sql);
        $related_stmt->bind_param("si", $blog['category'], $blog['id']);
        $related_stmt->execute();
        $related_result = $related_stmt->get_result();
        $related_stmt->close();
    }
    $stmt->close();
}

// If blog not found, serve 404 page
if ($not_found) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/css-links.php"; ?>
    <?php if ($not_found): ?>
    <title>Blog Not Found — 4 Digi Sol</title>
    <?php else: ?>
    <title><?php echo htmlspecialchars($blog['meta_title'] ?: $blog['title']); ?> — 4 Digi Sol</title>
    <?php if ($blog['meta_description']): ?>
    <meta name="description" content="<?php echo htmlspecialchars($blog['meta_description']); ?>">
    <?php endif; ?>
    <?php endif; ?>
    <style>
        .blog-content h2 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        .blog-content h3 {
            font-size: 1.4rem;
            font-weight: bold;
            margin-top: 1.5rem;
            margin-bottom: 0.8rem;
        }
        .blog-content p {
            margin-bottom: 1.2rem;
            line-height: 1.8;
            color: #d1d5db;
        }
        .blog-content ul, .blog-content ol {
            margin: 1rem 0 1.5rem 1.5rem;
            color: #d1d5db;
        }
        .blog-content li {
            margin-bottom: 0.5rem;
        }
        .blog-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 1.5rem 0;
        }
        .blog-content a {
            color: #a3e635;
            text-decoration: underline;
        }
        .blog-content blockquote {
            border-left: 4px solid #a3e635;
            padding-left: 1.5rem;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-style: italic;
        }
        .blog-content code {
            background: #1f2937;
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.9rem;
            color: #a3e635;
        }
        .blog-content pre {
            background: #1f2937;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .blog-content pre code {
            background: transparent;
            padding: 0;
            color: #e5e7eb;
        }
        .related-card {
            background: #1a1a1a;
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255,255,255,0.05);
            cursor: pointer;
        }
        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border-color: rgba(163, 230, 53, 0.3);
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #9ca3af;
            transition: color 0.3s ease;
        }
        .back-button:hover {
            color: #a3e635;
        }
    </style>
</head>
<body>

<?php include "includes/navbar.php"; ?>

<!-- ============ 404 ERROR PAGE ============ -->
<?php if ($not_found): ?>
<section class="relative w-full min-h-[60vh] flex items-center justify-center">
    <div class="text-center px-4">
        <h1 class="text-6xl sm:text-8xl font-bold text-lime">404</h1>
        <h2 class="text-2xl sm:text-3xl font-bold mt-4 text-white">Blog Post Not Found</h2>
        <p class="text-gray-400 mt-2">The blog post you're looking for doesn't exist or has been removed.</p>
        <a href="blogs.php" class="inline-flex items-center gap-2 mt-6 bg-lime text-[#101010] font-semibold px-6 py-3 rounded-full hover:brightness-95 transition">
            <i class='bx bx-arrow-back'></i> Back to Blogs
        </a>
    </div>
</section>
<?php else: ?>

<!-- ============ BLOG HEADER ============ -->
<section class="relative w-full">
  <div class="bg-white text-[#101010] rounded-b-[2rem] sm:rounded-b-[3rem] overflow-hidden">
    <div class="pt-[70px] sm:pt-[84px]"></div>
    <div class="relative px-4 sm:px-8 lg:px-12 pt-8 sm:pt-12 pb-8 sm:pb-12 max-w-[1400px] mx-auto">
      <div class="max-w-3xl mx-auto">
        <!-- Back Button -->
        <a href="blogs.php" class="back-button text-sm mb-4 inline-flex items-center gap-2">
            <i class='bx bx-arrow-back'></i> Back to Blogs
        </a>
        <div class="text-center">
            <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full"><?php echo htmlspecialchars($blog['category']); ?></span>
            <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3 text-[#101010]">
                <?php echo htmlspecialchars($blog['title']); ?>
            </h1>
            <div class="flex items-center justify-center gap-2 text-sm text-gray-500 mt-4 flex-wrap">
                <span>By <?php echo htmlspecialchars($blog['author']); ?></span>
                <span>•</span>
                <span><?php echo date('F d, Y', strtotime($blog['created_at'])); ?></span>
                <span>•</span>
                <span><?php echo number_format($blog['views']); ?> views</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ BLOG CONTENT ============ -->
<section class="max-w-[800px] mx-auto px-4 sm:px-6 py-8">
  <?php if ($blog['featured_image']): ?>
  <div class="aspect-[16/9] rounded-2xl overflow-hidden mb-8">
    <img src="<?php 
        $image_path = '../uploads/blogs/' . $blog['featured_image'];
        echo file_exists($image_path) ? $image_path : 'https://picsum.photos/seed/blog-detail/800/450'; 
    ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="w-full h-full object-cover">
  </div>
  <?php endif; ?>
  
  <div class="blog-content">
    <?php echo $blog['content']; ?>
  </div>
  
  <?php if ($blog['tags']): ?>
  <div class="flex flex-wrap gap-2 mt-8 pt-8 border-t border-white/10">
    <?php foreach (explode(',', $blog['tags']) as $tag): ?>
    <span class="text-xs bg-white/5 px-3 py-1 rounded-full text-gray-400">#<?php echo trim(htmlspecialchars($tag)); ?></span>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<!-- ============ RELATED POSTS ============ -->
<?php if (isset($related_result) && $related_result->num_rows > 0): ?>
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 py-8">
  <h2 class="text-2xl font-bold mb-6 text-white">Related Posts</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php while ($related = $related_result->fetch_assoc()): ?>
    <div class="related-card" onclick="navigateToBlog('<?php echo $related['slug']; ?>')">
      <div class="aspect-[16/10] overflow-hidden">
        <img src="<?php 
            $rel_image = '../uploads/blogs/' . $related['featured_image'];
            echo ($related['featured_image'] && file_exists($rel_image)) ? $rel_image : 'https://picsum.photos/seed/related-' . $related['id'] . '/600/400'; 
        ?>" alt="<?php echo htmlspecialchars($related['title']); ?>" class="w-full h-full object-cover">
      </div>
      <div class="p-4">
        <h3 class="text-base font-bold text-white"><?php echo htmlspecialchars($related['title']); ?></h3>
        <p class="text-gray-400 text-xs mt-1"><?php echo date('M d, Y', strtotime($related['created_at'])); ?></p>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</section>
<?php endif; ?>

<?php endif; ?>

<!-- ============ FOOTER ============ -->
<?php include "includes/footer.php"; ?>
<?php include "includes/js-links.php"; ?>

<script>
// ============================================================
// NAVIGATE TO BLOG DETAILS
// ============================================================
function navigateToBlog(slug) {
    if (slug) {
        window.location.href = 'blog-details.php?slug=' + encodeURIComponent(slug);
    }
}

// ============================================================
// KEYBOARD NAVIGATION FOR RELATED CARDS
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.related-card').forEach(card => {
        card.setAttribute('tabindex', '0');
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
});
</script>

</body>
</html>