<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.browser.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.scrollto.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/utilities.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/songsReadAll.js"></script>

<?php if (isset($exception)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <strong>Erreur:</strong> <?php echo $exception->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1><?php echo $hymn_book_name; ?></h1>
    <?php echo $indexes_menu; ?>
    <div class="row">
        <div class="span12" style="text-align:center;">
            <form class="form-inline">
                <div class="input-append">
                    <label class="control-label">Aller au cantique: <input id="goto_song_value" type="text" maxlength="3" class="input-mini" style="width:40px;" placeholder="n°" /></label>
                    <button class="btn btn-primary" type="submit" id="goto_song_submit">ok</button>
                </div>
            </form>
        </div>
    </div>
    <?php $song_number_mem = null; ?>
    <?php foreach ($songs_verses as $verse_data): ?>
        <?php if ($verse_data->song_number != $song_number_mem): ?>
            <?php if ($verse_data->song_number != 1): ?>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row" id="song<?php echo $verse_data->song_number; ?>">
                <br /><br />
                <div class="span12">
                    <h2>Cantique <?php echo $verse_data->song_number; ?></h2>
                    <?php echo "<a href='".base_url()."songs/read/".$hymn_book_identifier."/".$verse_data->song_number."'>détails</a>"; ?>
                    <br />
                    <table>
        <?php endif; ?>
            <tr>
                <td id="verse<?php echo $verse_data->verse; ?>" class="songVerseNumber">
                    <?php
                        if ($verse_data->verse == 0) {
                            $verset = "refrain";
                        }else {
                            $verset = $verse_data->verse;
                        }

                        echo $verset.": ";
                    ?>
                </td>
                <td class="songVerseText">
                    <?php echo nl2br($verse_data->text); ?>
                </td>
                <?php $song_number_mem = $verse_data->song_number; ?>
            </tr>
    <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>