<?php if (isset($exception)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <strong>Erreur:</strong> <?php echo $exception->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
<?php header("Content-type: application/octet-stream"); ?>
<?php header("Content-Disposition: attachment; filename=\"" . $hymn_book_identifier . "_index.csv\""); ?>
<?php foreach ($letters_index as $letter_index): ?>
<?php foreach ($letter_index as $verse_data): ?>
<?php echo "\"" . str_replace("\"", "\"\"", $verse_data->text) . "...\";" . $verse_data->song_number . ";" . $verse_data->verse . "\n"; ?>
<?php endforeach; ?>
<?php endforeach; ?>
<?php endif; ?>