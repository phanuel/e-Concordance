<div class="row">
    <div class="span8">
        <ul class="nav nav-pills">
            <li class="index-mode">Paroles: </li>
            <?php echo ($this->router->fetch_method() == "index") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>songs/index/<?php echo $hymn_book_identifier; ?>">index</a></li>
            <?php echo ($this->router->fetch_method() == "search") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>songs/search/<?php echo $hymn_book_identifier; ?>">recherche</a></li>
            <?php if ($hymn_book_identifier == "hymnes-et-cantiques"): ?>
                <?php echo ($this->router->fetch_method() == "index_authors_lyrics") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>songs/index_authors_lyrics/<?php echo $hymn_book_identifier; ?>">auteurs</a></li>
                <?php echo ($this->router->fetch_method() == "index_meters") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>songs/index_meters/<?php echo $hymn_book_identifier; ?>">mètres</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="span4">
        <?php if ($hymn_book_identifier == "hymnes-et-cantiques"): ?>
            <ul class="nav nav-pills">
                <li class="index-mode">Mélodies: </li>
                <?php echo ($this->router->fetch_method() == "index_melodies") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>songs/index_melodies/<?php echo $hymn_book_identifier; ?>">index</a></li>
                <?php echo ($this->router->fetch_method() == "index_authors_melodies") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>songs/index_authors_melodies/<?php echo $hymn_book_identifier; ?>">auteurs</a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>