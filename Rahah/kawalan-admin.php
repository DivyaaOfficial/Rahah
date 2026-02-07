<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("header.php");
include("connection.php");

/* ================== QUERY KEPUTUSAN UNDIAN ================== */
$query_jawatan = "
SELECT
    j.idjawatan,
    j.nama_jawatan,
    c.id_calon,
    c.nama_calon,
    c.gambar,
    COUNT(u.id_undi) AS jumlah_undian
FROM undian u
JOIN jawatan j ON u.idjawatan = j.idjawatan
JOIN calon c ON u.id_calon = c.id_calon
GROUP BY j.idjawatan, j.nama_jawatan, c.id_calon, c.nama_calon, c.gambar
ORDER BY j.idjawatan, jumlah_undian DESC
";

$result_jawatan = mysqli_query($condb, $query_jawatan);
if (!$result_jawatan) {
    die("SQL Error: " . mysqli_error($condb));
}

/* ================== SUSUN DATA ================== */
$undian_jawatan = [];
while ($row = mysqli_fetch_assoc($result_jawatan)) {
    $idjawatan = $row['idjawatan'];

    if (!isset($undian_jawatan[$idjawatan])) {
        $undian_jawatan[$idjawatan] = [
            'nama_jawatan' => $row['nama_jawatan'],
            'calon' => []
        ];
    }
    $undian_jawatan[$idjawatan]['calon'][] = $row;
}

