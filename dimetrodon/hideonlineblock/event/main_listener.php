<?php
/**
 *
 * Hide Online Block. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2024, [Dimetrodon]
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dimetrodon\hideonlineblock\event;

/**
 * @ignore
 */
use phpbb\auth\auth;
use phpbb\language\language;
use phpbb\template\twig\twig;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Hide Memberlist Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	public function __construct(
		private auth $auth,
		private language $language,
		private twig $twig,
		private user $user,
		
	)
	{
	}
	
	public static function getSubscribedEvents(): array
	{
		return [
			'core.page_header_after' => 'header_after',
		];
	}



	/**
	 * Loads after the page header.
	 * Blocks access to online list block to non-Admins. 
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function header_after($event): void
	{
		if (!$this->auth->acl_get('a_') && !$this->auth->acl_get('m_'))
		{
			$this->twig->assign_var('S_DISPLAY_ONLINE_LIST', false);
			$this->twig->assign_var('NEWEST_USER', false);
		}
	}
}
