<div class="row">
    <div class="span12">
        <ul class="nav nav-pills">
            <?php echo ($this->router->fetch_method() == "index") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>bible/index">index</a></li>
            <?php echo ($this->router->fetch_method() == "search") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>bible/search">recherche</a></li>
            <?php echo ($this->router->fetch_method() == "read") ? "<li class='active'>" : '<li>' ?><a href="<?php echo base_url(); ?>bible/read">lecture</a></li>
        </ul>
    </div>
</div>