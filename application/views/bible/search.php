<?php $this->load->helper('text'); ?>
<h1>Rechercher dans la Bible <small>version J.N. Darby</small></h1>
<?php echo $indexes_menu; ?>
<form class="form-horizontal">
    <div class="input-append">
        <input type="text" class="input-xlarge" name="query" value="<?php echo $query ?>" placeholder="Texte à rechercher..." />
        <button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i> Rechercher</button>
    </div>
    <div class="visible-phone"><br /></div>
    <select name="mode">
        <option value="and" <?php echo ($mode == "and") ? "selected='selected'" : ""; ?>>tous les mots (ET)</option>
        <option value="or" <?php echo ($mode == "or") ? "selected='selected'" : ""; ?>>un ou plusieurs mot(s) (OU)</option>
        <option value="literal" <?php echo ($mode == "literal") ? "selected='selected'" : ""; ?>>phrase exacte</option>
        <option value="wildcard" <?php echo ($mode == "wildcard") ? "selected='selected'" : ""; ?>>mot / phrase commençant par...</option>
        <option value="verb" <?php echo ($mode == "verb") ? "selected='selected'" : ""; ?>>formes conjuguées du verbe</option>
    </select>
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
    if ($results != null) {
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
        }
    }

    if (isset($pagination)) {
        echo $pagination;
    }
    ?>

    <?php if ($results != null): ?>
        <div class="row">
            <div class="span12">
                <div class="searchResults thumbnail">
                    <div class="searchResultsText">
                        <h2 title="Résultats de la recherche"><?php echo $resultText ?></h2>
                        <table>
                            <?php foreach ($results->result() as $result): ?>
                                <?php
                                $url = base_url() . "bible/read/" . $result->book_identifier . "/" . $result->chapter . "/" . $result->verse;
                                $link = "<a href='" . $url . "'>" . $result->book_abbreviation . " " . $result->chapter . " v." . $result->verse . "</a>";
                                ?>
                                <tr>
                                    <td class="searchVerseNumber">
                                        <?php echo $link; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $string = $result->text;
                                            
                                            // highlighting words corresponding to the query entered by the user
                                            if (isset($flections)) {
                                                foreach($flections->result() as $flection) {
                                                    $array[] = $flection->stem.$flection->ending;
                                                }
                                                
                                                $string = preg_replace('~('.implode('|', $array).'[a-zA-Z]{0,45})(?![^<]*[>])~is', '<span style="background-color:#D9EDF7;">$0</span>', $string);
                                            }else {
                                                $string = preg_replace('~('.$query.'[a-zA-Z]{0,45})(?![^<]*[>])~is', '<span style="background-color:#D9EDF7;">$0</span>', $string);
                                            }
                                        ?>
                                        
                                        <?php echo $string; ?>
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