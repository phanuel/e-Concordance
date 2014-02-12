<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.browser.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.scrollto.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/utilities.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/index-melodies.js"></script>

<?php if (isset($exception)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <strong>Erreur:</strong> <?php echo $exception->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1><?php echo $hymn_book_name; ?> - mélodies</h1>
    <?php echo $indexes_menu; ?>
    <div class="row">
        <div class="span12">
            <?php echo ($letter == "a") ? "<b>A</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/a">A</a>' ?> |
            <?php echo ($letter == "b") ? "<b>B</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/b">B</a>' ?> |
            <?php echo ($letter == "c") ? "<b>C</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/c">C</a>' ?> |
            <?php echo ($letter == "d") ? "<b>D</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/d">D</a>' ?> |
            <?php echo ($letter == "e") ? "<b>E</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/e">E</a>' ?> |
            <?php echo ($letter == "f") ? "<b>F</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/f">F</a>' ?> |
            <?php echo ($letter == "g") ? "<b>G</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/g">G</a>' ?> |
            <?php echo ($letter == "h") ? "<b>H</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/h">H</a>' ?> |
            <?php echo ($letter == "i") ? "<b>I</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/i">I</a>' ?> |
            <?php echo ($letter == "j") ? "<b>J</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/j">J</a>' ?> |
            K |
            <?php echo ($letter == "l") ? "<b>L</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/l">L</a>' ?> |
            <?php echo ($letter == "m") ? "<b>M</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/m">M</a>' ?> |
            <?php echo ($letter == "n") ? "<b>N</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/n">N</a>' ?> |
            <?php echo ($letter == "o") ? "<b>O</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/o">O</a>' ?> |
            <?php echo ($letter == "p") ? "<b>P</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/p">P</a>' ?> |
            <?php echo ($letter == "q") ? "<b>Q</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/q">Q</a>' ?> |
            <?php echo ($letter == "r") ? "<b>R</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/r">R</a>' ?> |
            <?php echo ($letter == "s") ? "<b>S</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/s">S</a>' ?> |
            <?php echo ($letter == "t") ? "<b>T</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/t">T</a>' ?> |
            <?php echo ($letter == "u") ? "<b>U</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/u">U</a>' ?> |
            <?php echo ($letter == "v") ? "<b>V</b>" : '<a href="'.base_url().'songs/index_melodies/'.$hymn_book_identifier.'/v">V</a>' ?> |
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
                            Mélodie
                        </th>
                        <th>
                            Autre nom connu
                        </th>
                        <th style="text-align:right;">
                            Cantique(s)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($melodies_data as $melody_data): ?>
                        <tr>
                            <td id="melody<?php echo $melody_data['song_melody_id'] ?>">
                                <?php echo $melody_data['name1']; ?>
                            </td>
                            <td>
                                <?php echo $melody_data['name2']; ?>
                            </td>
                            <td style="text-align:right;">
                                <?php
                                    $count = count($melody_data['songs']);
                                    $i = 0;
                                    $separator = ", ";
                                ?>
                                <?php
                                    foreach($melody_data['songs'] as $song) {
                                        if ($i == $count - 1) {
                                            $separator = "";
                                        }
                                        echo "<a href='".base_url()."songs/read/".$hymn_book_identifier."/".$song->song_number."'>".$song->song_number."</a>".$separator;
                                        $i++;
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br /><br />
        </div>
    </div>
<?php endif; ?>