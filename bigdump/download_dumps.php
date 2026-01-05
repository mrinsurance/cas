<?php
$files = glob(__DIR__ . '/*.sql.gz');
if (!$files) {
    die('❌ No .sql.gz files found');
}
?>

<h2>Download Database Dumps (.sql.gz)</h2>
<p>Click the button below and allow multiple downloads when prompted.</p>

<button onclick="downloadAll()" style="padding:10px 15px;font-size:16px;">
    ⬇️ Download All
</button>

<hr>

<?php foreach ($files as $file): ?>
    <a href="<?= basename($file) ?>" download><?= basename($file) ?></a><br>
<?php endforeach; ?>

<script>
function downloadAll() {
    <?php foreach ($files as $file): ?>
        window.open("<?= basename($file) ?>", "_blank");
    <?php endforeach; ?>
}
</script>
