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
        <div class="span12">
            <?php echo ($letter == "a") ? "<b>A</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/a">A</a>' ?> |
            <?php echo ($letter == "b") ? "<b>B</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/b">B</a>' ?> |
            <?php echo ($letter == "c") ? "<b>C</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/c">C</a>' ?> |
            <?php echo ($letter == "d") ? "<b>D</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/d">D</a>' ?> |
            <?php echo ($letter == "e") ? "<b>E</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/e">E</a>' ?> |
            <?php echo ($letter == "f") ? "<b>F</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/f">F</a>' ?> |
            <?php echo ($letter == "g") ? "<b>G</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/g">G</a>' ?> |
            <?php echo ($letter == "h") ? "<b>H</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/h">H</a>' ?> |
            <?php echo ($letter == "i") ? "<b>I</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/i">I</a>' ?> |
            <?php echo ($letter == "j") ? "<b>J</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/j">J</a>' ?> |
            K |
            <?php echo ($letter == "l") ? "<b>L</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/l">L</a>' ?> |
            <?php echo ($letter == "m") ? "<b>M</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/m">M</a>' ?> |
            <?php echo ($letter == "n") ? "<b>N</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/n">N</a>' ?> |
            <?php echo ($letter == "o") ? "<b>O</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/o">O</a>' ?> |
            <?php echo ($letter == "p") ? "<b>P</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/p">P</a>' ?> |
            <?php echo ($letter == "q") ? "<b>Q</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/q">Q</a>' ?> |
            <?php echo ($letter == "r") ? "<b>R</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/r">R</a>' ?> |
            <?php echo ($letter == "s") ? "<b>S</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/s">S</a>' ?> |
            <?php echo ($letter == "t") ? "<b>T</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/t">T</a>' ?> |
            <?php echo ($letter == "u") ? "<b>U</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/u">U</a>' ?> |
            <?php echo ($letter == "v") ? "<b>V</b>" : '<a href="'.base_url().'songs/index/'.$hymn_book_identifier.'/v">V</a>' ?> |
            W |
            X |
            Y |
            Z
        </div>
    </div>
    <br />
    <div class="row">
        <div class="span12">
            <table width="100%" class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>
                            Paroles
                        </th>
                        <th>
                            Cant.
                        </th>
                        <th style="text-align:right;">
                            Vers.
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($verses_data as $verse_data): ?>
                        <?php
                            $style = "";
                            $verse = $verse_data->verse;
                            if ($verse_data->verse == 1)
                            {
                                $style .= "font-weight:bold;";
                                $verse = "";
                            }

                            if ($verse_data->verse != 1) {
                                $link = base_url()."songs/read/".$hymn_book_identifier."/".$verse_data->song_number."/".$verse_data->verse;
                            }else {
                                $link = base_url()."songs/read/".$hymn_book_identifier."/".$verse_data->song_number;
                            }
                        ?>
                        <tr style="<?php echo $style; ?>">
                            <td>
                                <a href="<?php echo $link; ?>"><?php echo $verse_data->text; ?> ...</a><br />
                            </td>
                            <td width="30">
                                <a href="<?php echo $link; ?>"><?php echo $verse_data->song_number; ?></a><br />
                            </td>
                            <td width="20" style="text-align:right;">
                                <a href="<?php echo $link; ?>"><?php echo $verse; ?></a><br />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br /><br />
        </div>
    </div>
<?php endif; ?>