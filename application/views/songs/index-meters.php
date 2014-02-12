<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.browser.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.scrollto.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/utilities.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/index-meters.js"></script>

<?php if (isset($exception)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <strong>Erreur:</strong> <?php echo $exception->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1><?php echo $hymn_book_name; ?> - mètres</h1>
    <?php echo $indexes_menu; ?>
    <div class="row">
        <div class="span12">
            Nombre de chiffres: 
            <?php echo ($digits == "3") ? "<b>3</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/3">3</a>' ?> |
            <?php echo ($digits == "4") ? "<b>4</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/4">4</a>' ?> |
            <?php echo ($digits == "5") ? "<b>5</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/5">5</a>' ?> |
            <?php echo ($digits == "6") ? "<b>6</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/6">6</a>' ?> |
            <?php echo ($digits == "7") ? "<b>7</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/7">7</a>' ?> |
            <?php echo ($digits == "8") ? "<b>8</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/8">8</a>' ?> |
            <?php echo ($digits == "9") ? "<b>9</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/9">9</a>' ?> |
            <?php echo ($digits == "10") ? "<b>10</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/10">10</a>' ?> |
            11 |
            <?php echo ($digits == "12") ? "<b>12</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/12">12</a>' ?> |
            13 |
            14 |
            15 |
            16 |
            <?php echo ($digits == "17") ? "<b>17</b>" : '<a href="'.base_url().'songs/index_meters/'.$hymn_book_identifier.'/17">17</a>' ?> |
        </div>
    </div>
    <br />
    <div class="row">
        <div class="span12">
            <table width="100%" class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>
                            Mètre
                        </th>
                        <th style="text-align:right;">
                            Cantique(s)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($meters_data as $meter_data): ?>
                        <tr>
                            <td id="meter<?php echo $meter_data['song_meter_id'] ?>">
                                <?php echo $meter_data['meter']; ?><br />
                            </td>
                            <td style="text-align:right;">
                                <?php
                                    $count = count($meter_data['songs']);
                                    $i = 0;
                                    $separator = ", ";
                                ?>
                                <?php
                                    foreach($meter_data['songs'] as $song) {
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