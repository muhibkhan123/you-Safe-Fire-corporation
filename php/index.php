<?php
session_start();

// --- CONFIGURATION ---
$dataFile = 'data.json';
$uploadDir = 'uploads/';
$allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// --- 1. DEFAULT DATA STRUCTURE ---
$defaultData = [
    "settings" => [
        "id" => "1",
        "siteTitle" => "Muhib Ullah",
        "authorName" => "Muhib Ullah",
        "jobTitles" => ["Computer Professional", "Developer", "Graphic Designer", "Automation Specialist"],
        "footerText" => "© 2026 Muhib Ullah. All Rights Reserved.",
        "seoKeywords" => "Muhib Ullah, Bannu, Computer Professional, Developer, Graphic Designer, Automation, Python",
        "socialLinks" => ["email" => "muhib7196@gmail.com", "phone" => "0334-3737061", "facebook" => "", "github" => "", "linkedin" => "", "twitter" => ""],
        "faviconUrl" => "images/favicon.ico",
        "logoUrl" => "",
        "heroImageUrl" => ""
    ],
    "auth" => [
        "username" => "Admin",
        // Default password is "admin123" (will be hashed on first run)
        "password_hash" => "",
        "email" => "muhib7196@gmail.com"
    ],
    "about" => [
        "bio" => "A passionate computer enthusiast seeking a position in an innovative and dynamic organization. I aim to leverage my technical skills and enthusiasm for learning to contribute effectively while continuously expanding my expertise in technology.",
        "cvPdfUrl" => "",
        "profileImageUrl" => "",
        "stats" => [
            ["label" => "Years Experience", "value" => "5"],
            ["label" => "Qualifications", "value" => "3"],
            ["label" => "Projects Completed", "value" => "50"],
            ["label" => "Client Satisfaction %", "value" => "100"]
        ],
        "skills" => [
            ["name" => "Web Development", "percentage" => "85"],
            ["name" => "Automation (Python/AHK)", "percentage" => "90"],
            ["name" => "Adobe Photoshop", "percentage" => "80"],
            ["name" => "MS Office Suite", "percentage" => "95"]
        ],
        "experience" => [
            ["role" => "Graphic Designer & Computer Operator", "company" => "Almadina Computer Academy", "date" => "2021 - Present", "description" => "Provided graphic design services using Adobe Photoshop. Managed computer operations and data entry. Developed automation scripts for browser and desktop tasks using JavaScript, AutoHotkey, and Python."]
        ],
        "education" => [
            ["degree" => "B.Sc", "institution" => "Bannu University", "year" => "2025"],
            ["degree" => "ICS", "institution" => "BISE Bannu", "year" => "2021"],
            ["degree" => "Matric", "institution" => "BISE Bannu", "year" => "2019"]
        ]
    ],
    "vision" => [
        "visionText" => "To be at the forefront of technological innovation, creating automated solutions that simplify complex tasks and empower businesses to reach their full potential.",
        "visionImage" => "https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=800",
        "missionText" => "To deliver high-quality digital services, from web development to graphic design, while continuously learning and adapting to the ever-evolving tech landscape.",
        "missionImage" => "https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=800"
    ],
    "gallery" => [
        ["id" => 1, "url" => "https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=800", "title" => "Portfolio Website", "category" => "Web", "description" => "A complete web portfolio showcasing modern design."],
        ["id" => 2, "url" => "https://images.unsplash.com/photo-1626785774573-4b799312c95d?auto=format&fit=crop&q=80&w=800", "title" => "Brand Identity", "category" => "Design", "description" => "Logos and brand identity kits for digital agencies."],
        ["id" => 3, "url" => "https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=800", "title" => "Data Automation", "category" => "Automation", "description" => "Python scripts used to automate repetitive daily tasks."]
    ],
    "blog" => [
        [
            "id" => "1",
            "title" => "The Future of Automation",
            "slug" => "future-of-automation",
            "image" => "https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=800",
            "excerpt" => "Exploring how Python and AHK are revolutionizing daily workflows.",
            "content" => "<p>Automation is changing the way we work...</p>",
            "tags" => ["Automation", "Python"],
            "date" => "2026-02-15",
            "status" => "published",
            "views" => "120"
        ],
        [
            "id" => "2",
            "title" => "Graphic Design Trends 2026",
            "slug" => "design-trends-2026",
            "image" => "https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&q=80&w=800",
            "excerpt" => "What to expect in the world of digital art and branding this year.",
            "content" => "<p>Design is evolving...</p>",
            "tags" => ["Design", "Creative"],
            "date" => "2026-01-10",
            "status" => "published",
            "views" => "85"
        ]
    ],
    "files" => []
];

// --- 2. DATA LOADING/INITIALIZATION ---
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (file_exists($dataFile)) {
    $jsonData = file_get_contents($dataFile);
    $data = json_decode($jsonData, true);
    if (!$data)
        $data = $defaultData;
} else {
    $data = $defaultData;
    // Set default password: admin123
    $data['auth']['password_hash'] = password_hash('admin123', PASSWORD_DEFAULT);
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
}

function saveData($file, $data)
{
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

// --- 3. BACKEND HANDLERS (AJAX) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $action = $_POST['action'] ?? '';
    $response = ['success' => false, 'message' => 'Invalid action'];

    // Public Actions
    if ($action === 'login') {
        $user = $_POST['username'] ?? '';
        $pass = $_POST['password'] ?? '';
        if ($user === $data['auth']['username'] && password_verify($pass, $data['auth']['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $response = ['success' => true];
        } else {
            $response = ['success' => false, 'message' => 'Invalid credentials'];
        }
    } elseif ($action === 'logout') {
        session_destroy();
        $response = ['success' => true];
    } elseif ($action === 'submitContact') {
        // Here you would typically send an email
        // mail($data['settings']['socialLinks']['email'], "New Contact: " . $_POST['subject'], $_POST['message']);
        $response = ['success' => true];
    }

    // Protected Actions
    elseif (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {

        if ($action === 'saveSettings') {
            $social = json_decode($_POST['socialLinks'], true);
            if ($social)
                $data['settings']['socialLinks'] = array_merge($data['settings']['socialLinks'], $social);
            saveData($dataFile, $data);
            $response = ['success' => true];
        } elseif ($action === 'changePassword') {
            $newPass = $_POST['newPassword'] ?? '';
            if (!empty($newPass)) {
                $data['auth']['password_hash'] = password_hash($newPass, PASSWORD_DEFAULT);
                saveData($dataFile, $data);
                $response = ['success' => true];
            }
        } elseif ($action === 'saveAbout') {
            $data['about']['stats'] = json_decode($_POST['stats'], true);
            $data['about']['skills'] = json_decode($_POST['skills'], true);
            $data['about']['experience'] = json_decode($_POST['experience'], true);
            $data['about']['education'] = json_decode($_POST['education'], true);
            saveData($dataFile, $data);
            $response = ['success' => true];
        } elseif ($action === 'saveVision') {
            // Add handler fields for vision text if passed
            saveData($dataFile, $data);
            $response = ['success' => true];
        } elseif ($action === 'saveGalleryItem') {
            $id = $_POST['id'] ?: time();
            $newImage = $_POST['image_url'];

            // Handle direct file upload if present
            if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == UPLOAD_ERR_OK) {
                $file = $_FILES['image_upload'];
                $fileName = time() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $newImage = $targetPath;
                }
            }

            $newItem = [
                'id' => $id,
                'title' => $_POST['title'],
                'category' => $_POST['category'],
                'description' => $_POST['description'] ?? '',
                'url' => $newImage
            ];

            $found = false;
            foreach ($data['gallery'] as &$item) {
                if ($item['id'] == $id) {
                    $item = array_merge($item, $newItem);
                    $found = true;
                    break;
                }
            }
            if (!$found)
                array_unshift($data['gallery'], $newItem);

            saveData($dataFile, $data);
            $response = ['success' => true];
        } elseif ($action === 'deleteGalleryItem') {
            $id = $_POST['id'];
            foreach ($data['gallery'] as $key => $item) {
                if ($item['id'] == $id) {
                    unset($data['gallery'][$key]);
                    $data['gallery'] = array_values($data['gallery']);
                    saveData($dataFile, $data);
                    $response = ['success' => true];
                    break;
                }
            }
        } elseif ($action === 'uploadFile') {
            if (isset($_FILES['upload_file'])) {
                $file = $_FILES['upload_file'];
                $fileName = time() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $fileEntry = [
                        'id' => time(),
                        'file_name' => $file['name'],
                        'file_path' => $targetPath,
                        'file_type' => $file['type'],
                        'file_size' => $file['size'],
                        'uploaded_at' => date('Y-m-d H:i:s')
                    ];
                    array_unshift($data['files'], $fileEntry);
                    saveData($dataFile, $data);
                    $response = ['success' => true, 'file_url' => $targetPath, 'file_id' => $fileEntry['id']];
                } else {
                    $response = ['success' => false, 'message' => 'Upload failed'];
                }
            }
        } elseif ($action === 'deleteFile') {
            $id = $_POST['id'];
            foreach ($data['files'] as $key => $file) {
                if ($file['id'] == $id) {
                    if (file_exists($file['file_path']))
                        unlink($file['file_path']);
                    unset($data['files'][$key]);
                    $data['files'] = array_values($data['files']);
                    saveData($dataFile, $data);
                    $response = ['success' => true];
                    break;
                }
            }
        } elseif ($action === 'saveBlogPost') {
            $id = $_POST['id'];
            $newPost = [
                'id' => $id ?: time(),
                'title' => $_POST['title'],
                'slug' => strtolower(str_replace(' ', '-', $_POST['title'])),
                'image' => $_POST['image'],
                'excerpt' => $_POST['excerpt'],
                'content' => $_POST['content'],
                'tags' => array_map('trim', explode(',', $_POST['tags'])),
                'date' => $_POST['date'],
                'status' => $_POST['status'],
                'views' => 0
            ];

            $found = false;
            foreach ($data['blog'] as &$post) {
                if ($post['id'] == $id) {
                    $post = array_merge($post, $newPost);
                    $found = true;
                    break;
                }
            }
            if (!$found)
                array_unshift($data['blog'], $newPost);

            saveData($dataFile, $data);
            $response = ['success' => true];
        }
    }

    echo json_encode($response);
    exit;
}

