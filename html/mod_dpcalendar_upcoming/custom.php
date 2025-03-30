<?php
/**
 * @package   DPCalendar
 * @copyright Copyright (C) 2014 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

\defined('_JEXEC') or die();

use DigitalPeak\Component\DPCalendar\Administrator\Helper\DPCalendarHelper;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;

require ModuleHelper::getLayoutPath('mod_dpcalendar_upcoming', '_scripts');
?>
<div class="mod-dpcalendar-upcoming mod-dpcalendar-upcoming-custom mod-dpcalendar-upcoming-<?php echo $module->id; ?>">
	<div class="mod-dpcalendar-upcoming-custom__custom-text">
		<?php echo HTMLHelper::_('content.prepare', $translator->translate($params->get('textbefore', ''))); ?>
	</div>
	<?php echo DPCalendarHelper::renderEvents(
		$events,
		$params->get(
			'custom_output',
			'<div class="mod-dpcalendar-upcoming-custom__events">{{#events}}<p><a class="dp-event-url dp-link" href="{{backLink}}">{{title}}</a> {{date}}</p>{{/events}}</div>'		)
	); ?>
	<div class="mod-dpcalendar-upcoming-custom__custom-text">
		<?php echo HTMLHelper::_('content.prepare', $translator->translate($params->get('textafter', ''))); ?>
	</div>
</div>
