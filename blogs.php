<?php
// ============================================================
// BLOGS.PHP - Frontend Blog Listing Page
// ============================================================

// Start session FIRST (before ANY output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include "config/connection.php";

// ============================================================
// GET BLOGS FROM DATABASE
// ============================================================

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 9;
$offset = ($page - 1) * $per_page;

// Get featured post
$featured_sql = "SELECT * FROM blogs WHERE is_featured = 1 AND status = 'published' ORDER BY created_at DESC LIMIT 1";
$featured_result = $conn->query($featured_sql);
$featured_post = $featured_result ? $featured_result->fetch_assoc() : null;

// Build the main query for paginated blogs
$sql = "SELECT * FROM blogs WHERE status = 'published'";
$count_sql = "SELECT COUNT(*) as total FROM blogs WHERE status = 'published'";
$params = [];
$count_params = [];
$types = "";
$count_types = "";

// Add search filter
if (!empty($search)) {
    $search_param = "%$search%";
    $sql .= " AND (title LIKE ? OR content LIKE ? OR author LIKE ?)";
    $count_sql .= " AND (title LIKE ? OR content LIKE ? OR author LIKE ?)";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $count_params[] = $search_param;
    $count_params[] = $search_param;
    $count_params[] = $search_param;
    $types .= "sss";
    $count_types .= "sss";
}

// Add category filter
if (!empty($category_filter)) {
    $sql .= " AND category = ?";
    $count_sql .= " AND category = ?";
    $params[] = $category_filter;
    $count_params[] = $category_filter;
    $types .= "s";
    $count_types .= "s";
}

// Exclude featured post from regular list if it exists
if ($featured_post) {
    $sql .= " AND id != ?";
    $count_sql .= " AND id != ?";
    $params[] = $featured_post['id'];
    $count_params[] = $featured_post['id'];
    $types .= "i";
    $count_types .= "i";
}

// Get total count for pagination
$count_stmt = $conn->prepare($count_sql);
if (!empty($count_params)) {
    $count_stmt->bind_param($count_types, ...$count_params);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $per_page);
$count_stmt->close();

// Add pagination to main query
$sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;
$types .= "ii";

// Execute main query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$blogs_result = $stmt->get_result();
$stmt->close();

