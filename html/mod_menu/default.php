<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . htmlspecialchars($tagId, ENT_QUOTES, 'UTF-8') . '"';
}
?>
<ul<?php echo $id; ?> class="navbar-nav <?php echo $class_sfx; ?>">
    <?php foreach ($list as $i => &$item) : ?>
        <?php
        $class = 'nav-item item-' . $item->id;
        if ($item->parent) {
            $class .= ' dropdown';
        }
        ?>
        <li class="<?php echo $class; ?>">
            <a href="<?php echo $item->flink; ?>" class="nav-link<?php echo $item->parent ? ' dropdown-toggle' : ''; ?>" <?php echo $item->parent ? 'data-bs-toggle="dropdown" aria-expanded="false"' : ''; ?>>
                <?php echo $item->title; ?>
            </a>
            <?php if ($item->deeper) : ?>
                <ul class="dropdown-menu" data-bs-auto-close="outside">
            <?php elseif ($item->shallower) : ?>
                </li><?php echo str_repeat('</ul></li>', $item->level_diff); ?>
            <?php else : ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
</ul>