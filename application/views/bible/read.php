<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.browser.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.scrollto.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/utilities.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bibleRead.js"></script>

<?php if (isset($bibleBookNotFoundException)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <strong>Erreur:</strong> <?php echo $bibleBookNotFoundException->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php

        if ($book->name == "Psaumes") {
            $book->name = $book->complete_name = "Psaume";
            $chapter_text = " " . $chapter;
            $pagination_chapter_text = "Psaume";
        } else {
            $chapter_text = ", chapitre " . $chapter;

            if ($book->chapters == 1) { // not showing chapter number if the book has only one chapter
                $chapter = "";
                $chapter_text = "";
            }

            $pagination_chapter_text = "chapitre";
        }

    ?>

    <h1 title="<?php echo $book->complete_name . $chapter_text; ?>"><?php echo $book->name . " " . $chapter; ?></h1>
    <?php echo $indexes_menu; ?>
    <?php if (isset($exception)): ?>
        <div class="row">
            <div class="span12">
                <div class="alert">
                    <strong>Erreur:</strong> <?php echo $exception->getMessage(); ?>
                </div>
            </div>
        </div>
    <?php else: ?>

        <?php

            echo $pagination;

        ?>

        <div class="row">
            <div class="span12">
                <div class="chapter thumbnail">
                    <div class="chapterText">
                        <table>
                            <?php foreach ($verses as $verse): ?>
                                <tr>
                                    <?php if ($verse->verse == 0): ?>
                                        <td colspan="2" class="chapterHeader"><small><?php echo $verse->text; ?></small></td>
                                    <?php else: ?>
                                        <td id="verse<?php echo $verse->verse; ?>" class="verseNumber"><?php echo $verse->verse; ?></td>
                                        <td><?php echo $verse->text; ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $pagination; ?>

        <br />
    <?php endif; ?>
<?php endif; ?>