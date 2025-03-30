<?php
/**
 * @package   DPCalendar
 * @copyright Copyright (C) 2015 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

\defined('_JEXEC') or die();

use DigitalPeak\Component\DPCalendar\Administrator\Helper\Booking;
use DigitalPeak\Component\DPCalendar\Administrator\Helper\DPCalendarHelper;
use DigitalPeak\Component\DPCalendar\Administrator\HTML\Block\Icon;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;

if (!$events) {
	echo $translator->translate($params->get('no_events_text', 'MOD_DPCALENDAR_UPCOMING_NO_EVENT_TEXT'));

	return;
}

require ModuleHelper::getLayoutPath('mod_dpcalendar_upcoming', '_scripts');
?>
<div class="mod-dpcalendar-upcoming mod-dpcalendar-upcoming-blog mod-dpcalendar-upcoming-<?php echo $module->id; ?> dp-locations"
	data-popup="<?php echo $params->get('show_as_popup', 0); ?>">
	<div class="mod-dpcalendar-upcoming-blog__custom-text">
		<?php echo HTMLHelper::_('content.prepare', $translator->translate($params->get('textbefore', ''))); ?>
	</div>
	<div class="mod-dpcalendar-upcoming-blog__events">
		<?php foreach ($groupedEvents as $groupHeading => $events) { ?>
			<?php if ($groupHeading) { ?>
				<div class="mod-dpcalendar-upcoming-blog__group">
					<p class="mod-dpcalendar-upcoming-blog__heading dp-group-heading"><?php echo $groupHeading; ?></p>
				<?php } ?>
				<?php foreach ($events as $event) { ?>
					<?php $calendar = $app->bootComponent('dpcalendar')->getMVCFactory()->createModel('Calendar', 'Administrator')->getCalendar($event->catid); ?>
				<?php $displayData['event'] = $event; ?>
				<div class="mod-dpcalendar-upcoming-blog__event dp-event dp-event_<?php echo $event->ongoing_start_date ? ($event->ongoing_end_date ? 'started' : 'finished') : 'future'; ?>">
					<h3 class="mod-dpcalendar-upcoming-blog__heading">
						<?php if ($event->state == 3) { ?>
							<span class="dp-event_canceled">[<?php echo $translator->translate('MOD_DPCALENDAR_UPCOMING_CANCELED'); ?>]</span>
						<?php } ?>
						<a href="<?php echo $event->realUrl; ?>" target="_parent" class="dp-event-url dp-link">
							<?php echo $event->title; ?>
						</a>
					</h3>
					<?php if ($params->get('show_display_events') && $event->displayEvent->afterDisplayTitle) { ?>
						<div class="dp-event-display-after-title"><?php echo $event->displayEvent->afterDisplayTitle; ?></div>
					<?php } ?>
					<div class="dp-grid">
						<div class="mod-dpcalendar-upcoming-blog__information">
							<?php if ($calendar->canEdit() || ($calendar->canEditOwn() && $event->created_by == $user->id)) { ?>
								<a href="<?php echo $router->getEventFormRoute($event->id, $return); ?>" class="dp-link">
									<?php echo $layoutHelper->renderLayout(
										'block.icon',
										['icon' => Icon::EDIT, 'title' => $translator->translate('JACTION_EDIT')]
									); ?>
								</a>
							<?php } ?>
							<?php if ($calendar->canDelete() || ($calendar->canEditOwn() && $event->created_by == $user->id)) { ?>
								<a href="<?php echo $router->getEventDeleteRoute($event->id, $return); ?>" class="dp-link">
									<?php echo $layoutHelper->renderLayout(
										'block.icon',
										['icon' => Icon::DELETE, 'title' => $translator->translate('JACTION_DELETE')]
									); ?>
								</a>
							<?php } ?>
							<div class="mod-dpcalendar-upcoming-blog__date">
								<?php echo $translator->translate('MOD_DPCALENDAR_UPCOMING_DATE'); ?>:
								<?php echo $dateHelper->getDateStringFromEvent($event, $params->get('date_format'), $params->get('time_format')); ?>
							</div>
							<?php if ($event->rrule) { ?>
								<div class="mod-dpcalendar-upcoming-blog__rrule">
								<?php echo nl2br((string) $dateHelper->transformRRuleToString($event->rrule, $event->start_date, $event->exdates)); ?>
								</div>
							<?php } ?>
							<div class="mod-dpcalendar-upcoming-blog__calendar">
								<?php echo $translator->translate('MOD_DPCALENDAR_UPCOMING_BLOG_CALENDAR'); ?>:
								<?php echo $calendar != null ? $calendar->getTitle() : $event->catid; ?>
							</div>
							<?php if (($params->get('show_location') || $params->get('show_map')) && !empty($event->locations)) { ?>
								<div class="mod-dpcalendar-upcoming-blog__location">
									<?php if ($params->get('show_location')) { ?>
										<?php echo $layoutHelper->renderLayout('block.icon', ['icon' => Icon::LOCATION]); ?>
									<?php } ?>
									<?php foreach ($event->locations as $location) { ?>
										<div class="dp-location<?php echo $params->get('show_location') ? '' : ' dp-location_hidden'; ?>">
											<div class="dp-location__details"
												 data-latitude="<?php echo $location->latitude; ?>"
												 data-longitude="<?php echo $location->longitude; ?>"
												 data-title="<?php echo $location->title; ?>"
												 data-color="<?php echo $event->color; ?>"></div>
											<?php if ($params->get('show_location')) { ?>
												<a href="<?php echo $router->getLocationRoute($location); ?>" class="dp-location__url dp-link">
													<span class="dp-location__title"><?php echo $location->title; ?></span>
													<?php if (!empty($event->roomTitles[$location->id])) { ?>
														<span class="dp-location__rooms">[<?php echo implode(', ', $event->roomTitles[$location->id]); ?>]</span>
													<?php } ?>
												</a>
											<?php } ?>
											<div class="dp-location__description">
												<?php echo $layoutHelper->renderLayout('event.tooltip', $displayData); ?>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
							<div class="mod-dpcalendar-upcoming-blog__capacity">
								<?php if ($event->capacity === null) { ?>
									<?php echo $translator->translate('MOD_DPCALENDAR_UPCOMING_BLOG_CAPACITY'); ?>:
									<?php echo $translator->translate('MOD_DPCALENDAR_UPCOMING_BLOG_CAPACITY_UNLIMITED'); ?>
								<?php } ?>
								<?php if ($event->capacity > 0) { ?>
									<?php echo $translator->translate('MOD_DPCALENDAR_UPCOMING_BLOG_CAPACITY'); ?>:
									<?php echo ($event->capacity - $event->capacity_used) . '/' . (int)$event->capacity; ?>
								<?php } ?>
							</div>
							<?php if ($params->get('show_price') && $event->prices) { ?>
								<?php foreach ($event->prices as $price) { ?>
									<?php $discounted = Booking::getPriceWithDiscount($price->value, $event); ?>
									<div class="mod-dpcalendar-upcoming-blog__price dp-event-price">
										<?php echo $layoutHelper->renderLayout(
											'block.icon',
											[
												'icon' => Icon::MONEY,
												'title' => $translator->translate('MOD_DPCALENDAR_UPCOMING_PRICES')
											]
										); ?>
										<span class="dp-event-price__label">
										<?php echo $price->label ?: $translator->translate('MOD_DPCALENDAR_UPCOMING_PRICES'); ?>
									</span>
										<span class="dp-event-price__regular<?php echo $discounted != $price->value ? ' dp-event-price__regular_has-discount' : ''; ?>">
										<?php echo $price->value === '' ? '' : DPCalendarHelper::renderPrice($price->value); ?>
									</span>
										<?php if ($discounted != $price->value) { ?>
											<span class="dp-event-price__discount"><?php echo DPCalendarHelper::renderPrice($discounted); ?></span>
										<?php } ?>
										<span class="dp-event-price__description">
										<?php echo $price->description; ?>
									</span>
									</div>
								<?php } ?>
							<?php } ?>
							<?php if ($params->get('show_booking', 1) && Booking::openForBooking($event)) { ?>
								<a href="<?php echo $router->getBookingFormRouteFromEvent($event, $return, true, $moduleParams->get('default_menu_item', 0)); ?>"
									class="dp-link dp-link_cta">
									<?php echo $layoutHelper->renderLayout('block.icon', ['icon' => Icon::BOOK]); ?>
									<span class="dp-link__text">
										<?php echo $translator->translate('MOD_DPCALENDAR_UPCOMING_BOOK'); ?>
									</span>
								</a>
							<?php } ?>
						</div>
						<?php if ($params->get('show_image', 1) && $event->images->image_intro) { ?>
							<div class="mod-dpcalendar-upcoming-blog__image">
								<figure class="dp-figure">
									<a href="<?php echo $event->realUrl; ?>" class="dp-event-url dp-link">
										<img class="dp-image" src="<?php echo $event->images->image_intro; ?>"
											aria-label="<?php echo $event->images->image_intro_alt; ?>"
											alt="<?php echo $event->images->image_intro_alt; ?>"
											loading="lazy" <?php echo $event->images->image_intro_dimensions; ?>>
									</a>
									<?php if ($event->images->image_intro_caption) { ?>
										<figcaption class="dp-figure__caption"><?php echo $event->images->image_intro_caption; ?></figcaption>
									<?php } ?>
								</figure>
							</div>
						<?php } ?>
					</div>
					<?php if ($params->get('show_display_events') && $event->displayEvent->beforeDisplayContent) { ?>
						<div class="dp-event-display-before-content"><?php echo $event->displayEvent->beforeDisplayContent; ?></div>
					<?php } ?>
					<div class="mod-dpcalendar-upcoming-blog__description">
						<?php echo $event->truncatedDescription; ?>
					</div>
					<?php if ($params->get('show_display_events') && $event->displayEvent->afterDisplayContent) { ?>
						<div class="dp-event-display-after-content"><?php echo $event->displayEvent->afterDisplayContent; ?></div>
					<?php } ?>
					<?php echo $layoutHelper->renderLayout('schema.event', $displayData); ?>
				</div>
			<?php } ?>
			<?php if ($groupHeading) { ?>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
	<?php if ($params->get('show_map')) { ?>
		<div class="mod-dpcalendar-upcoming-blog__map dp-map"
			 style="width: <?php echo $params->get('map_width', '100%'); ?>; height: <?php echo $params->get('map_height', '350px'); ?>"
			 data-zoom="<?php echo $params->get('map_zoom', 4); ?>"
			 data-latitude="<?php echo $params->get('map_lat', 47); ?>"
			 data-longitude="<?php echo $params->get('map_long', 4); ?>"
			 data-ask-consent="<?php echo $params->get('map_ask_consent'); ?>">
		</div>
	<?php } ?>
	<div class="mod-dpcalendar-upcoming-blog__custom-text">
		<?php echo HTMLHelper::_('content.prepare', $translator->translate($params->get('textafter', ''))); ?>
	</div>
</div>
