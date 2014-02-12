<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.browser.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/lib/jquery.scrollto.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/utilities.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/index-authors.js"></script>

<?php if (isset($exception)): ?>
    <div class="row">
        <div class="span12">
            <div class="alert">
                <strong>Erreur:</strong> <?php echo $exception->getMessage(); ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1><?php echo $title; ?></h1>
    <?php echo $indexes_menu; ?>
    <div class="row">
        <div class="span12">
            <table width="100%" class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>
                            Nom
                        </th>
                        <th>
                            Prénom
                        </th>
                        <th style="text-align:right;">
                            Cantique(s)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($authors_data as $author_data): ?>
                        <tr>
                            <td id="author<?php echo $author_data['person_id'] ?>" class="nowrap">
                                <?php echo $author_data['last_name']; ?><br />
                            </td>
                            <td class="nowrap">
                                <?php echo $author_data['first_name']; ?><br />
                            </td>
                            <td style="text-align:right;">
                                <?php
                                    $count = count($author_data['songs']);
                                    $i = 0;
                                    $separator = "";
                                ?>
                                <?php
                                    $songs = explode(", ", $author_data['songs']);
                                    foreach($songs as $song) {
                                        echo $separator."<a href='".base_url()."songs/read/".$hymn_book_identifier."/".$song."'>".$song."</a>";
                                        $separator = ", ";
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