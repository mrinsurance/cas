<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Database Operations Panel</title>
    <meta name="robots" content="noindex,nofollow">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 20px;
        }
        h1 {
            margin-bottom: 10px;
        }
        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .desc {
            color: #555;
            font-size: 14px;
            margin-bottom: 10px;
        }
        a.button {
            display: inline-block;
            padding: 10px 14px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }
        a.button.danger {
            background: #c82333;
        }
        a.button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<h1>Database Operations Panel</h1>
<p style="color:#666;">Click a button to run the corresponding operation. Each action opens in a new tab.</p>

<div class="card">
    <h3>Export Databases</h3>
    <div class="desc">Generate database backup dumps.</div>
    <a class="button" target="_blank"
       href="https://casadarsh.himachalsoceity.com/db-export/runner?secret=hp20nbd">
        Run DB Export
    </a>
</div>

<div class="card">
    <h3>Clean Databases</h3>
    <div class="desc">Run database cleanup process.</div>
    <a class="button" target="_blank"
       href="https://casadarsh.himachalsoceity.com/db-cleaner/run">
        Run DB Cleaner
    </a>
</div>

<div class="card">
    <h3>Import Databases (BigDump)</h3>
    <div class="desc">Reset queue and import all databases using BigDump.</div>
    <a class="button danger" target="_blank"
       onclick="return confirm('This will RESET and re-import all databases. Continue?')"
       href="https://casadarsh.himachalsociety.com/bigdump/controller.php?secret=hp20nbd&reset=1">
        Reset & Start Import
    </a>
</div>

<div class="card">
    <h3>Copy Dump Files</h3>
    <div class="desc">Copy all <code>.sql.gz</code> files from storage to BigDump directory.</div>
    <a class="button" target="_blank"
       href="https://casadarsh.himachalsoceity.com/copy_dumps.php">
        Copy Dump Files
    </a>
</div>

<div class="card">
    <h3>Download Dumps</h3>
    <div class="desc">Download all <code>.sql.gz</code> files (browser may ask to allow pop-ups).</div>
    <a class="button" target="_blank"
       href="https://casadarsh.himachalsoceity.com/bigdump/download_dumps.php">
        Download Dumps
    </a>
</div>

<div class="card">
    <h3>Delete Dumps (BigDump)</h3>
    <div class="desc">Delete all dump files from <code>/bigdump</code> directory.</div>
    <a class="button danger" target="_blank"
       onclick="return confirm('This will DELETE all dumps from /bigdump. Continue?')"
       href="https://casadarsh.himachalsoceity.com/delete_bigdump_dumps.php">
        Delete BigDump Dumps
    </a>
</div>

<div class="card">
    <h3>Delete Dumps (Storage)</h3>
    <div class="desc">Delete all dump files from <code>storage/db-imports</code>.</div>
    <a class="button danger" target="_blank"
       onclick="return confirm('This will DELETE all dumps from storage. Continue?')"
       href="https://casadarsh.himachalsoceity.com/delete_storage_dumps.php">
        Delete Storage Dumps
    </a>
</div>

</body>
</html>
