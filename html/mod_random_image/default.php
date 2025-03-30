<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_random_image
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

if (!count($images)) {
    echo Text::_('MOD_RANDOM_IMAGE_NO_IMAGES');
    return;
}
?>

<div id="jumbotron">
<?php echo HTMLHelper::_('image', $image->folder . '/' . htmlspecialchars($image->name, ENT_COMPAT, 'UTF-8'), '', ['width' => $image->width, 'height' => $image->height]); ?>
</div>
