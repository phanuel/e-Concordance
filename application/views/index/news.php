<div class="row">
    <div class="span12">
        <h1>Nouveautés</h1>
        <br />
        <?php foreach($news as $news_item): ?>
            <div class="row news">
                <div class="span3">
                    <p>
                        <b><?php echo $news_item->date_fr; ?></b>
                    </p>
                </div>
                <div class="span9">
                    <?php if ($news_item->version != null): ?>
                        <span class="label label-info"><?php echo $news_item->version; ?></span>
                    <?php endif; ?>
                    <p class="news-content"><?php echo $news_item->content; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>