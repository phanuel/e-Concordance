<h1>La Bible <small>version J.N. Darby</small></h1>
<?php echo $indexes_menu; ?>
<?php
// Old Testament books
// pushing results into an array
$books_at_array = Array();
foreach ($books_at as $book_at) {
    array_push($books_at_array, $book_at);
}

// dividing array into sections of 10 items
$books_at_columns = array_chunk($books_at_array, 10);

// New Testament books
// pushing results into an array
$books_nt_array = Array();
foreach ($books_nt as $book_nt) {
    array_push($books_nt_array, $book_nt);
}

// dividing array into sections of 7 items
$books_nt_columns = array_chunk($books_nt_array, 7);
?>

<div class="row">
    <div class="span12">
        <h2>Ancien Testament</h2>
    </div>
</div>

<div class="row">
    <?php foreach ($books_at_columns as $books_at_column): ?>
        <div class="span3">
            <?php foreach ($books_at_column as $book_at): ?>
                <a href="<?php echo base_url()."bible/read/".$book_at->identifier; ?>" title="<?php echo $book_at->complete_name; ?>"><?php echo $book_at->name; ?></a><br />
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="span12">
        <h2 class="newTestament">Nouveau Testament</h2>
    </div>
</div>

<div class="row newTestament">
    <?php foreach ($books_nt_columns as $books_nt_column): ?>
        <div class="span3">
            <?php foreach ($books_nt_column as $book_nt): ?>
                <a href="<?php echo base_url()."bible/read/".$book_nt->identifier; ?>" title="<?php echo $book_nt->complete_name; ?>"><?php echo $book_nt->name; ?></a><br />
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>