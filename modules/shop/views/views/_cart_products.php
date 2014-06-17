<ul class="tovarList">
  <?php foreach ($products AS $product): ?>
    <li data-kolvo="<?php echo $product->countInCart; ?>" data-id="<?php echo $product->id_product; ?>" class="item">
      <div class="name">
        <?php echo $product->name; ?>
      </div>
      <div class="kolvo">
        <input value="<?php echo $product->countInCart; ?>" maxlength="4"> шт.
      </div>
    </li>
  <?php endforeach; ?>
</ul>