$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
$page = $_GET['page'] ?? '';
$slug = $_GET['slug'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['settings']['siteTitle']; ?></title>
    <meta name="description"
        content="A passionate computer enthusiast seeking a position in an innovative and dynamic organization. Skilled in Web Development, Automation, and Graphic Design.">
    <meta name="keywords" content="<?php echo $data['settings']['seoKeywords']; ?>">
    <link rel="icon" href="<?php echo $data['settings']['faviconUrl']; ?>" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        /* --- COPYING USER CSS EXACTLY --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --bg-card: rgba(30, 30, 45, 0.6);
            --text-primary: #ffffff;
            --text-secondary: #a0a0b0;
            --accent-cyan: #00f0ff;
            --accent-purple: #b000ff;
            --accent-lime: #c0ff00;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --gradient-1: linear-gradient(135deg, var(--accent-cyan), var(--accent-purple));
            --gradient-2: linear-gradient(135deg, var(--accent-cyan), var(--accent-lime));
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(10, 10, 15, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            z-index: 1000;
            padding: 20px 0;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            width: auto;
            object-fit: contain;
            -webkit-text-fill-color: initial;
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }

        .nav-links a:hover,
        .nav-links a.active-link {
            color: var(--accent-cyan);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-cyan);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after,
        .nav-links a.active-link::after {
            width: 100%;
        }

        .mobile-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-primary);
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-align: left;
            padding: 120px 20px 60px;
            position: relative;
            overflow: hidden;
            gap: 40px;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
            z-index: 2;
        }

        .hero-content p {
            margin: 0 0 40px 0;
        }

        .cta-buttons {
            justify-content: flex-start;
        }

        .hero-image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2;
            position: relative;
            overflow: visible !important;
        }

        .hero-img {
            width: 350px;
            height: 350px;
            object-fit: cover;
            border-radius: 50%;
            position: relative;
            z-index: 5;
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.4);
            border: 4px solid rgba(255, 255, 255, 0.9);
        }

        .hero-image-container::before {
            content: '';
            position: absolute;
            width: 370px;
            height: 370px;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top: 2px solid #00f0ff;
            border-right: 2px solid #ff00ff;
            box-shadow: 0 0 15px #00f0ff, 0 0 30px #ff00ff;
            animation: spin 3s linear infinite;
            z-index: 1;
        }

        .hero-image-container::after {
            content: '';
            position: absolute;
            width: 390px;
            height: 390px;
            border-radius: 50%;
            border: 2px solid transparent;
            border-bottom: 4px solid #00f0ff;
            border-left: 4px solid #ff00ff;
            box-shadow: 0 0 20px #ff00ff, 0 0 40px #00f0ff;
            animation: spin-reverse 5s linear infinite;
            z-index: 1;
        }

        .electric-border-canvas {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            height: 450px;
            z-index: 6;
            pointer-events: none;
            display: block !important;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-reverse {
            0% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(0, 240, 255, 0.1), transparent 70%);
            animation: rotateBackground 20s linear infinite;
            z-index: -1;
            pointer-events: none;
        }

        @keyframes rotateBackground {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .hero-content h1 {
            font-size: 72px;
            font-weight: 700;
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeUp 1s ease forwards;
        }

        .hero-content .typewriter {
            font-size: 28px;
            color: var(--accent-cyan);
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 30px;
            min-height: 40px;
            opacity: 0;
            animation: fadeUp 1s ease 0.2s forwards;
        }

        .hero-content p {
            font-size: 20px;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 40px;
            opacity: 0;
            animation: fadeUp 1s ease 0.4s forwards;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeUp 1s ease 0.6s forwards;
        }

        .btn {
            padding: 15px 35px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: width 0.4s ease-out, height 0.4s ease-out, top 0.4s ease-out, left 0.4s ease-out;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        .btn:hover::before {
            width: 300%;
            height: 300%;
            top: 50%;
            left: 50%;
        }

        .btn-primary {
            background: var(--gradient-1);
            color: var(--text-primary);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.4);
        }

        .btn-secondary {
            background: var(--glass-bg);
            border: 2px solid var(--glass-border);
            color: var(--text-primary);
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            border-color: var(--accent-cyan);
            background: rgba(0, 240, 255, 0.1);
        }

        section {
            padding: 100px 20px;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 80px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .section-header.animated {
            opacity: 1;
            transform: translateY(0);
        }

        .section-header h2 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-header p {
            font-size: 18px;
            color: var(--text-secondary);
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .glass-card.animated {
            opacity: 1;
            transform: translateY(0);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-cyan);
            box-shadow: 0 20px 60px rgba(0, 240, 255, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .stat-card {
            text-align: center;
        }

        .stat-card .number {
            font-size: 48px;
            font-weight: 700;
            color: var(--accent-cyan);
            font-family: 'JetBrains Mono', monospace;
            animation: fadeIn 1s ease forwards;
        }

        .stat-card .label {
            font-size: 16px;
            color: var(--text-secondary);
            margin-top: 10px;
        }

        .skills-grid {
            display: grid;
            gap: 25px;
            margin-bottom: 60px;
        }

        .skill-item {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .skill-header {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
        }

        .skill-bar {
            height: 8px;
            background: var(--bg-secondary);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .skill-progress {
            height: 100%;
            background: var(--gradient-1);
            border-radius: 10px;
            transition: width 1.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            width: 0%;
        }

        .skill-progress::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .timeline {
            position: relative;
            padding-left: 40px;
            margin-bottom: 60px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--gradient-1);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 40px;
            padding-left: 30px;
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.6s ease-out;
        }

        .timeline-item.animated {
            opacity: 1;
            transform: translateX(0);
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -45px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--accent-cyan);
            box-shadow: 0 0 20px var(--accent-cyan);
            animation: pulse 1.5s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(1.2);
                opacity: 0.7;
            }
        }

        .timeline-item h4 {
            font-size: 20px;
            color: var(--accent-cyan);
            margin-bottom: 5px;
        }

        .timeline-item .company {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .timeline-item .date {
            font-size: 14px;
            color: var(--text-secondary);
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 10px;
        }

        .cv-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            background: var(--accent-lime);
            color: var(--bg-primary);
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 30px;
        }

        .cv-download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(192, 255, 0, 0.4);
        }

        .education-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .vision-mission {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 40px;
        }

        .vm-card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            height: 500px;
        }

        .vm-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .vm-card:hover img {
            transform: scale(1.1);
        }

        .vm-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(10, 10, 15, 0.95), transparent);
            padding: 40px;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .vm-card:hover .vm-overlay {
            transform: translateY(0);
        }

        .vm-overlay h3 {
            font-size: 28px;
            margin-bottom: 15px;
            color: var(--accent-cyan);
        }

        .gallery-filters {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 25px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            backdrop-filter: blur(5px);
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: var(--accent-cyan);
            border-color: var(--accent-cyan);
            color: var(--bg-primary);
            box-shadow: 0 5px 20px rgba(0, 240, 255, 0.3);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            cursor: pointer;
            height: 300px;
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.5s ease;
        }

        .gallery-item.animated {
            opacity: 1;
            transform: scale(1);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            display: flex;
            align-items: flex-end;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-item-overlay {
            opacity: 1;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 40px;
        }

        .blog-card {
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .blog-card.animated {
            opacity: 1;
            transform: translateY(0);
        }

        .blog-card:hover {
            transform: translateY(-10px);
        }

        .blog-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .blog-card-content {
            padding: 30px;
        }

        .blog-meta {
            display: flex;
            gap: 15px;
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 15px;
            font-family: 'JetBrains Mono', monospace;
        }

        .blog-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: var(--text-primary);
        }

        .blog-card p {
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .blog-tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tag {
            padding: 5px 15px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            font-size: 12px;
            color: var(--accent-cyan);
            backdrop-filter: blur(5px);
        }

        .contact-form {
            max-width: 700px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-group input,
        .form-group textarea,
        .form-group select,
        .form-group .file-upload-wrapper {
            width: 100%;
            padding: 15px 20px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: inherit;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group .file-upload-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px;
        }

        .form-group .file-upload-wrapper input[type="file"] {
            flex-grow: 1;
            padding: 10px 5px;
            background: transparent;
            border: none;
            font-size: 14px;
        }

        .form-group .file-upload-wrapper input[type="text"] {
            flex-grow: 1;
            padding: 10px 5px;
            background: transparent;
            border: none;
        }

        .form-group .file-upload-wrapper button {
            background: var(--accent-cyan);
            color: var(--bg-primary);
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease;
            white-space: nowrap;
        }

        .form-group .file-upload-wrapper button:hover {
            background: var(--accent-purple);
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus,
        .form-group .file-upload-wrapper:focus-within {
            outline: none;
            border-color: var(--accent-cyan);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.2);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-group.error input,
        .form-group.error textarea {
            border-color: #ff4444;
        }

        .error-message {
            color: #ff4444;
            font-size: 14px;
            margin-top: 5px;
        }

        footer {
            background: var(--bg-secondary);
            padding: 40px 20px;
            text-align: center;
            border-top: 1px solid var(--glass-border);
        }

        .social-links {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .social-links a:hover {
            background: var(--accent-cyan);
            border-color: var(--accent-cyan);
            color: var(--bg-primary);
            transform: translateY(-3px);
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(10px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background: var(--bg-secondary);
            border-radius: 20px;
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            border: 1px solid var(--glass-border);
            transform: scale(0.9);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .modal.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .modal-close:hover {
            background: #ff4444;
            border-color: #ff4444;
            color: var(--bg-primary);
        }

        .lightbox-content img {
            width: 100%;
            height: auto;
            max-height: 70vh;
            object-fit: contain;
            border-radius: 20px 20px 0 0;
        }

        .lightbox-info {
            padding: 30px;
        }

        .lightbox-info h3 {
            color: var(--accent-cyan);
            font-size: 24px;
            margin-bottom: 10px;
        }

        .lightbox-nav {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .lightbox-nav button {
            padding: 10px 20px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .lightbox-nav button:hover {
            background: var(--accent-cyan);
            border-color: var(--accent-cyan);
            color: var(--bg-primary);
        }

        .blog-modal-content img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .blog-modal-body {
            padding: 40px;
        }

        .blog-modal-body h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .blog-modal-body h2 {
            font-size: 28px;
            margin: 30px 0 15px;
            color: var(--accent-cyan);
        }

        .blog-modal-body p {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 20px 30px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            color: var(--text-primary);
            z-index: 10001;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success {
            border-color: var(--accent-lime);
            background: rgba(192, 255, 0, 0.1);
        }

        .toast.error {
            border-color: #ff4444;
            background: rgba(255, 68, 68, 0.1);
        }

        .admin-login {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            max-width: 400px;
            width: 100%;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .admin-container {
            padding-top: 80px;
            min-height: 100vh;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .admin-header h1 {
            font-size: 36px;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .admin-nav {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            overflow-x: auto;
            padding-bottom: 10px;
            -webkit-overflow-scrolling: touch;
        }

        .admin-nav button {
            padding: 12px 25px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: var(--text-primary);
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.3s ease;
            font-weight: 500;
            backdrop-filter: blur(5px);
        }

        .admin-nav button.active,
        .admin-nav button:hover {
            background: var(--accent-cyan);
            border-color: var(--accent-cyan);
            color: var(--bg-primary);
            box-shadow: 0 5px 20px rgba(0, 240, 255, 0.3);
        }

        .admin-section {
            display: none;
        }

        .admin-section.active {
            display: block;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .stat-box {
            padding: 30px;
            text-align: center;
        }

        .stat-box .icon {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--accent-cyan);
        }

        .stat-box .value {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
            font-family: 'JetBrains Mono', monospace;
        }

        .stat-box .label {
            color: var(--text-secondary);
            font-size: 16px;
        }

        .admin-form {
            max-width: 800px;
        }

        .file-upload-wrapper {
            display: flex;
            gap: 10px;
        }

        .file-upload-wrapper input[type="text"] {
            flex-grow: 1;
        }

        .file-upload-wrapper input[type="file"] {
            display: none;
        }

        .file-upload-wrapper button {
            padding: 8px 15px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            border-radius: 5px;
            cursor: pointer;
            white-space: nowrap;
        }

        .file-upload-wrapper button:hover {
            background: var(--accent-cyan);
            color: var(--bg-primary);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .repeater-section {
            margin-bottom: 30px;
        }

        .repeater-item {
            background: var(--bg-secondary);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            position: relative;
            border: 1px solid var(--glass-border);
        }

        .repeater-remove {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ff4444;
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .repeater-remove:hover {
            transform: scale(1.05);
        }

        .add-repeater-btn {
            padding: 10px 20px;
            background: var(--accent-cyan);
            border: none;
            border-radius: 8px;
            color: var(--bg-primary);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .add-repeater-btn:hover {
            background: var(--accent-purple);
            box-shadow: 0 5px 20px rgba(176, 0, 255, 0.3);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: var(--bg-secondary);
            border-radius: 10px;
            overflow: hidden;
        }

        .data-table th,
        .data-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--glass-border);
        }

        .data-table th {
            background: var(--bg-secondary);
            font-weight: 600;
            color: var(--accent-cyan);
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .data-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-small {
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: var(--accent-cyan);
            color: var(--bg-primary);
        }

        .btn-edit:hover {
            background: var(--accent-lime);
        }

        .btn-delete {
            background: #ff4444;
            color: white;
        }

        .btn-delete:hover {
            background: #cc3333;
        }

        .rich-editor-toolbar {
            display: flex;
            gap: 10px;
            padding: 15px;
            background: var(--bg-secondary);
            border: 1px solid var(--glass-border);
            border-bottom: none;
            border-radius: 10px 10px 0 0;
            flex-wrap: wrap;
        }

        .rich-editor-toolbar button {
            padding: 8px 12px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 5px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .rich-editor-toolbar button:hover {
            background: var(--accent-cyan);
            color: var(--bg-primary);
        }

        .rich-editor-content {
            min-height: 300px;
            padding: 20px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 0 0 10px 10px;
            color: var(--text-primary);
            outline: none;
            overflow-y: auto;
        }

        .blog-page-header {
            padding: 120px 20px 60px;
            text-align: center;
        }

        .blog-page-header h1 {
            font-size: 52px;
            background: var(--gradient-2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
        }

        .blog-search-filter {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .blog-search-filter input {
            flex-grow: 1;
            max-width: 400px;
        }

        .blog-search-filter select {
            width: auto;
        }

        .blog-post-page {
            max-width: 900px;
            margin: 0 auto;
            padding-bottom: 100px;
        }

        .blog-post-page img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 40px;
        }

        .blog-post-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            color: var(--text-secondary);
            margin-bottom: 30px;
        }

        .blog-post-meta .author {
            font-weight: 600;
        }

        .blog-post-meta .date {
            font-family: 'JetBrains Mono', monospace;
        }

        .blog-post-content h2,
        .blog-post-content h3 {
            color: var(--accent-cyan);
            margin: 30px 0 15px;
            font-size: 28px;
        }

        .blog-post-content p {
            margin-bottom: 20px;
            line-height: 1.8;
            color: var(--text-primary);
        }

        .blog-post-content ul,
        .blog-post-content ol {
            margin-left: 20px;
            margin-bottom: 20px;
            list-style-type: disc;
            color: var(--text-primary);
        }

        .blog-post-content a {
            color: var(--accent-lime);
            text-decoration: none;
            border-bottom: 1px solid var(--accent-lime);
            transition: color 0.3s ease, border-color 0.3s ease;
        }

        .blog-post-content a:hover {
            color: var(--accent-cyan);
            border-color: var(--accent-cyan);
        }

        .related-posts {
            margin-top: 80px;
            border-top: 1px solid var(--glass-border);
            padding-top: 60px;
        }

        .related-posts h3 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 40px;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .import-export-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .import-export-section .btn {
            width: max-content;
        }

        .file-browser-modal .modal-content {
            max-width: 1200px;
            padding: 0;
        }

        .file-browser-modal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            border-bottom: 1px solid var(--glass-border);
        }

        .file-browser-modal .modal-header h2 {
            margin: 0;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .file-browser-modal .modal-body {
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .file-upload-area {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 30px;
            background: var(--glass-bg);
            border: 1px dashed var(--glass-border);
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .file-upload-area.drag-over {
            border-color: var(--accent-cyan);
            background: rgba(0, 240, 255, 0.05);
        }

        .file-upload-area i {
            font-size: 48px;
            color: var(--text-secondary);
        }

        .file-upload-area p {
            color: var(--text-secondary);
        }

        .file-upload-area input[type="file"] {
            display: none;
        }

        .file-list {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            background: var(--bg-secondary);
        }

        .file-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .file-list th,
        .file-list td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--glass-border);
        }

        .file-list th {
            background: var(--bg-secondary);
            font-weight: 600;
            color: var(--accent-cyan);
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .file-list tr:last-child td {
            border-bottom: none;
        }

        .file-list td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .file-list td a {
            color: var(--accent-lime);
            text-decoration: none;
        }

        .file-list td a:hover {
            text-decoration: underline;
        }

        .file-list .action-buttons {
            gap: 5px;
        }

        .file-list .btn-select {
            background: var(--accent-cyan);
            color: var(--bg-primary);
        }

        .file-list .btn-select:hover {
            background: var(--accent-lime);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background: rgba(10, 10, 15, 0.95);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 30px;
                gap: 20px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .nav-links.active {
                transform: translateX(0);
            }

            .mobile-toggle {
                display: block;
            }

            .hero-content h1 {
                font-size: 42px;
            }

            .hero-content .typewriter {
                font-size: 20px;
            }

            .section-header h2 {
                font-size: 32px;
            }

            .vision-mission,
            .gallery-grid,
            .blog-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .timeline {
                padding-left: 20px;
            }

            .timeline::before {
                left: 0;
            }

            .timeline-item::before {
                left: -25px;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .admin-nav {
                width: 100%;
                justify-content: flex-start;
            }

            .data-table th,
            .data-table td {
                padding: 10px;
                font-size: 14px;
            }

            .data-table th:nth-child(5),
            .data-table td:nth-child(5) {
                display: none;
            }

            .blog-post-page img {
                height: 250px;
            }

            .blog-post-page .blog-post-content h2 {
                font-size: 24px;
            }

            .blog-page-header h1 {
                font-size: 36px;
            }

            .file-browser-modal .modal-body {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 32px;
            }

            .hero-content .typewriter {
                font-size: 18px;
            }

            .btn {
                padding: 12px 25px;
                font-size: 14px;
            }

            .section-header h2 {
                font-size: 28px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .vm-card {
                height: 400px;
            }

            .modal-content {
                margin: 10px;
            }

            .modal-close {
                top: 10px;
                right: 10px;
                width: 30px;
                height: 30px;
                font-size: 16px;
            }

            .blog-modal-body {
                padding: 20px;
            }
        }

        .blog-search-container {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 50px;
            padding: 8px 10px;
            max-width: 800px;
            margin: 0 auto 60px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .blog-search-container:focus-within {
            border-color: var(--accent-cyan);
            box-shadow: 0 10px 40px rgba(0, 240, 255, 0.15);
            transform: translateY(-2px);
        }

        .search-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            padding-left: 15px;
        }

        .search-wrapper i {
            color: var(--text-secondary);
            font-size: 18px;
            margin-right: 15px;
        }

        .search-wrapper input {
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-size: 16px;
            width: 100%;
            padding: 10px 0;
        }

        .search-wrapper input:focus {
            outline: none;
            box-shadow: none;
        }

        .divider {
            width: 1px;
            height: 30px;
            background: var(--glass-border);
            margin: 0 15px;
        }

        .filter-wrapper {
            position: relative;
            padding-right: 15px;
        }

        .filter-wrapper select {
            background: transparent;
            border: none;
            color: var(--accent-cyan);
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            padding: 10px 30px 10px 10px;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
        }

        .filter-wrapper i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-cyan);
            pointer-events: none;
            font-size: 12px;
        }

        .filter-wrapper select option {
            background: var(--bg-secondary);
            color: var(--text-primary);
            padding: 10px;
        }

        .cv-export-toolbar {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .cv-export-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .cv-export-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .cv-export-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        .cv-export-btn:active {
            transform: translateY(-1px);
        }

        .cv-export-btn.btn-image {
            background: linear-gradient(135deg, #00b4d8, #0077b6);
        }

        .cv-export-btn.btn-image:hover {
            box-shadow: 0 8px 30px rgba(0, 180, 216, 0.4);
        }

        .cv-export-btn.btn-pdf {
            background: linear-gradient(135deg, #e63946, #a4133c);
        }

        .cv-export-btn.btn-pdf:hover {
            box-shadow: 0 8px 30px rgba(230, 57, 70, 0.4);
        }

        .cv-export-btn.btn-word {
            background: linear-gradient(135deg, #2b5ea7, #1b3a6b);
        }

        .cv-export-btn.btn-word:hover {
            box-shadow: 0 8px 30px rgba(43, 94, 167, 0.4);
        }

        .cv-export-btn i {
            font-size: 18px;
        }

        .cv-export-btn .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: cvSpin 0.6s linear infinite;
        }

        .cv-export-btn.loading i {
            display: none;
        }

        .cv-export-btn.loading .spinner {
            display: inline-block;
        }

        @keyframes cvSpin {
            to {
                transform: rotate(360deg);
            }
        }

        .cv-preview-wrapper {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 30px;
            overflow: auto;
            max-height: 240vh;
        }

        .cv-preview-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .cv-preview-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .cv-preview-wrapper::-webkit-scrollbar-thumb {
            background: var(--accent-cyan);
            border-radius: 3px;
        }

        #cv-document {
            width: 794px;
            margin: 0 auto;
            background: #ffffff;
            color: #1a1a2e;
            font-family: 'Space Grotesk', 'Segoe UI', sans-serif;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .cv-header {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            padding: 40px 45px;
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .cv-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(0, 240, 255, 0.6);
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 0 25px rgba(0, 240, 255, 0.3);
        }

        .cv-header-info h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .cv-header-info .cv-job-titles {
            font-size: 14px;
            color: #00f0ff;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .cv-contact-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }

        .cv-contact-row span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .cv-contact-row i {
            color: #00f0ff;
            font-size: 11px;
        }

        .cv-body {
            padding: 35px 45px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 35px;
        }

        .cv-section {
            margin-bottom: 5px;
        }

        .cv-section-title {
            font-size: 16px;
            font-weight: 700;
            color: #302b63;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding-bottom: 8px;
            border-bottom: 3px solid #00f0ff;
            margin-bottom: 15px;
            display: inline-block;
        }

        .cv-bio {
            grid-column: 1 / -1;
            font-size: 13px;
            line-height: 1.7;
            color: #444;
        }

        .cv-skill-item {
            margin-bottom: 10px;
        }

        .cv-skill-label {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
            color: #333;
        }

        .cv-skill-bar {
            width: 100%;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .cv-skill-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, #302b63, #00f0ff);
            transition: width 0.6s ease;
        }

        .cv-exp-item {
            margin-bottom: 16px;
            padding-left: 18px;
            border-left: 3px solid #e9ecef;
            position: relative;
        }

        .cv-exp-item::before {
            content: '';
            position: absolute;
            left: -7px;
            top: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #302b63;
            border: 2px solid #00f0ff;
        }

        .cv-exp-role {
            font-weight: 700;
            font-size: 14px;
            color: #1a1a2e;
        }

        .cv-exp-company {
            font-size: 12px;
            color: #666;
            margin: 2px 0;
        }

        .cv-exp-date {
            font-size: 11px;
            color: #999;
            font-weight: 500;
        }

        .cv-exp-desc {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
            line-height: 1.5;
        }

        .cv-edu-item {
            margin-bottom: 12px;
            padding-left: 18px;
            border-left: 3px solid #e9ecef;
            position: relative;
        }

        .cv-edu-item::before {
            content: '';
            position: absolute;
            left: -7px;
            top: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #302b63;
            border: 2px solid #c0ff00;
        }

        .cv-edu-degree {
            font-weight: 700;
            font-size: 13px;
            color: #1a1a2e;
        }

        .cv-edu-inst {
            font-size: 12px;
            color: #666;
        }

        .cv-edu-year {
            font-size: 11px;
            color: #999;
        }

        .cv-footer {
            background: linear-gradient(135deg, #0f0c29, #302b63);
            color: rgba(255, 255, 255, 0.5);
            text-align: center;
            padding: 12px;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        /* Hidden CV Document for export purposes */
        .cv-document-hidden {
            position: absolute;
            left: -9999px;
            top: -9999px;
        }
    </style>
</head>

<body>
    <canvas id="particles-canvas"></canvas>

    <!-- Navigation -->
    <nav>
        <div class="container">
            <a href="?" class="logo">
                <i class="fas fa-code" style="margin-right: 10px; color: var(--accent-cyan);"></i>
                <?php echo $data['settings']['siteTitle']; ?>
            </a>
            <ul class="nav-links">
                <li><a href="?" class="<?php echo empty($page) ? 'active-link' : ''; ?>">Home</a></li>
                <li><a href="?#about">About</a></li>
                <li><a href="?#vision">Vision</a></li>
                <li><a href="?page=gallery" class="<?php echo $page === 'gallery' ? 'active-link' : ''; ?>">Gallery</a>
                </li>
                <li><a href="?page=blog" class="<?php echo $page === 'blog' ? 'active-link' : ''; ?>">Blog</a></li>
                <li><a href="?page=cv" class="<?php echo $page === 'cv' ? 'active-link' : ''; ?>">CV</a></li>
                <li><a href="?#contact">Contact</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="?admin=dashboard" style="color:var(--accent-lime)">Admin</a></li><?php endif; ?>
            </ul>
            <div class="mobile-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Page Content Switching -->
    <?php if ($page === 'blog'): ?>

        <!-- Full Blog Page -->
        <section id="blog-page">
            <div class="container">
                <div class="blog-page-header">
                    <h1>Blog & Insights</h1>
                    <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Exploring the latest in
                        technology, automation, and design.</p>
                </div>

                <div class="blog-search-container">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="blogSearchInput" placeholder="Search articles..."
                            onkeyup="filterBlogPosts()">
                    </div>
                    <div class="divider"></div>
                    <div class="filter-wrapper">
                        <select id="blogFilterSelect" onchange="filterBlogPosts()">
                            <option value="all">All Topics</option>
                            <option value="automation">Automation</option>
                            <option value="python">Python</option>
                            <option value="design">Design</option>
                            <option value="web">Web Dev</option>
                        </select>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

                <div class="blog-grid" id="blogGrid">
                    <?php foreach ($data['blog'] as $post): ?>
                        <div class="blog-card glass-card animated" data-title="<?php echo htmlspecialchars($post['title']); ?>"
                            data-tags="<?php echo htmlspecialchars(implode(',', $post['tags'])); ?>"
                            onclick="location.href='?page=blog&slug=<?php echo $post['slug']; ?>'">
                            <img src="<?php echo $post['image']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <div class="blog-card-content">
                                <div class="blog-meta">
                                    <span><i class="far fa-calendar"></i> <?php echo $post['date']; ?></span>
                                    <span><i class="fas fa-eye"></i> <?php echo $post['views']; ?></span>
                                </div>
                                <h3><?php echo $post['title']; ?></h3>
                                <p><?php echo $post['excerpt']; ?></p>
                                <div class="blog-tags">
                                    <?php foreach ($post['tags'] as $tag): ?>
                                        <span class="tag"><?php echo $tag; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="noBlogResults"
                    style="display: none; text-align: center; padding: 40px; color: var(--text-secondary);">
                    <i class="fas fa-search" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
                    <p>No articles found matching your criteria.</p>
                </div>
            </div>
        </section>

    <?php elseif ($page === 'blog' && !empty($slug)):
        // Single Blog Post View
        $currentPost = null;
        foreach ($data['blog'] as $p) {
            if ($p['slug'] === $slug) {
                $currentPost = $p;
                break;
            }
        }
        if ($currentPost):
            ?>
            <section class="blog-post-page" style="padding-top: 150px;">
                <div class="container">
                    <a href="?page=blog"
                        style="color: var(--accent-cyan); text-decoration: none; display: inline-flex; align-items: center; gap: 10px; margin-bottom: 30px;"><i
                            class="fas fa-arrow-left"></i> Back to Blog</a>
                    <img src="<?php echo $currentPost['image']; ?>" alt="<?php echo $currentPost['title']; ?>">
                    <h1 style="font-size: 42px; margin-bottom: 20px;"><?php echo $currentPost['title']; ?></h1>
                    <div class="blog-post-meta">
                        <span class="author"><i class="fas fa-user"></i> <?php echo $data['settings']['authorName']; ?></span>
                        <span class="date"><i class="far fa-calendar"></i> <?php echo $currentPost['date']; ?></span>
                        <span><i class="fas fa-eye"></i> <?php echo $currentPost['views']; ?> Views</span>
                    </div>
                    <div class="blog-post-content glass-card" style="padding: 40px;">
                        <?php echo $currentPost['content']; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php elseif ($page === 'cv'): ?>

        <!-- CV Page -->
        <section id="cv-page" style="padding-top: 150px;">
            <div class="container">
                <div class="section-header">
                    <h2>Professional CV</h2>
                    <p>View or download my resume</p>
                </div>

                <div class="cv-export-toolbar">
                    <button class="cv-export-btn btn-image" id="btnExportImage" onclick="exportCVAsImage()">
                        <i class="fas fa-image"></i> Export as Image
                        <div class="spinner"></div>
                    </button>
                    <button class="cv-export-btn btn-pdf" id="btnExportPdf" onclick="exportCVAsPDF()">
                        <i class="fas fa-file-pdf"></i> Export as PDF
                        <div class="spinner"></div>
                    </button>
                    <button class="cv-export-btn btn-word" id="btnExportWord" onclick="exportCVAsWord()">
                        <i class="fas fa-file-word"></i> Export as Word
                        <div class="spinner"></div>
                    </button>
                </div>

                <div class="cv-preview-wrapper">
                    <!-- CV Document Structure matches the styles provided -->
                    <div id="cv-document">
                        <div class="cv-header">
                            <img src="<?php echo $data['about']['profileImageUrl'] ?: 'https://via.placeholder.com/150'; ?>"
                                class="cv-photo">
                            <div class="cv-header-info">
                                <h1><?php echo $data['settings']['authorName']; ?></h1>
                                <div class="cv-job-titles"><?php echo implode(' | ', $data['settings']['jobTitles']); ?>
                                </div>
                                <div class="cv-contact-row">
                                    <span><i class="fas fa-envelope"></i>
                                        <?php echo $data['settings']['socialLinks']['email']; ?></span>
                                    <span><i class="fas fa-phone"></i>
                                        <?php echo $data['settings']['socialLinks']['phone']; ?></span>
                                    <span><i class="fas fa-map-marker-alt"></i> Bannu, Pakistan</span>
                                </div>
                            </div>
                        </div>
                        <div class="cv-body">
                            <div class="cv-left-col">
                                <div class="cv-section">
                                    <div class="cv-section-title">Profile</div>
                                    <div class="cv-bio">
                                        <p><?php echo $data['about']['bio']; ?></p>
                                    </div>
                                </div>
                                <div class="cv-section">
                                    <div class="cv-section-title">Skills</div>
                                    <?php foreach ($data['about']['skills'] as $skill): ?>
                                        <div class="cv-skill-item">
                                            <div class="cv-skill-label">
                                                <span><?php echo $skill['name']; ?></span>
                                                <span><?php echo $skill['percentage']; ?>%</span>
                                            </div>
                                            <div class="cv-skill-bar">
                                                <div class="cv-skill-fill" style="width: <?php echo $skill['percentage']; ?>%">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="cv-right-col">
                                <div class="cv-section">
                                    <div class="cv-section-title">Experience</div>
                                    <?php foreach ($data['about']['experience'] as $exp): ?>
                                        <div class="cv-exp-item">
                                            <div class="cv-exp-role"><?php echo $exp['role']; ?></div>
                                            <div class="cv-exp-company"><?php echo $exp['company']; ?></div>
                                            <div class="cv-exp-date"><?php echo $exp['date']; ?></div>
                                            <div class="cv-exp-desc"><?php echo $exp['description']; ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="cv-section">
                                    <div class="cv-section-title">Education</div>
                                    <?php foreach ($data['about']['education'] as $edu): ?>
                                        <div class="cv-edu-item">
                                            <div class="cv-edu-degree"><?php echo $edu['degree']; ?></div>
                                            <div class="cv-edu-inst"><?php echo $edu['institution']; ?></div>
                                            <div class="cv-edu-year"><?php echo $edu['year']; ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="cv-footer">
                            References available upon request
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php elseif ($page === 'gallery'): ?>

        <!-- Full Gallery Page -->
        <section id="gallery-page" style="padding-top: 150px;">
            <div class="container">
                <div class="blog-page-header" style="padding-top: 0;">
                    <h1>My Gallery</h1>
                    <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Showcase of Work and
                        Projects.</p>
                </div>
                <div class="gallery-filters">
                    <button class="filter-btn active" data-filter="all" onclick="filterGallery('all')">All</button>
                    <button class="filter-btn" data-filter="Web" onclick="filterGallery('Web')">Web Dev</button>
                    <button class="filter-btn" data-filter="Design" onclick="filterGallery('Design')">Graphic
                        Design</button>
                    <button class="filter-btn" data-filter="Automation"
                        onclick="filterGallery('Automation')">Automation</button>
                </div>
                <div class="gallery-grid" id="mainGalleryGrid">
                    <?php foreach ($data['gallery'] as $item): ?>
                        <div class="gallery-item glass-card" data-category="<?php echo htmlspecialchars($item['category']); ?>"
                            onclick="openLightbox(<?php echo $item['id']; ?>)">
                            <img src="<?php echo $item['url']; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <div class="gallery-item-overlay">
                                <div>
                                    <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                                    <?php if (!empty($item['description'])): ?>
                                        <p style="font-size:12px; color:#ddd; margin-top:5px;">
                                            <?php echo htmlspecialchars($item['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    <?php elseif (!$isAdmin): ?>

        <!-- Main Single Page Layout -->
        <section id="home" class="hero">
            <div class="hero-content">
                <h1><?php echo $data['settings']['authorName']; ?></h1>
                <div class="typewriter" id="typewriter"></div>
                <p><?php echo $data['about']['bio']; ?></p>
                <div class="cta-buttons">
                    <a href="#contact" class="btn btn-primary">Get in Touch</a>
                    <a href="?page=cv" class="btn btn-secondary">Download CV</a>
                </div>
            </div>
            <div class="hero-image-container">
                <canvas id="electric-border-canvas" class="electric-border-canvas"></canvas>
                <div class="hero-img"
                    style="background: var(--bg-secondary); display: flex; align-items: center; justify-content: center;">
                    <?php if ($data['settings']['heroImageUrl']): ?>
                        <img src="<?php echo $data['settings']['heroImageUrl']; ?>"
                            style="width:100%; height:100%; object-fit:cover; border-radius:50%">
                    <?php else: ?>
                        <i class="fas fa-user-tie" style="font-size: 120px; color: var(--accent-cyan);"></i>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section id="about">
            <div class="container">
                <div class="section-header">
                    <h2>About Me</h2>
                    <p>Computer Professional & Developer</p>
                </div>
                <div class="stats-grid">
                    <?php foreach ($data['about']['stats'] as $stat): ?>
                        <div class="glass-card stat-card">
                            <div class="number" data-target="<?php echo $stat['value']; ?>">0</div>
                            <div class="label"><?php echo $stat['label']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="glass-card">
                    <h3 style="margin-bottom: 30px; font-size: 28px;">Technical Skills</h3>
                    <div class="skills-grid">
                        <?php foreach ($data['about']['skills'] as $skill): ?>
                            <div class="skill-item">
                                <div class="skill-header">
                                    <span><?php echo $skill['name']; ?></span>
                                    <span><?php echo $skill['percentage']; ?>%</span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-progress="<?php echo $skill['percentage']; ?>"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="glass-card" style="margin-top: 40px;">
                    <h3 style="margin-bottom: 30px; font-size: 28px;">Experience</h3>
                    <div class="timeline">
                        <?php foreach ($data['about']['experience'] as $exp): ?>
                            <div class="timeline-item">
                                <h4><?php echo $exp['role']; ?></h4>
                                <div class="company"><?php echo $exp['company']; ?></div>
                                <div class="date"><?php echo $exp['date']; ?></div>
                                <p><?php echo $exp['description']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="glass-card" style="margin-top: 40px;">
                    <h3 style="margin-bottom: 30px; font-size: 28px;">Education</h3>
                    <div class="education-grid">
                        <?php foreach ($data['about']['education'] as $edu): ?>
                            <div class="glass-card">
                                <h4 style="color: var(--accent-cyan); margin-bottom: 10px;"><?php echo $edu['degree']; ?></h4>
                                <p style="font-weight: 600; margin-bottom: 5px;"><?php echo $edu['institution']; ?></p>
                                <p style="color: var(--text-secondary); font-family: 'JetBrains Mono', monospace;">
                                    <?php echo $edu['year']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="vision">
            <div class="container">
                <div class="section-header">
                    <h2>Vision & Mission</h2>
                    <p>Driving Innovation</p>
                </div>
                <div class="vision-mission">
                    <div class="vm-card glass-card">
                        <img src="<?php echo $data['vision']['visionImage'] ?: 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=800'; ?>"
                            alt="Vision">
                        <div class="vm-overlay">
                            <h3>Our Vision</h3>
                            <p><?php echo $data['vision']['visionText']; ?></p>
                        </div>
                    </div>
                    <div class="vm-card glass-card">
                        <img src="<?php echo $data['vision']['missionImage'] ?: 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=800'; ?>"
                            alt="Mission">
                        <div class="vm-overlay">
                            <h3>Our Mission</h3>
                            <p><?php echo $data['vision']['missionText']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="blog">
            <div class="container">
                <div class="section-header">
                    <h2>Latest Blog Posts</h2>
                    <p>Thoughts & Insights</p>
                </div>
                <div class="blog-grid">
                    <?php foreach (array_slice($data['blog'], 0, 2) as $post): ?>
                        <div class="blog-card glass-card"
                            onclick="location.href='?page=blog&slug=<?php echo $post['slug']; ?>'">
                            <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">
                            <div class="blog-card-content">
                                <div class="blog-meta">
                                    <span><i class="far fa-calendar"></i> <?php echo $post['date']; ?></span>
                                    <span><i class="fas fa-eye"></i> <?php echo $post['views']; ?></span>
                                </div>
                                <h3><?php echo $post['title']; ?></h3>
                                <p><?php echo $post['excerpt']; ?></p>
                                <div class="blog-tags">
                                    <?php foreach ($post['tags'] as $tag): ?>
                                        <span class="tag"><?php echo $tag; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div style="text-align: center; margin-top: 60px;">
                    <a href="?page=blog" class="btn btn-primary">View All Posts</a>
                </div>
            </div>
        </section>

        <section id="contact">
            <div class="container">
                <div class="section-header">
                    <h2>Get in Touch</h2>
                    <p>Let's start a conversation</p>
                </div>
                <form id="contactForm" class="contact-form glass-card">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" required="">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required="">
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" required="">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" required=""></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </section>

    <?php endif; ?>

    <footer>
        <div class="container">
            <div class="social-links">
                <?php if ($data['settings']['socialLinks']['github']): ?><a
                        href="<?php echo $data['settings']['socialLinks']['github']; ?>" target="_blank"><i
                            class="fab fa-github"></i></a><?php endif; ?>
                <?php if ($data['settings']['socialLinks']['linkedin']): ?><a
                        href="<?php echo $data['settings']['socialLinks']['linkedin']; ?>" target="_blank"><i
                            class="fab fa-linkedin"></i></a><?php endif; ?>
                <?php if ($data['settings']['socialLinks']['twitter']): ?><a
                        href="<?php echo $data['settings']['socialLinks']['twitter']; ?>" target="_blank"><i
                            class="fab fa-twitter"></i></a><?php endif; ?>
                <a href="mailto:<?php echo $data['settings']['socialLinks']['email']; ?>"><i
                        class="fas fa-envelope"></i></a>
            </div>
            <p><?php echo $data['settings']['footerText']; ?></p>
            <p style="margin-top: 10px; color: var(--text-secondary); font-size: 14px;">
                NexusFolio v1.0 by Yasin Ullah
            </p>
        </div>
    </footer>

    <!-- Modals -->
    <div id="lightboxModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeLightbox()">×</button>
            <div class="lightbox-content" id="lightboxContent"></div>
        </div>
    </div>
    <div id="toast" class="toast"></div>

    <!-- Hidden Element for CV Generation when on other pages -->
    <?php if ($page !== 'cv'): ?>
        <div id="cv-document" class="cv-document-hidden">
            <!-- Hidden CV content for JS export functions to grab if needed from other contexts -->
            <div class="cv-header">
                <img src="<?php echo $data['about']['profileImageUrl'] ?: 'https://via.placeholder.com/150'; ?>"
                    class="cv-photo">
                <div class="cv-header-info">
                    <h1><?php echo $data['settings']['authorName']; ?></h1>
                    <div class="cv-job-titles"><?php echo implode(' | ', $data['settings']['jobTitles']); ?></div>
                </div>
            </div>
            <div class="cv-body">
                <div class="cv-bio">
                    <p><?php echo $data['about']['bio']; ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Admin Logic -->
    <?php if (isset($_GET['admin'])): ?>
        <script>
            // Hide main content if admin param is present
            document.querySelector('nav').style.display = 'none';
            if (document.getElementById('home')) document.getElementById('home').style.display = 'none';
            if (document.getElementById('about')) document.getElementById('about').style.display = 'none';
            if (document.getElementById('vision')) document.getElementById('vision').style.display = 'none';
            if (document.getElementById('gallery-page')) document.getElementById('gallery-page').style.display = 'none';
            if (document.getElementById('blog')) document.getElementById('blog').style.display = 'none';
            if (document.getElementById('contact')) document.getElementById('contact').style.display = 'none';
            document.querySelector('footer').style.display = 'none';
        </script>

        <?php if ($_GET['admin'] === 'login' && !$isAdmin): ?>
            <div class="admin-login" id="adminLogin">
                <div class="glass-card login-card">
                    <h2>Admin Login</h2>
                    <form id="loginForm">
                        <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
                        <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
                        <button type="submit" class="btn btn-primary" style="width:100%">Login</button>
                    </form>
                </div>
            </div>
        <?php elseif ($_GET['admin'] === 'dashboard' && $isAdmin): ?>
            <div class="admin-container" id="adminDashboard">
                <div class="container">
                    <div class="admin-header">
                        <h1>Dashboard</h1>
                        <div>
                            <a href="?" class="btn btn-secondary">View Site</a>
                            <button onclick="logout()" class="btn btn-primary">Logout</button>
                        </div>
                    </div>

                    <div class="admin-nav">
                        <button class="admin-nav-item active" onclick="switchAdminSection('dashboard')">Dashboard</button>
                        <button class="admin-nav-item" onclick="switchAdminSection('settings')">Settings</button>
                        <button class="admin-nav-item" onclick="switchAdminSection('about')">About</button>
                        <button class="admin-nav-item" onclick="switchAdminSection('gallery')">Gallery</button>
                        <button class="admin-nav-item" onclick="switchAdminSection('files')">Files</button>
                    </div>

                    <!-- Dashboard Home -->
                    <div id="admin-dashboard" class="admin-section active">
                        <div class="glass-card">
                            <h3>Welcome, <?php echo $data['auth']['username']; ?></h3>
                            <div class="dashboard-stats">
                                <div class="stat-box">
                                    <div class="icon"><i class="fas fa-eye"></i></div>
                                    <div class="value">1,500</div>
                                    <div class="label">Total Views</div>
                                </div>
                                <div class="stat-box">
                                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                                    <div class="value"><?php echo count($data['blog']); ?></div>
                                    <div class="label">Blog Posts</div>
                                </div>
                                <div class="stat-box">
                                    <div class="icon"><i class="fas fa-images"></i></div>
                                    <div class="value"><?php echo count($data['gallery']); ?></div>
                                    <div class="label">Gallery Items</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Editor -->
                    <div id="admin-settings" class="admin-section">
                        <div class="glass-card">
                            <h3>General Settings</h3>
                            <form id="settingsForm">
                                <div class="form-group"><label>Email</label><input type="text" id="social-email"
                                        value="<?php echo $data['settings']['socialLinks']['email']; ?>"></div>
                                <div class="form-group"><label>GitHub</label><input type="text" id="social-github"
                                        value="<?php echo $data['settings']['socialLinks']['github']; ?>"></div>
                                <div class="form-group"><label>LinkedIn</label><input type="text" id="social-linkedin"
                                        value="<?php echo $data['settings']['socialLinks']['linkedin']; ?>"></div>
                                <div class="form-group"><label>Twitter</label><input type="text" id="social-twitter"
                                        value="<?php echo $data['settings']['socialLinks']['twitter']; ?>"></div>
                                <button type="submit" class="btn btn-primary">Save Settings</button>
                            </form>
                            <br>
                            <h3>Change Password</h3>
                            <form id="passwordForm">
                                <div class="form-group"><input type="password" name="newPassword" placeholder="New Password">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                        </div>
                    </div>

                    <!-- About Editor -->
                    <div id="admin-about" class="admin-section">
                        <div class="glass-card">
                            <h3>Edit Stats</h3>
                            <div id="stats-repeater" class="repeater-section">
                                <?php foreach ($data['about']['stats'] as $stat): ?>
                                    <div class="repeater-item">
                                        <button type="button" class="repeater-remove"
                                            onclick="this.parentElement.remove()">Remove</button>
                                        <div class="form-row">
                                            <div class="form-group"><label>Label</label><input type="text" class="stat-label"
                                                    value="<?php echo $stat['label']; ?>"></div>
                                            <div class="form-group"><label>Value</label><input type="number" class="stat-value"
                                                    value="<?php echo $stat['value']; ?>"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="add-repeater-btn" onclick="addStat()">Add Stat</button>

                            <form id="aboutForm" style="margin-top:20px">
                                <button type="submit" class="btn btn-primary">Save All About Data</button>
                            </form>
                        </div>
                    </div>

                    <!-- Gallery Editor -->
                    <div id="admin-gallery" class="admin-section">
                        <div class="glass-card">
                            <h3>Manage Gallery</h3>
                            <form id="galleryForm" class="admin-form" style="margin-bottom: 40px;">
                                <input type="hidden" name="id" value="">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" name="category" placeholder="e.g. Web, Design, Automation" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" rows="3"
                                        placeholder="Brief description about the gallery item..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Image URL (or Upload)</label>
                                    <div class="file-upload-wrapper">
                                        <input type="text" name="image_url" placeholder="https://...">
                                        <input type="file" name="image_upload" id="galleryUploadInput" accept="image/*">
                                        <button type="button" onclick="document.getElementById('galleryUploadInput').click()"><i
                                                class="fas fa-upload"></i> Upload</button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Gallery Item</button>
                                <button type="button" class="btn btn-secondary" onclick="resetGalleryForm()">Cancel /
                                    Clear</button>
                            </form>

                            <div class="data-table-container">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['gallery'] as $item): ?>
                                            <tr>
                                                <td><img src="<?php echo htmlspecialchars($item['url']); ?>"
                                                        style="width:50px; height:50px; object-fit:cover; border-radius:5px;"></td>
                                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                                <td><?php echo htmlspecialchars($item['category']); ?></td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="btn-small btn-edit"
                                                            onclick="editGalleryItem(<?php echo $item['id']; ?>)">Edit</button>
                                                        <button class="btn-small btn-delete"
                                                            onclick="deleteGalleryItem(<?php echo $item['id']; ?>)">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- File Manager -->
                    <div id="admin-files" class="admin-section">
                        <div class="glass-card">
                            <h3>File Manager</h3>
                            <div class="file-upload-area" id="fileUploadDropzone">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Drag & Drop files here or click to upload</p>
                                <form id="uploadForm">
                                    <input type="file" name="upload_file" id="fileInputUpload"
                                        style="display:block; margin: 0 auto;">
                                    <button type="submit" class="btn btn-primary" style="margin-top:10px">Upload</button>
                                </form>
                            </div>
                            <div class="file-list" style="margin-top: 20px;">
                                <table id="fileListBody">
                                    <!-- Populated by JS -->
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php else: ?>
            <script>window.location.href = '?admin=login';</script>
        <?php endif; ?>
    <?php endif; ?>

    <script>
        const isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
        const siteData = <?php echo json_encode($data); ?>;
        const uploadDir = "uploads/";
        const maxFileSize = 10485760;

        // --- Common Animation Logic ---
        const canvas = document.getElementById('particles-canvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            const particles = [];
            const particleCount = window.innerWidth < 768 ? 50 : 100;
            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2 + 1;
                    this.speedX = Math.random() * 0.5 - 0.25;
                    this.speedY = Math.random() * 0.5 - 0.25;
                }
                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;
                    if (this.x > canvas.width) this.x = 0;
                    if (this.x < 0) this.x = canvas.width;
                    if (this.y > canvas.height) this.y = 0;
                    if (this.y < 0) this.y = canvas.height;
                }
                draw() {
                    ctx.fillStyle = 'rgba(0, 240, 255, 0.5)';
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
            for (let i = 0; i < particleCount; i++) particles.push(new Particle());
            function animateParticles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let i = 0; i < particles.length; i++) {
                    particles[i].update();
                    particles[i].draw();
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        if (distance < 100) {
                            ctx.strokeStyle = `rgba(0, 240, 255, ${0.2 - distance / 500})`;
                            ctx.lineWidth = 1;
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
                requestAnimationFrame(animateParticles);
            }
            animateParticles();
            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });
        }

        // --- Frontend Interactivity ---
        if (!isAdmin) {
            // Typewriter
            const titles = siteData.settings.jobTitles || ['Developer', 'Designer'];
            const typewriterEl = document.getElementById('typewriter');
            if (typewriterEl) {
                let titleIndex = 0, charIndex = 0, isDeleting = false;
                function typeWriter() {
                    const currentTitle = titles[titleIndex];
                    if (isDeleting) {
                        typewriterEl.textContent = currentTitle.substring(0, charIndex - 1);
                        charIndex--;
                    } else {
                        typewriterEl.textContent = currentTitle.substring(0, charIndex + 1);
                        charIndex++;
                    }
                    let speed = isDeleting ? 50 : 100;
                    if (!isDeleting && charIndex === currentTitle.length) { speed = 2000; isDeleting = true; }
                    else if (isDeleting && charIndex === 0) { isDeleting = false; titleIndex = (titleIndex + 1) % titles.length; speed = 500; }
                    setTimeout(typeWriter, speed);
                }
                typeWriter();
            }

            // Intersection Observer
            const sectionObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');

                        // Counter Animation
                        const numberEl = entry.target.querySelector('.number');
                        if (numberEl && !numberEl.classList.contains('counted')) {
                            const target = parseInt(numberEl.getAttribute('data-target') || '0');
                            let startTimestamp = null;
                            const step = (timestamp) => {
                                if (!startTimestamp) startTimestamp = timestamp;
                                const progress = Math.min((timestamp - startTimestamp) / 2000, 1);
                                numberEl.textContent = Math.floor(progress * target);
                                if (progress < 1) window.requestAnimationFrame(step);
                                else numberEl.textContent = target;
                            };
                            window.requestAnimationFrame(step);
                            numberEl.classList.add('counted');
                        }

                        // Skill Bar Animation
                        if (entry.target.classList.contains('skill-progress')) {
                            setTimeout(() => {
                                const percent = entry.target.getAttribute('data-progress') || '0';
                                entry.target.style.width = percent + '%';
                            }, 100);
                        }

                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.section-header, .glass-card, .timeline-item, .gallery-item, .blog-card, .skill-progress').forEach(el => sectionObserver.observe(el));

            // Contact Form
            document.getElementById('contactForm')?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                formData.append('action', 'submitContact');
                const res = await fetch('', { method: 'POST', body: formData }).then(r => r.json());
                if (res.success) { showToast('Message sent successfully!'); e.target.reset(); }
                else showToast('Failed to send message', 'error');
            });
        }

        // --- Shared Helper Functions ---
        function toggleMobileMenu() { document.querySelector('.nav-links').classList.toggle('active'); }
        function showToast(msg, type = 'success') {
            const t = document.getElementById('toast');
            t.textContent = msg; t.className = `toast ${type} show`;
            setTimeout(() => t.classList.remove('show'), 3000);
        }
        function openLightbox(id) {
            const item = siteData.gallery.find(i => i.id == id);
            if (item) {
                const descHtml = item.description ? `<p style="color:var(--text-secondary); margin-top:10px;">${item.description}</p>` : '';
                document.getElementById('lightboxContent').innerHTML = `<img src="${item.url}" alt="${item.title}"><div class="lightbox-info"><h3>${item.title}</h3><p style="font-size:14px; color:var(--accent-lime);">${item.category}</p>${descHtml}</div>`;
                document.getElementById('lightboxModal').classList.add('active');
            }
        }
        function closeLightbox() { document.getElementById('lightboxModal').classList.remove('active'); }

        // --- Filter Logic ---
        function filterBlogPosts() {
            const searchInput = document.getElementById('blogSearchInput').value.toLowerCase();
            const filterSelect = document.getElementById('blogFilterSelect').value.toLowerCase();
            const blogCards = document.querySelectorAll('#blogGrid .blog-card');
            let foundResults = false;
            blogCards.forEach(card => {
                const title = card.dataset.title.toLowerCase();
                const tags = card.dataset.tags.toLowerCase().split(',');
                const matchesSearch = title.includes(searchInput);
                const matchesFilter = filterSelect === 'all' || tags.includes(filterSelect);
                if (matchesSearch && matchesFilter) {
                    card.style.display = 'block'; setTimeout(() => card.classList.add('animated'), 50); foundResults = true;
                } else {
                    card.classList.remove('animated'); setTimeout(() => card.style.display = 'none', 300);
                }
            });
            document.getElementById('noBlogResults').style.display = foundResults ? 'none' : 'block';
        }

        function filterGallery(category) {
            // Update active button
            document.querySelectorAll('.gallery-filters .filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.filter === category || (category === 'all' && btn.dataset.filter === 'all')) btn.classList.add('active');
            });

            // Filter items
            document.querySelectorAll('#mainGalleryGrid .gallery-item').forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                    setTimeout(() => item.classList.add('animated'), 50);
                } else {
                    item.classList.remove('animated');
                    setTimeout(() => item.style.display = 'none', 300);
                }
            });
        }

        // --- Admin Logic ---
        if (isAdmin) {
            function switchAdminSection(section) {
                document.querySelectorAll('.admin-section').forEach(s => s.classList.remove('active'));
                document.getElementById(`admin-${section}`).classList.add('active');
                document.querySelectorAll('.admin-nav-item').forEach(b => b.classList.remove('active'));
                event.target.classList.add('active');
                if (section === 'files') loadFileBrowserContent(siteData.files);
            }

            // File Upload
            document.getElementById('uploadForm')?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const files = document.getElementById('fileInputUpload').files;
                if (files.length === 0) return;
                const fd = new FormData();
                fd.append('upload_file', files[0]);
                fd.append('action', 'uploadFile');
                const res = await fetch('', { method: 'POST', body: fd }).then(r => r.json());
                if (res.success) { showToast('Uploaded successfully'); location.reload(); }
                else showToast('Upload failed', 'error');
            });

            async function deleteFile(id) {
                if (!confirm('Delete file?')) return;
                const fd = new FormData(); fd.append('action', 'deleteFile'); fd.append('id', id);
                const res = await fetch('', { method: 'POST', body: fd }).then(r => r.json());
                if (res.success) location.reload();
            }

            function loadFileBrowserContent(files) {
                const tbody = document.getElementById('fileListBody');
                tbody.innerHTML = '';
                files.forEach(f => {
                    const row = `<tr>
                        <td>${f.file_type.includes('image') ? `<img src="${f.file_path}" width="50">` : '<i class="fas fa-file"></i>'}</td>
                        <td><a href="${f.file_path}" target="_blank">${f.file_name}</a></td>
                        <td>${f.file_type}</td>
                        <td>${(f.file_size / 1024).toFixed(2)} KB</td>
                        <td><button class="btn-small btn-delete" onclick="deleteFile('${f.id}')">Delete</button></td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            }

            // Save Settings
            document.getElementById('settingsForm')?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const social = {
                    github: document.getElementById('social-github').value,
                    linkedin: document.getElementById('social-linkedin').value,
                    twitter: document.getElementById('social-twitter').value,
                    email: document.getElementById('social-email').value
                };
                const fd = new FormData();
                fd.append('action', 'saveSettings');
                fd.append('socialLinks', JSON.stringify(social));
                const res = await fetch('', { method: 'POST', body: fd }).then(r => r.json());
                if (res.success) showToast('Settings Saved');
            });

            // Gallery
            document.getElementById('galleryForm')?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const fd = new FormData(e.target);
                fd.append('action', 'saveGalleryItem');
                const res = await fetch('', { method: 'POST', body: fd }).then(r => r.json());
                if (res.success) { showToast('Gallery Item Saved'); location.reload(); }
                else showToast('Failed to save', 'error');
            });

            window.deleteGalleryItem = async function (id) {
                if (!confirm('Delete this gallery item?')) return;
                const fd = new FormData();
                fd.append('action', 'deleteGalleryItem');
                fd.append('id', id);
                const res = await fetch('', { method: 'POST', body: fd }).then(r => r.json());
                if (res.success) location.reload();
            }

            window.editGalleryItem = function (id) {
                const item = siteData.gallery.find(i => i.id == id);
                if (item) {
                    const form = document.getElementById('galleryForm');
                    form.elements['id'].value = item.id;
                    form.elements['title'].value = item.title;
                    form.elements['category'].value = item.category;
                    form.elements['description'].value = item.description || '';
                    form.elements['image_url'].value = item.url;
                    form.querySelector('button[type="submit"]').textContent = 'Update Gallery Item';
                    window.scrollTo({ top: form.offsetTop - 100, behavior: 'smooth' });
                }
            }

            window.resetGalleryForm = function () {
                const form = document.getElementById('galleryForm');
                form.reset();
                form.elements['id'].value = '';
                form.querySelector('button[type="submit"]').textContent = 'Add Gallery Item';
            }

            // Stats Repeater (Simplified)
            window.addStat = function () {
                const div = document.createElement('div');
                div.className = 'repeater-item';
                div.innerHTML = `<button type="button" class="repeater-remove" onclick="this.parentElement.remove()">Remove</button>
                    <div class="form-row"><div class="form-group"><label>Label</label><input type="text" class="stat-label"></div>
                    <div class="form-group"><label>Value</label><input type="number" class="stat-value"></div></div>`;
                document.getElementById('stats-repeater').appendChild(div);
            }

            document.getElementById('aboutForm')?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const stats = [];
                document.querySelectorAll('#stats-repeater .repeater-item').forEach(item => {
                    stats.push({ label: item.querySelector('.stat-label').value, value: item.querySelector('.stat-value').value });
                });
                const fd = new FormData();
                fd.append('action', 'saveAbout');
                fd.append('stats', JSON.stringify(stats));
                // Add logic for skills, exp, edu similarly
                fd.append('skills', JSON.stringify(siteData.about.skills));
                fd.append('experience', JSON.stringify(siteData.about.experience));
                fd.append('education', JSON.stringify(siteData.about.education));
                const res = await fetch('', { method: 'POST', body: fd }).then(r => r.json());
                if (res.success) showToast('About Data Saved');
            });

            window.logout = async function () {
                const fd = new FormData(); fd.append('action', 'logout');
                await fetch('', { method: 'POST', body: fd });
                location.href = '?';
            }
        } else if (document.getElementById('loginForm')) {
            document.getElementById('loginForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const fd = new FormData(e.target); fd.append('action', 'login');
                const res = await fetch('', { method: 'POST', body: fd }).then(r => r.json());
                if (res.success) location.href = '?admin=dashboard';
                else showToast(res.message, 'error');
            });
        }

        // CV Export Functions
        async function exportCVAsImage() {
            const cvEl = document.getElementById('cv-document');
            cvEl.style.position = 'static'; // Make visible for capture
            const canvas = await html2canvas(cvEl, { scale: 2 });
            cvEl.style.position = 'absolute'; // Hide again
            const link = document.createElement('a');
            link.download = 'Muhib_Ullah_CV.png';
            link.href = canvas.toDataURL();
            link.click();
        }

        async function exportCVAsPDF() {
            const { jsPDF } = window.jspdf;
            const cvEl = document.getElementById('cv-document');
            cvEl.style.position = 'static';
            const canvas = await html2canvas(cvEl, { scale: 2 });
            cvEl.style.position = 'absolute';
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('Muhib_Ullah_CV.pdf');
        }

        function exportCVAsWord() {
            const header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
            const footer = "</body></html>";
            const cvEl = document.getElementById('cv-document').cloneNode(true);
            // Inline critical styles for Word (simplified)
            cvEl.style.cssText = "background:white; color:black; font-family:sans-serif; width:100%;";
            const sourceHTML = header + cvEl.outerHTML + footer;
            const source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
            const fileDownload = document.createElement("a");
            document.body.appendChild(fileDownload);
            fileDownload.href = source;
            fileDownload.download = 'Muhib_Ullah_CV.doc';
            fileDownload.click();
            document.body.removeChild(fileDownload);
        }

        // Neon Ring (Only on frontend)
        if (!isAdmin && document.getElementById("electric-border-canvas")) {
            const c = document.getElementById("electric-border-canvas");
            const x = c.getContext("2d");
            c.width = 450; c.height = 450;
            let a = 0;
            function draw() {
                x.clearRect(0, 0, 450, 450);
                a += 0.05;
                x.beginPath(); x.arc(225, 225, 210, a, a + Math.PI * 1.5);
                x.strokeStyle = '#00f0ff'; x.lineWidth = 4; x.shadowBlur = 15; x.shadowColor = '#00f0ff'; x.stroke();
                requestAnimationFrame(draw);
            }
            draw();
        }
    </script>
</body>

</html>