ksort($undian_jawatan);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengundian Kelab Olahraga SMK St. George</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* RESET & BASE STYLES */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        :root {
            --primary: #dc3545;
            --primary-dark: #c82333;
            --primary-light: #ff6b7a;
            --secondary: #28a745;
            --secondary-dark: #218838;
            --accent: #ffc107;
            --light: #ffffff;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #f8f9fa;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.25);
            --border-radius: 20px;
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }

        /* BACKGROUND FULL SCREEN */
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: 
                linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)),
                url('gambar/banner-new.jpg?v=<?= time(); ?>') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* MAIN CONTAINER */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* HEADER SECTION */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 0 0 25px 25px;
            padding: 25px 40px;
            margin-bottom: 40px;
            box-shadow: var(--shadow-lg);
            border-bottom: 5px solid var(--primary);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .logo-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid var(--primary);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
            background: white;
            padding: 5px;
        }

        .logo-text h1 {
            font-size: 32px;
            color: var(--dark);
            margin-bottom: 8px;
            font-weight: 800;
        }

        .logo-text h2 {
            font-size: 20px;
            color: var(--primary);
            font-weight: 600;
        }

        /* USER BOX */
        .user-box {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 25px 35px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            min-width: 350px;
            text-align: center;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }

        .user-box h3 {
            font-size: 22px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .user-name {
            font-size: 26px;
            font-weight: 700;
            color: var(--accent);
            margin: 10px 0;
        }

        .user-role {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-block;
            font-weight: 600;
            margin: 10px 0;
        }

        /* LOGIN BOX */
        .login-box {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            min-width: 350px;
            text-align: center;
            border: 3px solid var(--primary);
        }

        /* HERO SECTION WITH IMAGE */
        .hero-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        @media (max-width: 992px) {
            .hero-section {
                grid-template-columns: 1fr;
            }
        }

        .hero-left {
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-left h2 {
            font-size: 36px;
            color: var(--dark);
            margin-bottom: 20px;
            font-weight: 800;
            line-height: 1.2;
        }

        .hero-left p {
            font-size: 18px;
            color: var(--gray);
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .hero-right {
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border: 5px solid var(--primary);
        }

        .voting-img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 5px solid white;
        }

        /* BUTTON STYLES */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 16px 35px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 18px;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            min-width: 250px;
            margin: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(220, 53, 69, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--secondary) 100%);
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.4);
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            margin-top: 20px;
        }

        /* FEATURES SECTION WITH IMAGES */
        .features-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 60px 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            padding: 30px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
        }

        .feature-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 5px solid var(--primary);
            padding: 5px;
            background: white;
        }

        .feature-card h3 {
            color: var(--dark);
            margin-bottom: 15px;
            font-size: 22px;
        }

        /* RESULTS SECTION */
        .section-header {
            text-align: center;
            margin: 80px 0 50px;
            position: relative;
        }

        .section-header h2 {
            font-size: 42px;
            color: white;
            display: inline-block;
            padding: 20px 40px;
            position: relative;
            font-weight: 800;
            background: rgba(0, 0, 0, 0.6);
            border-radius: var(--border-radius);
            border: 3px solid var(--primary);
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        /* POSITION CARDS */
        .position-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
            gap: 35px;
            margin-bottom: 70px;
        }

        @media (max-width: 768px) {
            .position-grid {
                grid-template-columns: 1fr;
            }
        }

        .position-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }

        .position-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .position-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .position-header h3 {
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .candidates-container {
            padding: 25px;
        }

        .candidate-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .candidate-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: var(--transition);
            border: 2px solid transparent;
            position: relative;
        }

        .candidate-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
        }

        .candidate-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .candidate-img {
            width: 90px;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .candidate-details {
            flex: 1;
        }

        .candidate-name {
            font-weight: 700;
            font-size: 18px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .vote-count {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary);
            font-weight: 700;
            font-size: 20px;
        }

        .vote-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: white;
            font-size: 14px;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 700;
        }

        /* FOOTER */
        .footer {
            background: rgba(0, 0, 0, 0.9);
            color: white;
            text-align: center;
            padding: 40px;
            margin-top: 80px;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            border-top: 5px solid var(--primary);
        }

        .footer-img {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 1200px) {
            .header-section {
                flex-direction: column;
                gap: 30px;
                text-align: center;
            }
            
            .user-box, .login-box {
                min-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .header-section {
                padding: 20px;
            }
            
            .logo-section {
                flex-direction: column;
                text-align: center;
            }
            
            .logo-img {
                width: 80px;
                height: 80px;
            }
            
            .logo-text h1 {
                font-size: 24px;
            }
            
            .hero-left h2 {
                font-size: 28px;
            }
            
            .section-header h2 {
                font-size: 28px;
                padding: 15px 20px;
            }
            
            .position-grid {
                grid-template-columns: 1fr;
            }
            
            .candidate-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ANIMATIONS */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }
    </style>
</head>
<body>

<div class="main-container">
    <!-- HEADER SECTION -->
    <div class="header-section fade-in">
        <div class="logo-section">
            <!-- Logo/Image -->
            <img src="gambar/logo-school.png?v=<?= time(); ?>" 
                 alt="Logo Sekolah" 
                 class="logo-img"
                 onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"45\" fill=\"%23dc3545\"/><text x=\"50\" y=\"55\" text-anchor=\"middle\" fill=\"white\" font-size=\"40\">SG</text></svg>'">
            <div class="logo-text">
                <h1>SISTEM PENGUNDIAN KELAB OLAHRAGA</h1>
                <h2>SMK ST. GEORGE</h2>
            </div>
        </div>
        
        <!-- USER/LOGIN BOX -->
        <div class="fade-in">
            <?php if (!empty($_SESSION['tahap'])): ?>
            <div class="user-box">
                <h3><i class="fas fa-user-circle"></i> Maklumat Pengguna</h3>
                <p>Nama: <span class="user-name"><?= htmlspecialchars($_SESSION['nama']); ?></span></p>
                <div class="user-role">
                    <i class="fas fa-shield-alt"></i> <?= htmlspecialchars($_SESSION['tahap']); ?>
                </div>
                <a href="logout.php" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-sign-out-alt"></i> Log Keluar
                </a>
            </div>
            <?php else: ?>
            <div class="login-box">
                <h3><i class="fas fa-sign-in-alt"></i> Log Masuk Pengguna</h3>
                <p>Daftar atau log masuk untuk mengundi</p>
                <div class="btn-group">
                    <a href="login-borang.php" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Log Masuk
                    </a>
                    <a href="signup.php" class="btn btn-secondary">
                        <i class="fas fa-user-plus"></i> Daftar Baharu
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- HERO SECTION WITH IMAGES -->
    <div class="hero-section fade-in">
        <div class="hero-left">
            <h2>Selamat Datang ke Sistem Pengundian Digital</h2>
            <p>Sistem pengundian dalam talian yang moden dan selamat untuk pemilihan jawatan Kelab Olahraga SMK St. George. Platform ini menjamin proses pemilihan yang telus, adil dan efisien untuk semua ahli kelab.</p>
            
            <?php if (empty($_SESSION['tahap'])): ?>
            <div class="btn-group">
                <a href="login-borang.php" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Log Masuk Sekarang
                </a>
                <a href="signup.php" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Daftar Akaun Baru
                </a>
            </div>
            <?php else: ?>
            <div class="btn-group">
                <a href="vote.php" class="btn btn-primary">
                    <i class="fas fa-vote-yea"></i> Mulakan Mengundi
                </a>
                <a href="results.php" class="btn btn-secondary">
                    <i class="fas fa-chart-bar"></i> Lihat Keputusan
                </a>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="hero-right">
            <!-- Voting Image -->
            <img src="gambar/voting-system.jpg?v=<?= time(); ?>" 
                 alt="Sistem Pengundian" 
                 class="voting-img"
                 onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 400 300\"><rect width=\"400\" height=\"300\" fill=\"%23f8f9fa\"/><rect x=\"50\" y=\"50\" width=\"300\" height=\"200\" fill=\"%23dc3545\" rx=\"10\"/><circle cx=\"200\" cy=\"120\" r=\"40\" fill=\"white\"/><path d=\"M180,140 L190,160 L220,110\" fill=\"none\" stroke=\"%23dc3545\" stroke-width=\"10\" stroke-linecap=\"round\"/><text x=\"200\" y=\"220\" text-anchor=\"middle\" fill=\"white\" font-size=\"24\" font-weight=\"bold\">SISTEM PENGUNDIAN</text></svg>'">
            
            <h3 style="color: var(--primary); margin-bottom: 15px;">Daftar Sebagai Pengundi</h3>
            <p style="color: var(--gray); margin-bottom: 20px;">Klik pautan di bawah untuk menyertai pengundian</p>
            
            <div class="btn-group">
                <?php if (empty($_SESSION['tahap'])): ?>
                <a href="signup.php" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Daftar Pengguna
                </a>
                <?php else: ?>
                <p style="font-size: 18px; font-weight: 600; color: var(--primary);">
                    Anda sudah log masuk sebagai:<br>
                    <span style="color: var(--accent);"><?= htmlspecialchars($_SESSION['nama']); ?></span>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- FEATURES SECTION WITH IMAGES -->
    <div class="features-section">
        <div class="feature-card fade-in">
            <img src="gambar/secure-voting.jpg?v=<?= time(); ?>" 
                 alt="Pengundian Selamat" 
                 class="feature-img"
                 onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"45\" fill=\"%23dc3545\"/><path d=\"M35,50 L45,60 L65,40\" fill=\"none\" stroke=\"white\" stroke-width=\"8\" stroke-linecap=\"round\"/></svg>'">
            <h3>Pengundian Selamat</h3>
            <p>Sistem dilindungi dengan teknologi keselamatan terkini untuk memastikan pengundian yang adil</p>
        </div>
        
        <div class="feature-card fade-in">
            <img src="gambar/fast-process.jpg?v=<?= time(); ?>" 
                 alt="Proses Pantas" 
                 class="feature-img"
                 onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"45\" fill=\"%2328a745\"/><polygon points=\"50,30 70,70 30,70\" fill=\"white\"/></svg>'">
            <h3>Proses Pantas</h3>
            <p>Pengundian dapat diselesaikan dalam masa beberapa minit sahaja</p>
        </div>
        
        <div class="feature-card fade-in">
            <img src="gambar/real-time-results.jpg?v=<?= time(); ?>" 
                 alt="Keputusan Masa Nyata" 
                 class="feature-img"
                 onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"45\" fill=\"%23ffc107\"/><path d=\"M30,70 L40,50 L60,30 L70,50\" fill=\"none\" stroke=\"white\" stroke-width=\"8\" stroke-linecap=\"round\"/></svg>'">
            <h3>Keputusan Real-Time</h3>
            <p>Lihat keputusan undian secara langsung dan transparan</p>
        </div>
    </div>
    
    <!-- RESULTS SECTION -->
    <section class="results-section">
        <div class="section-header fade-in">
            <h2><i class="fas fa-chart-bar"></i> UNDIAN SEMASA MENGIKUT JAWATAN</h2>
        </div>
        
        <div class="position-grid">
            <?php foreach ($undian_jawatan as $data_jawatan): ?>
            <div class="position-card fade-in">
                <div class="position-header">
                    <h3><i class="fas fa-award"></i> <?= htmlspecialchars($data_jawatan['nama_jawatan']); ?></h3>
                </div>
                <div class="candidates-container">
                    <div class="candidate-grid">
                        <?php 
                        $counter = 1;
                        foreach ($data_jawatan['calon'] as $calon): 
                        ?>
                        <div class="candidate-card">
                            <span class="vote-badge">#<?= $counter; ?></span>
                            <div class="candidate-info">
                                <img src="gambar/<?= rawurlencode($calon['gambar']); ?>?v=<?= time(); ?>"
                                     alt="<?= htmlspecialchars($calon['nama_calon']); ?>"
                                     class="candidate-img">
                                <div class="candidate-details">
                                    <div class="candidate-name"><?= htmlspecialchars($calon['nama_calon']); ?></div>
                                    <div class="vote-count">
                                        <i class="fas fa-vote-yea"></i> <?= $calon['jumlah_undian']; ?> Undian
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        $counter++;
                        endforeach; 
                        ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<!-- FOOTER -->
<footer class="footer">
    <img src="gambar/footer-logo.png?v=<?= time(); ?>" 
         alt="Logo Footer" 
         class="footer-img"
         onerror="this.style.display='none'">
    <p style="font-size: 18px; margin-bottom: 10px; font-weight: 600;">Hakcipta © 2025-2026 - Sistem Pengundian Kelab Olahraga SMK St. George</p>
    <p style="opacity: 0.9;">"Memilih Pemimpin Masa Depan"</p>
</footer>

<?php include("footer.php"); ?>
</body>
</html>