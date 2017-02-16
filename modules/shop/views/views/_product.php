<div class="col-md-4 deal">
    <div class="thumbnail">
        <?php
        if ($data->getImagePreview('_spec')) {
            $image = $data->getImagePreview('_spec')->getUrlPath();
        } else {
            $image = '/themes/business/gfx/placeholder.png';
        }
        ?>
        <?php echo CHtml::link(CHtml::image($image, $data->name), $data->getUrl(), array(
            'style' => 'display: block; text-align: center; height: 200px;',
        )); ?>
        <div class="caption">
            <h4 class="caption-link">
                <?php echo CHtml::link($data->name, $data->getUrl()); ?>
            </h4>

            <div class="text-danger">
                <?php echo number_format($data->retail_price, 2, '.', ' '); ?> руб
            </div>
        </div>
    </div>
</div>