// Get categories for filter
$categories_sql = "SELECT DISTINCT category FROM blogs WHERE status = 'published' ORDER BY category";
$categories_result = $conn->query($categories_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/css-links.php"; ?>
    <title>Blog — 4 Digi Sol | Digital Marketing Insights</title>
    <style>
        /* Blog card styles */
        .blog-card {
            background: #1a1a1a;
            border-radius: 1rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255,255,255,0.05);
            cursor: pointer;
        }
        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border-color: rgba(163, 230, 53, 0.3);
        }
        .blog-card .tag {
            background: rgba(163, 230, 53, 0.15);
            color: #a3e635;
            font-size: 0.6rem;
            font-weight: 600;
            padding: 0.2rem 0.8rem;
            border-radius: 9999px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .category-btn {
            background: transparent;
            color: #9ca3af;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 0.4rem 1.2rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .category-btn:hover {
            border-color: rgba(163, 230, 53, 0.5);
            color: #fff;
        }
        .category-btn.active {
            background: #a3e635;
            color: #101010;
            border-color: #a3e635;
        }
        .featured-blog {
            background: #1a1a1a;
            border-radius: 1.5rem;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .pagination-btn {
            background: transparent;
            color: #9ca3af;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .pagination-btn:hover:not(.active) {
            border-color: rgba(163, 230, 53, 0.5);
            color: #fff;
        }
        .pagination-btn.active {
            background: #a3e635;
            color: #101010;
            border-color: #a3e635;
        }
        .lime {
            color: #a3e635;
        }
        .bg-lime {
            background-color: #a3e635;
        }
        .blog-card .read-more-link {
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        .blog-card:hover .read-more-link {
            opacity: 1;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body>

<!-- ============ NAVBAR ============ -->
<?php include "includes/navbar.php"; ?>

<!-- ============ HERO ============ -->
<section class="relative w-full">
  <div class="bg-white text-[#101010] rounded-b-[2rem] sm:rounded-b-[3rem] overflow-hidden">
    <div class="pt-[70px] sm:pt-[84px]"></div>
    <div class="relative px-4 sm:px-8 lg:px-12 pt-8 sm:pt-12 pb-8 sm:pb-12 max-w-[1400px] mx-auto">
      <div class="text-center max-w-3xl mx-auto">
        <span class="inline-block bg-lime text-[#101010] text-[10px] font-bold tracking-widest px-4 py-1.5 rounded-full">BLOG</span>
        <h1 class="text-3xl sm:text-4xl md:text-[3.2rem] font-bold leading-[1.15] mt-3">
          Insights & <span class="bg-lime px-3 py-1 rounded-xl inline-block">Strategies</span>
        </h1>
        <p class="text-gray-600 text-sm sm:text-base mt-4 max-w-md mx-auto">Expert tips, SEO strategies, and digital marketing insights to help your business grow.</p>
        
        <!-- Search Bar -->
        <div class="max-w-md mx-auto mt-6">
            <form action="blogs.php" method="GET" class="relative">
                <input type="text" 
                       name="search" 
                       value="<?php echo htmlspecialchars($search); ?>"
                       placeholder="Search articles..." 
                       class="w-full bg-[#f5f5f5] border border-gray-200 rounded-full px-5 py-3 pr-12 text-sm outline-none focus:border-lime focus:ring-2 focus:ring-lime/20 transition">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-lime text-[#101010] rounded-full px-4 py-1.5 text-sm font-medium hover:brightness-95 transition">
                    <i class='bx bx-search'></i>
                </button>
                <?php if (!empty($search)): ?>
                <a href="blogs.php" class="absolute right-16 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class='bx bx-x'></i>
                </a>
                <?php endif; ?>
            </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ FEATURED POST ============ -->
<?php if ($featured_post): ?>
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="featured-blog" onclick="navigateToBlog('<?php echo $featured_post['slug']; ?>')" style="cursor:pointer;">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
      <div class="aspect-[16/10] md:aspect-auto overflow-hidden">
        <img src="<?php 
            $img_path = '../uploads/blogs/' . $featured_post['featured_image'];
            echo (!empty($featured_post['featured_image']) && file_exists($img_path)) 
                ? $img_path 
                : 'https://picsum.photos/seed/featured-blog-' . $featured_post['id'] . '/800/500'; 
        ?>" alt="<?php echo htmlspecialchars($featured_post['title']); ?>" class="w-full h-full object-cover" loading="lazy">
      </div>
      <div class="p-6 sm:p-8 flex flex-col justify-center">
        <span class="tag inline-block w-fit mb-3 bg-lime text-[#101010] px-3 py-1 rounded-full text-xs font-bold">Featured</span>
        <span class="text-xs text-gray-400"><?php echo date('F d, Y', strtotime($featured_post['created_at'])); ?></span>
        <h2 class="text-xl sm:text-2xl font-bold mt-2 text-white"><?php echo htmlspecialchars($featured_post['title']); ?></h2>
        <p class="text-gray-400 text-sm mt-2 leading-relaxed"><?php echo htmlspecialchars($featured_post['excerpt']); ?></p>
        <div class="flex items-center gap-3 mt-4">
          <img src="<?php 
            echo !empty($featured_post['author_image']) && file_exists('../uploads/authors/' . $featured_post['author_image'])
                ? '../uploads/authors/' . $featured_post['author_image']
                : 'https://randomuser.me/api/portraits/men/32.jpg'; 
          ?>" class="w-8 h-8 rounded-full object-cover" alt="Author" loading="lazy">
          <div>
            <p class="text-xs font-medium text-white"><?php echo htmlspecialchars($featured_post['author']); ?></p>
            <p class="text-[10px] text-gray-500"><?php echo htmlspecialchars($featured_post['category']); ?></p>
          </div>
        </div>
        <div class="inline-flex items-center gap-2 text-lime text-sm font-semibold mt-4 read-more-link">
            Read Full Article <i class='bx bx-arrow-right'></i>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ CATEGORIES ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="flex flex-wrap justify-center gap-2" id="categoryFilters">
    <button class="category-btn active" data-filter="all">All</button>
    <?php 
    $categories_result->data_seek(0);
    while ($cat = $categories_result->fetch_assoc()): 
    ?>
    <button class="category-btn" data-filter="<?php echo strtolower(str_replace(' ', '-', $cat['category'])); ?>">
        <?php echo htmlspecialchars($cat['category']); ?>
    </button>
    <?php endwhile; ?>
  </div>
</section>

<!-- ============ BLOG GRID ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-6 sm:mt-8">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="blogGrid">
    
    <?php if ($blogs_result && $blogs_result->num_rows > 0): ?>
      <?php while ($blog = $blogs_result->fetch_assoc()): ?>
      <article class="blog-card" 
               data-category="<?php echo strtolower(str_replace(' ', '-', $blog['category'])); ?>"
               onclick="navigateToBlog('<?php echo $blog['slug']; ?>')">
        <div class="aspect-[16/10] overflow-hidden">
          <img src="<?php 
              $blog_img = '../uploads/blogs/' . $blog['featured_image'];
              echo (!empty($blog['featured_image']) && file_exists($blog_img)) 
                  ? $blog_img 
                  : 'https://picsum.photos/seed/blog-' . $blog['id'] . '/600/400'; 
          ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="p-4">
          <span class="tag"><?php echo htmlspecialchars($blog['category']); ?></span>
          <span class="text-[10px] text-gray-500 ml-2"><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
          <h3 class="text-base font-bold mt-2 text-white line-clamp-2"><?php echo htmlspecialchars($blog['title']); ?></h3>
          <p class="text-gray-400 text-xs mt-1 leading-relaxed line-clamp-3"><?php echo htmlspecialchars($blog['excerpt']); ?></p>
          <div class="inline-flex items-center gap-1 text-lime text-xs font-semibold mt-3 read-more-link">
              Read More <i class='bx bx-arrow-right'></i>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-span-full text-center text-gray-500 py-12">
        <i class='bx bx-news text-4xl block mb-3'></i>
        <p class="text-lg">No blog posts found.</p>
        <?php if (!empty($search)): ?>
        <p class="text-sm">Try adjusting your search terms.</p>
        <a href="blogs.php" class="inline-block mt-4 text-lime hover:underline">Clear search</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>

  <!-- ============ PAGINATION ============ -->
  <?php if ($total_pages > 1): ?>
  <div class="flex flex-wrap justify-center items-center gap-2 mt-8">
    <?php if ($page > 1): ?>
      <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" class="pagination-btn">
          <i class='bx bx-chevron-left'></i> Previous
      </a>
    <?php endif; ?>
    
    <?php 
    $start_page = max(1, $page - 2);
    $end_page = min($total_pages, $page + 2);
    
    if ($start_page > 1): ?>
        <a href="?page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" class="pagination-btn">1</a>
        <?php if ($start_page > 2): ?>
            <span class="text-gray-500">...</span>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
      <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" class="pagination-btn <?php echo $i == $page ? 'active' : ''; ?>">
          <?php echo $i; ?>
      </a>
    <?php endfor; ?>
    
    <?php if ($end_page < $total_pages): ?>
        <?php if ($end_page < $total_pages - 1): ?>
            <span class="text-gray-500">...</span>
        <?php endif; ?>
        <a href="?page=<?php echo $total_pages; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" class="pagination-btn"><?php echo $total_pages; ?></a>
    <?php endif; ?>
    
    <?php if ($page < $total_pages): ?>
      <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($category_filter) ? '&category=' . urlencode($category_filter) : ''; ?>" class="pagination-btn">
          Next <i class='bx bx-chevron-right'></i>
      </a>
    <?php endif; ?>
  </div>
  <?php endif; ?>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="max-w-[1180px] mx-auto px-4 sm:px-6 mt-10 sm:mt-16">
  <div class="bg-[#141414] border border-white/5 rounded-[2rem] p-6 sm:p-10 text-center">
    <i class='bx bx-envelope text-3xl lime mb-3'></i>
    <h2 class="text-2xl sm:text-3xl font-bold text-white">Subscribe to Our Newsletter</h2>
    <p class="text-gray-400 text-sm max-w-md mx-auto mt-2">Get the latest SEO tips, strategies, and insights delivered straight to your inbox.</p>
    <form class="flex flex-wrap justify-center gap-3 mt-4 max-w-md mx-auto" onsubmit="handleNewsletter(event)">
      <input type="email" id="newsletterEmail" required placeholder="Enter your email" class="flex-1 min-w-[200px] bg-[#0c0c0c] border border-white/10 rounded-full px-4 py-3 text-sm outline-none placeholder:text-gray-500 text-white focus:border-lime">
      <button type="submit" class="bg-lime text-[#101010] font-semibold rounded-full px-6 py-3 text-sm whitespace-nowrap hover:brightness-95 transition">Subscribe</button>
    </form>
    <div id="newsletterMessage" class="mt-3 text-sm hidden"></div>
  </div>
</section>

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
// CATEGORY FILTER (Client-side)
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    const categoryBtns = document.querySelectorAll('.category-btn');
    const blogCards = document.querySelectorAll('.blog-card');
    
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    
    // If category parameter exists, activate that button
    if (categoryParam) {
        const categoryKey = categoryParam.toLowerCase().replace(/ /g, '-');
        categoryBtns.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.filter === categoryKey) {
                btn.classList.add('active');
            }
        });
        filterBlogs(categoryKey);
    }
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            filterBlogs(filter);
            
            // Update URL with category parameter
            const url = new URL(window.location);
            if (filter === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', filter.replace(/-/g, ' '));
            }
            window.history.pushState({}, '', url);
        });
    });
    
    function filterBlogs(filter) {
        blogCards.forEach(card => {
            const categories = card.dataset.category.split(' ');
            if (filter === 'all' || categories.includes(filter)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
});

// ============================================================
// NEWSLETTER SUBSCRIPTION
// ============================================================
function handleNewsletter(e) {
    e.preventDefault();
    const email = document.getElementById('newsletterEmail').value;
    const messageDiv = document.getElementById('newsletterMessage');
    
    if (!email) {
        showNewsletterMessage('Please enter your email address.', 'error');
        return;
    }
    
    // Simulate API call
    messageDiv.classList.remove('hidden');
    messageDiv.textContent = 'Subscribing...';
    messageDiv.style.color = '#9ca3af';
    
    setTimeout(() => {
        showNewsletterMessage('✅ Thanks for subscribing! Check your inbox.', 'success');
        document.getElementById('newsletterEmail').value = '';
    }, 1500);
}

function showNewsletterMessage(message, type) {
    const messageDiv = document.getElementById('newsletterMessage');
    messageDiv.classList.remove('hidden');
    messageDiv.textContent = message;
    messageDiv.style.color = type === 'success' ? '#a3e635' : '#ef4444';
}

// ============================================================
// PREVENT CARD CLICK WHEN CLICKING ON INTERACTIVE ELEMENTS
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.blog-card, .featured-blog').forEach(card => {
        card.addEventListener('click', function(e) {
            // If the click was on a button or link inside the card, don't navigate
            if (e.target.closest('button') || e.target.closest('a') || e.target.closest('.category-btn')) {
                e.stopPropagation();
                return;
            }
        });
    });
});

// ============================================================
// KEYBOARD NAVIGATION (Enter/Space on cards)
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.blog-card, .featured-blog').forEach(card => {
        card.setAttribute('tabindex', '0');
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
});

// ============================================================
// SMOOTH SCROLL TO TOP ON PAGINATION
// ============================================================
document.querySelectorAll('.pagination-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        // Don't prevent default for pagination links
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>

</body>
</html>