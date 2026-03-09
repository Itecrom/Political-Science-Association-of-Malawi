<?php
// includes/meta.php
// ----------------------BY LEONARD JJRA MHONE--------------------
// Shared <meta> & <title> tags for the whole site.
// Before including this file you can (optionally) define:
//   $page_title        – page‑specific title
//   $meta_description  – page‑specific description
//   $meta_keywords     – comma‑separated keywords (optional)
//   $extra_meta        – any additional <meta>/<link> markup (optional)
// -------------------------------------------------------------

$site_title       = 'Malawi Political Science Association';
$site_description = 'Official website of the Malawi Political Science Association (PSA).';

$page_title       = $page_title       ?? $site_title;
$meta_description = $meta_description ?? $site_description;
$meta_keywords    = $meta_keywords    ?? '';
?>
<meta charset="utf-8">
<title><?= htmlspecialchars($page_title) ?></title>

<!-- mobile & scaling -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- SEO -->
<meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
<?php if ($meta_keywords): ?>
<meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">
<?php endif; ?>

<!-- Open Graph / Social -->
<meta property="og:type"        content="website">
<meta property="og:title"       content="<?= htmlspecialchars($page_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($meta_description) ?>">
<meta property="og:url"         content="<?= htmlspecialchars(($_SERVER['REQUEST_SCHEME'] ?? 'https'). '://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>">

<!-- Favicon -->
<link rel="icon" href="/images/favicon.png" type="image/png">

<?php // Page‑specific additional tags
if (!empty($extra_meta)) echo $extra_meta; ?>
