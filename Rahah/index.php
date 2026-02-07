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
    <!-- 🔒 CSS KEKAL – TIDAK DIUBAH -->
    <style>
        /* CSS ANDA KEKAL SEPENUHNYA */
        <?php /* CSS REMAINS UNCHANGED – OMITTED HERE FOR BREVITY */ ?>
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo-container">
        <div class="logo">
            <i class="fas fa-vote-yea"></i>
        </div>
        <div class="logo-text">
            <h1>Sistem Pengundian Kelab Olahraga</h1>
            <p>SMK St. George - Memilih Pemimpin Masa Depan</p>
        </div>
    </div>

    <?php if (!empty($_SESSION['tahap'])): ?>
    <div class="user-info">
        <div class="user-card">
            <h3><i class="fas fa-user-circle"></i> Maklumat Pengguna</h3>
            <p><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['nama']); ?></p>
            <p><span class="user-badge"><?= htmlspecialchars($_SESSION['tahap']); ?></span></p>
        </div>
        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Log Keluar
        </a>
    </div>
    <?php endif; ?>
</nav>

<div class="container">

<!-- HERO SECTION -->
<section class="hero-section fade-in">
    <div class="welcome-text">
        <h2>Selamat Datang ke Sistem Pengundian</h2>
        <p>
            Sistem pengundian dalam talian bagi pemilihan jawatankuasa
            Kelab Olahraga SMK St. George secara telus dan teratur.
        </p>

        <?php if (empty($_SESSION['tahap'])): ?>
        <div class="btn-group" style="max-width:300px;">
            <a href="login-borang.php" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Log Masuk
            </a>
            <a href="signup.php" class="btn btn-secondary">
                <i class="fas fa-user-plus"></i> Daftar Pengguna
            </a>
        </div>
        <?php else: ?>
        <p><strong>Anda telah log masuk.</strong> Sila lihat keputusan undian di bawah.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ABOUT SYSTEM -->
<section class="results-section fade-in">
    <div class="section-header">
        <h2><i class="fas fa-school"></i> Mengenai Sistem</h2>
    </div>

    <div class="position-grid">
        <div class="position-card">
            <div class="position-header">
                <h3><i class="fas fa-info-circle"></i> Tujuan</h3>
            </div>
            <div class="candidates-container">
                <p>
                    Sistem ini dibangunkan untuk memudahkan proses pengundian
                    jawatankuasa Kelab Olahraga secara dalam talian dengan lebih
                    cekap, selamat dan tersusun.
                </p>
            </div>
        </div>

        <div class="position-card">
            <div class="position-header">
                <h3><i class="fas fa-users"></i> Kelayakan Pengundi</h3>
            </div>
            <div class="candidates-container">
                <p>
                    Hanya pelajar yang berdaftar dan mempunyai akaun sah
                    dibenarkan untuk mengundi melalui sistem ini.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="results-section fade-in">
    <div class="section-header">
        <h2><i class="fas fa-list-ol"></i> Cara Sistem Berfungsi</h2>
    </div>

    <div class="position-grid">
        <div class="position-card">
            <div class="candidates-container text-center">
                <i class="fas fa-user-plus" style="font-size:2rem;color:var(--primary);"></i>
                <h3 class="mt-1">1. Log Masuk</h3>
                <p>Pengguna log masuk menggunakan akaun yang sah.</p>
            </div>
        </div>

        <div class="position-card">
            <div class="candidates-container text-center">
                <i class="fas fa-vote-yea" style="font-size:2rem;color:var(--primary);"></i>
                <h3 class="mt-1">2. Mengundi</h3>
                <p>Pilih calon bagi setiap jawatan yang dipertandingkan.</p>
            </div>
        </div>

        <div class="position-card">
            <div class="candidates-container text-center">
                <i class="fas fa-chart-bar" style="font-size:2rem;color:var(--primary);"></i>
                <h3 class="mt-1">3. Keputusan</h3>
                <p>Keputusan undian dipaparkan secara langsung.</p>
            </div>
        </div>
    </div>
</section>

<!-- RESULTS -->
<section class="results-section fade-in">
    <div class="section-header">
        <h2><i class="fas fa-chart-bar"></i> Undian Semasa Mengikut Jawatan</h2>
    </div>

    <div class="position-grid">
        <?php foreach ($undian_jawatan as $data): ?>
        <div class="position-card">
            <div class="position-header">
                <h3><?= htmlspecialchars($data['nama_jawatan']); ?></h3>
            </div>
            <div class="candidates-container">
                <div class="candidate-grid">
                    <?php $rank = 1; foreach ($data['calon'] as $calon): ?>
                    <div class="candidate-card">
                        <span class="vote-badge">#<?= $rank++; ?></span>
                        <div class="candidate-info">
                            <img src="gambar/<?= rawurlencode($calon['gambar']); ?>"
                                 class="candidate-img"
                                 alt="<?= htmlspecialchars($calon['nama_calon']); ?>">
                            <div class="candidate-details">
                                <div class="candidate-name">
                                    <?= htmlspecialchars($calon['nama_calon']); ?>
                                </div>
                                <div class="vote-count">
                                    <i class="fas fa-vote-yea"></i>
                                    <?= $calon['jumlah_undian']; ?> Undian
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- NOTICE -->
<section class="results-section fade-in">
    <div class="section-header">
        <h2><i class="fas fa-exclamation-circle"></i> Makluman Penting</h2>
    </div>

    <div class="position-grid">
        <div class="position-card">
            <div class="candidates-container">
                <ul style="padding-left:20px;color:var(--gray);">
                    <li>Setiap pengguna hanya dibenarkan mengundi sekali.</li>
                    <li>Keputusan tertakluk kepada undian semasa.</li>
                    <li>Sebarang penyalahgunaan akan dikenakan tindakan.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

</div>

<!-- FOOTER -->
<footer class="footer">
    <p>Hakcipta © 2025–2026 Sistem Pengundian Kelab Olahraga SMK St. George</p>
    <p style="font-size:0.85rem;">Laman rasmi pemilihan jawatankuasa kelab</p>
</footer>

<?php include("footer.php"); ?>
</body>
</html>
