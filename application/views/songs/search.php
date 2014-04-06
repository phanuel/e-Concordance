<script type="text/javascript" src="<?php echo base_url(); ?>js/songsSearch.js"></script>

<?php if (isset($hymnBookNotFoundException)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert alert-error">
                <span class="label label-important">Erreur</span> <?php echo $hymnBookNotFoundException->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1><?php echo $hymn_book_name; ?> - recherche</h1>
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
                <div class="alert alert-error">
                    <span class="label label-important">Erreur</span> <?php echo $exception->getMessage(); ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php if ($mode == "verb" && $count > 0): ?>
            <div class="row">
                <div class="span12">
                    <div class="alert alert-info">
                        <span class="label label-info">Attention</span> Des résultats inattendus peuvent être retournés. Par exemple, une recherche sur le verbe "pleuvoir" englobera sans distinction les versets contenant le participe passé "plu" du verbe <b>plaire</b>, qui est homographe avec celui du verbe pleuvoir.
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if ($count != null) {
            $prefix = $suffix = "";
            
            if ($count == 0) {
                $prefix = "Pas de résultat";
                $suffix = " avec ce mode de recherche";
            } else if ($count == 1) {
                $prefix = "1 occurence";
            } else {
                $prefix = $count . " occurences";
            }

            $resultText = $prefix . " pour <i>" . $query . "</i>" . $suffix;

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
                    <div class="searchResults<?php echo ($count == 0) ? " alert" : " thumbnail"; ?>">
                        <div class="searchResultsText">
                            <h2 title="Résultats de la recherche"><?php echo $resultText ?></h2>
                            <?php if ($count > 0): ?>
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

                                                <?php echo nl2br($string); ?><br />
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php else: ?>
                                <p>
                                    <span class="label label-warning">Important</span>
                                    Vérifiez que vos termes de recherche sont correctement orthographiés et lisez attentivement les instructions ci-dessous afin d'éviter toute mauvaise manipulation.
                                </p>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($count == null || $count == 0): ?>
            <div class="row">
                <div class="span8 offset2 searchHelp">
                    <h2>Modes de recherche</h2>
                    <ul>
                        <li>
                            <h3>par mots (ordre indifférent)</h3>
                            <p>À utiliser dans la plupart des cas.</p>
                            <p>
                                <span class="label label-info">Exemple</span>
                                Pour trouver ce verset qui parle d'une profonde et pure source où puise la foi, faites une recherche avec pour mots-clés: "<a href="<?php echo base_url(); ?>songs/search/<?php echo $hymn_book_identifier; ?>?query=profonde+source&mode=and">profonde source</a>" ou "<a href="<?php echo base_url(); ?>songs/search/<?php echo $hymn_book_identifier; ?>?query=pure+source&mode=and">pure source</a>".
                            </p>
                            <p>
                                <span class="label label-important">Attention</span>
                                Évitez de rechercher des vers entiers tels que: "profonde et pure source où puise la foi", qui ne retourneront aucun résultat, car le vers en question est en réalité: "Profonde et pure source où <b>vient puiser</b> la foi".
                            </p>
                            <p>La ponctuation et l'ordre des mots ne sont pas pris en compte dans ce mode de recherche.</p>
                        </li>
                        <li>
                            <h3>chaîne de caractères</h3>
                            <p>Se borne strictement à l'enchaînement des caractères recherchés. Utile pour la recherche de mots basés sur le même radical.</p>
                            <p>
                                <span class="label label-info">Exemple</span>
                                Pour trouver tous les mots basés sur le morphème "faibl" (<b>faibl</b>e, <b>faibl</b>esse, af<b>faibl</b>i, etc.): rechercher "<a href="<?php echo base_url(); ?>songs/search/<?php echo $hymn_book_identifier; ?>?query=faibl&mode=literal">faibl</a>" avec ce mode de recherche.
                            </p>
                            <p>
                                <span class="label label-important">Attention</span>
                                Des résultats inattendus peuvent être retournés. Par exemple, une recherche sur le morphème "<a href="<?php echo base_url(); ?>songs/search/<?php echo $hymn_book_identifier; ?>?query=tendr&mode=literal">tendr</a>" (<b>tendr</b>e, <b>tendr</b>es, <b>tendr</b>esse, etc.) retournera aussi "at<b>tendr</b>e" et "en<b>tendr</b>e".
                            </p>
                            <p>La ponctuation est prise en compte dans la chaîne de caractères.</p>
                        </li>
                        <li>
                            <h3>formes conjuguées du verbe</h3>
                            <p>À partir de l'<b>infinitif</b> d'un verbe, trouve les versets contenant les différentes formes conjuguées.</p>
                            <p>
                                <span class="label label-info">Exemple</span>
                                Utilisez ce mode de recherche pour trouver toutes les occurences du verbe "<a href="<?php echo base_url(); ?>songs/search/<?php echo $hymn_book_identifier; ?>?query=jaillir&mode=verb">jaillir</a>".
                            </p>
                            <p>
                            <span class="label label-important">Attention</span>
                            Des résultats inattendus peuvent être retournés. Par exemple, une recherche sur le verbe "<a href="<?php echo base_url(); ?>songs/search/<?php echo $hymn_book_identifier; ?>?query=pleuvoir&mode=verb">pleuvoir</a>" englobera sans distinction les versets contenant le participe passé "plu" du verbe <b>plaire</b>, qui est homographe avec celui du verbe pleuvoir.
                        </p>
                        <p>Ce mode de recherche est considérablement plus lent car il nécessite une requête prenant en compte toutes les déclinaisons possibles du verbe en question, soit plus d'une cinquantaine dans la plupart des cas.</p>
                        </li>
                    </ul>
                    <h2>Il y a un problème ?</h2>
                    <p>N'hésitez pas à nous le signaler via notre <a href='<?php echo base_url(); ?>index/contact'>formulaire de contact</a>.</p>
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