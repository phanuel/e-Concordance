<script type="text/javascript" src="<?php echo base_url(); ?>js/songsSearch.js"></script>

<?php if (isset($hymnBookNotFoundException)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <strong>Erreur:</strong> <?php echo $hymnBookNotFoundException->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1><?php echo $hymn_book_name; ?> - Recherche</h1>
    <?php echo $indexes_menu; ?>
    <form class="form-horizontal">
        <div class="input-append">
            <input type="text" class="input-xlarge" name="query" value="<?php echo $query ?>" placeholder="Texte à rechercher..." />
            <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Rechercher</button>
        </div>
        <div class="visible-phone"><br /></div>
        <select name="mode">
            <option value="and" <?php echo ($mode == "and") ? "selected='selected'" : ""; ?>>par mots (ordre indifférent)</option>
            <option value="literal" <?php echo ($mode == "literal") ? "selected='selected'" : ""; ?>>chaîne de caractères</option>
            <option value="verb" <?php echo ($mode == "verb") ? "selected='selected'" : ""; ?>>formes conjuguées du verbe</option>
        </select>
        <span style="margin-left:8px;"><a href="" id="optionsLink">Options</a></span>
        <div id="options" <?php echo ($case_sensitive == true || $accents_sensitive == true) ? "" : "style='display:none;'"; ?>>
            <label><input type="checkbox" name="cs" <?php echo $case_sensitive == true ? "checked='checked'" : ""; ?> /> sensible à la casse</label>
            <label><input type="checkbox" name="as" <?php echo $accents_sensitive == true ? "checked='checked'" : ""; ?> /> sensible à l'accentuation</label>
        </div>
    </form>

    <?php if (isset($exception)): ?>
        <div class="row">
            <div class="span12">
                <div class="alert">
                    <strong>Erreur:</strong> <?php echo $exception->getMessage(); ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php if ($mode == "verb"): ?>
            <div class="row">
                <div class="span12">
                    <div class="alert alert-info">
                        <strong>Attention:</strong> Ce mode de recherche peut retourner des résultats inattendus. Par exemple, une recherche sur le verbe "taire" englobera sans distinction les versets contenant le passé composé "tu" et le pronom "tu" qui sont homographes.
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if ($count != null) {
            $n = $count;

            if ($n == 0) {
                $prefix = "Pas de résultat";
            } else if ($n == 1) {
                $prefix = "1 occurence";
            } else {
                $prefix = $n . " occurences";
            }

            $resultText = $prefix . " pour <i>" . $query . "</i>";

            if ($mode == "verb") {
                $resultText .= " <small>(formes conjuguées du verbe)</small>";
            }elseif ($mode == "literal") {
                $resultText .= " <small>(chaîne de caractères)</small>";
            }
        }

        if (isset($pagination)) {
            echo $pagination;
        }
        ?>

        <?php if ($count != null): ?>
            <div class="row">
                <div class="span12">
                    <div class="searchResults thumbnail">
                        <div class="searchResultsText">
                            <h2 title="Résultats de la recherche"><?php echo $resultText ?></h2>
                            <table>
                                <?php foreach ($results as $result): ?>
                                    <?php
                                    $url = base_url() . "songs/read/" . $hymn_book_identifier . "/" . $result->song_number . "/" . $result->verse;

                                    if ($result->verse == 0) {
                                        $verse = "refrain";
                                    }else {
                                        $verse = "verset ".$result->verse;
                                    }

                                    $link = "<a href='" . $url . "'>" . $result->song_number ."</a>";
                                    ?>
                                    <tr>
                                        <td class="searchSongNumber">
                                            <h1><?php echo $link; ?></h1>
                                            <div style="font-size:0.9em;"><?php echo $verse; ?></div>
                                        </td>
                                        <td class="songVerseText">
                                            <?php
                                                $string = $result->text;
                                                $highlighted = '<span style="background-color:#D9EDF7;">$0</span>';

                                                // highlighting words corresponding to the query entered by the user
                                                if (isset($flections)) {
                                                    foreach($flections->result() as $flection) {
                                                        $array[] = $flection->stem.$flection->ending;
                                                    }

                                                    $string = preg_replace('~('.implode('|', $array).'[a-zA-Z]{0,45})(?![^<]*[>])~is', $highlighted, $string);
                                                }else {
                                                    if ($case_sensitive == true) {
                                                        $string = preg_replace('~('.$query.'[a-zA-Z]{0,45})(?![^<]*[>])~s', $highlighted, $string);
                                                    }else {
                                                        $string = preg_replace('~('.$query.'[a-zA-Z]{0,45})(?![^<]*[>])~is', $highlighted, $string);
                                                    }
                                                }
                                            ?>

                                            <?php echo nl2br($string); ?><br /><br />
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if (isset($pagination)) {
            echo $pagination;
        }
        ?>
        <br />
    <?php endif; ?>
<?php endif; ?>