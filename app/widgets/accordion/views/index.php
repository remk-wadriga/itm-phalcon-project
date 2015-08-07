<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 05-08-2015
 * Time: 16:43 PM
 *
 * @var widgets\accordion\AccordionWidget $this
 * @var array $item
 */

use widgets\accordion\AccordionWidget;
?>

<li id="left_menu_item_<?= $item['id'] ?>" data-id="<?= $item['id'] ?>">

    <a href="<?= $item['link'] ? $item['link'] : '#' ?>">
        <?= $item['type'] != AccordionWidget::TYPE_MAIN ? $item['title'] : '' ?>
        <?php if($item['icon']): ?>
            <i class="<?= $item['icon'] ?>"></i>
        <?php endif; ?>
    </a>

    <?php if(isset($children)): ?>
        <ul>
            <?= $children; ?>
        </ul>
    <?php endif; ?>

</li>
