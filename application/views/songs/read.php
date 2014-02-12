<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.browser.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.scrollto.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/utilities.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/songsRead.js"></script>

<?php if (isset($exception)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <strong>Erreur:</strong> <?php echo $exception->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1><?php echo $hymn_book_name; ?> - n°<?php echo $song_number; ?></h1>
    <?php echo $indexes_menu; ?>
    <?php if (isset($pagination)) {echo $pagination;} ?>
    <br />
    <div class="row">
        <div class="span8">
            <table>
                <?php foreach ($song_verses as $verse_data): ?>
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
                        <td>
                            <?php echo nl2br($verse_data->text); ?><br /><br />
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="span4">
            <?php if ($song[0]->pdf_file != null): ?>
            <div class="well">
                <?php $pdf_link = base_url() . 'pdf/'.$song[0]->pdf_file; ?>
                <a href="<?php echo $pdf_link; ?>"><i class="icon-music"></i></a> <a href="<?php echo $pdf_link; ?>">Partition</a><br />
            </div>
            <?php endif; ?>
            <?php if (!($song[0]->lyrics_author_id == null && $song[0]->song_meter_id == null && $song[0]->melody_author_id == null && $song[0]->song_melody_name1 == null)): ?>
                <div class="well">
                    <i class="icon-info-sign"></i> <b>Détails</b>
                    <?php if (!($song[0]->lyrics_author_id == null && $song[0]->song_meter_id == null)): ?>
                        <hr />
                        <b>Paroles:</b>
                        <?php if ($song[0]->lyrics_author_id != null): ?>
                            <div>
                                <?php
                                    $dates = "";
                                    if ($song[0]->lyrics_author_birth_year != null || $song[0]->lyrics_author_death_year != null) {
                                        if ($song[0]->lyrics_author_birth_year == null) {
                                            $song[0]->lyrics_author_birth_year = "?";
                                        }
                                        if ($song[0]->lyrics_author_death_year == null) {
                                            $song[0]->lyrics_author_death_year = "?";
                                        }
                                        $dates = "(".$song[0]->lyrics_author_birth_year." - ".$song[0]->lyrics_author_death_year.")";
                                    }
                                ?>
                                <?php echo "<a href='".base_url()."songs/index_authors_lyrics/".$hymn_book_identifier."/".$song[0]->lyrics_author_id."'>".$song[0]->lyrics_author_first_name." ".$song[0]->lyrics_author_last_name."</a> ".$dates; ?>
                                <?php
                                    if ($song[0]->lyrics_author2_last_name != null) {
                                        $dates = "";
                                        if ($song[0]->lyrics_author2_birth_year != null || $song[0]->lyrics_author2_death_year != null) {
                                            if ($song[0]->lyrics_author2_birth_year == null) {
                                                $song[0]->lyrics_author2_birth_year = "?";
                                            }
                                            if ($song[0]->lyrics_author2_death_year == null) {
                                                $song[0]->lyrics_author2_death_year = "?";
                                            }
                                            $dates = "(".$song[0]->lyrics_author2_birth_year." - ".$song[0]->lyrics_author2_death_year.")";
                                        }
                                        echo " et <a href='".base_url()."songs/index_authors_lyrics/".$hymn_book_identifier."/".$song[0]->lyrics_author2_id."'>".$song[0]->lyrics_author2_first_name." ".$song[0]->lyrics_author2_last_name."</a> ".$dates;
                                    }
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php
                            if ($song[0]->remarks != null) {
                                echo nl2br($song[0]->remarks)."<br />";
                            }
                        ?>
                        <?php if ($song[0]->song_meter_id != null): ?>
                            <br />
                            Mètre:<br />
                            <?php echo "<a href='".base_url()."songs/index_meters/".$hymn_book_identifier."/".$song[0]->song_meter_digits."/".$song[0]->song_meter_id."'>".$song[0]->meter."</a>"; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!($song[0]->melody_author_id == null && $song[0]->song_melody_name1 == null)): ?>
                        <hr />
                        <b>Musique:</b><br />
                        <?php if ($song[0]->melody_author_id != null): ?>
                            <div>
                                <?php
                                    $dates = "";
                                    if ($song[0]->melody_author_birth_year != null || $song[0]->melody_author_death_year != null) {
                                        if ($song[0]->melody_author_birth_year == null) {
                                            $song[0]->melody_author_birth_year = "?";
                                        }
                                        if ($song[0]->melody_author_death_year == null) {
                                            $song[0]->melody_author_death_year = "?";
                                        }
                                        $dates = "(".$song[0]->melody_author_birth_year." - ".$song[0]->melody_author_death_year.")";
                                    }
                                ?>
                                <?php echo "<a href='".base_url()."songs/index_authors_melodies/".$hymn_book_identifier."/".$song[0]->melody_author_id."'>".$song[0]->melody_author_first_name." ".$song[0]->melody_author_last_name."</a> ".$dates; ?>
                            </div>
                            <?php
                                if ($song[0]->melody_remarks != null) {
                                    echo nl2br($song[0]->melody_remarks)."<br />";
                                }
                            ?>
                        <?php endif; ?>
                        <?php if ($song[0]->song_melody_name1 != null): ?>
                            <br />
                            Mélodie:<br />
                            <?php
                                $string = str_replace(Array("«", "»"), "", $song[0]->song_melody_name1);
                                $string = mb_strtolower($string);
                                $translate_array = Array("á" => "a", "ä" => "a", "à" => "a", "â" => "a", "é" => "e", "ë" => "e", "è" => "e", "ê" => "e", "î" => "i", "ó" => "o", "ö" => "o", "ò" => "o", 'ô' => 'o', "û" => "u", "ü" => "u");
                                $string = strtr($string, $translate_array);
                                $letter = $string[0];
                            ?>
                            <?php echo "<a href='".base_url()."songs/index_melodies/".$hymn_book_identifier."/".$letter."/".$song[0]->song_melody_id."'>" .$song[0]->song_melody_name1. "</a>"; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>