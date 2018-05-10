<?php

namespace board\components;

use Yii;

class BoardComponent extends \yii\base\Component
{

	public function setUserOnline($pun_user)
	{
		global $db, $db_type, $pun_config, $cookie_name, $cookie_seed;

		$now = time();

		// Define this if you want this visit to affect the online list and the users last visit data
		if (!defined('PUN_QUIET_VISIT'))
		{
			// Update the online list
			if (!$pun_user['logged'])
			{
				$pun_user['logged'] = $now;

				// With MySQL/MySQLi/SQLite, REPLACE INTO avoids a user having two rows in the online table
				switch ($db_type)
				{
					case 'mysql':
					case 'mysqli':
					case 'mysql_innodb':
					case 'mysqli_innodb':
					case 'sqlite':
						$db->query('REPLACE INTO '.$db->prefix.'online (user_id, ident, logged) VALUES('.$pun_user['id'].', \''.$db->escape($pun_user['username']).'\', '.$pun_user['logged'].')') or error('Unable to insert into online list', __FILE__, __LINE__, $db->error());
						break;

					default:
						$db->query('INSERT INTO '.$db->prefix.'online (user_id, ident, logged) SELECT '.$pun_user['id'].', \''.$db->escape($pun_user['username']).'\', '.$pun_user['logged'].' WHERE NOT EXISTS (SELECT 1 FROM '.$db->prefix.'online WHERE user_id='.$pun_user['id'].')') or error('Unable to insert into online list', __FILE__, __LINE__, $db->error());
						break;
				}

				// Reset tracked topics
				set_tracked_topics(null);
			}
			else
			{
				// Special case: We've timed out, but no other user has browsed the forums since we timed out
				if ($pun_user['logged'] < ($now-$pun_config['o_timeout_visit']))
				{
					$db->query('UPDATE user SET last_visit='.$pun_user['logged'].' WHERE id='.$pun_user['id']) or error('Unable to update user visit data', __FILE__, __LINE__, $db->error());
					$pun_user['last_visit'] = $pun_user['logged'];
				}

				$idle_sql = ($pun_user['idle'] == '1') ? ', idle=0' : '';
				$db->query('UPDATE '.$db->prefix.'online SET logged='.$now.$idle_sql.' WHERE user_id='.$pun_user['id']) or error('Unable to update online list', __FILE__, __LINE__, $db->error());

				// Update tracked topics with the current expire time
				if (isset($_COOKIE[$cookie_name.'_track']))
				{
					forum_setcookie($cookie_name.'_track', $_COOKIE[$cookie_name.'_track'], $now + $pun_config['o_timeout_visit']);
				}
			}
		}
		else
		{
			if (!$pun_user['logged'])
			{
				$pun_user['logged'] = $pun_user['last_visit'];
			}
		}

		return $pun_user;
	}
	
	public function load_pun_user()
	{
		global $db, $db_type, $pun_config, $cookie_name, $cookie_seed;

		global $pun_user;

		$id = Yii::$app->user->id;

		if ($id)
		{
			// Check if there's a user with the user ID and password hash from the cookie
			$result = $db->query('SELECT u.*, g.*, o.logged, o.idle FROM user AS u INNER JOIN '.$db->prefix.'groups AS g ON u.group_id=g.g_id LEFT JOIN '.$db->prefix.'online AS o ON o.user_id=u.id WHERE u.id='.intval($id)) or error('Unable to fetch user information', __FILE__, __LINE__, $db->error());
			
			$pun_user = $db->fetch_assoc($result);

			// Set a default language if the user selected language no longer exists
			if (!file_exists(PUN_ROOT.'lang/'.$pun_user['language']))
			{
				$pun_user['language'] = $pun_config['o_default_lang'];
			}

			// Set a default style if the user selected style no longer exists
			if (!file_exists(PUN_ROOT.'style/'.$pun_user['style'].'.css'))
			{
				$pun_user['style'] = $pun_config['o_default_style'];
			}

			if (!$pun_user['disp_topics'])
			{
				$pun_user['disp_topics'] = $pun_config['o_disp_topics_default'];
			}

			if (!$pun_user['disp_posts'])
			{
				$pun_user['disp_posts'] = $pun_config['o_disp_posts_default'];
			}

			$pun_user = $this->setUserOnline($pun_user);

			$pun_user['is_guest'] = false;
			$pun_user['is_admmod'] = $pun_user['g_id'] == PUN_ADMIN || $pun_user['g_moderator'] == '1';
		}
		else
		{
			set_default_user();
		}
	}

}

/*
function check_cookie(&$pun_user)
{
	global $db, $db_type, $pun_config, $cookie_name, $cookie_seed;

	$now = time();

	// If the cookie is set and it matches the correct pattern, then read the values from it
	if (isset($_COOKIE[$cookie_name]) && preg_match('%^(\d+)\|([0-9a-fA-F]+)\|(\d+)\|([0-9a-fA-F]+)$%', $_COOKIE[$cookie_name], $matches))
	{
		$cookie = array(
			'user_id'			=> intval($matches[1]),
			'password_hash' 	=> $matches[2],
			'expiration_time'	=> intval($matches[3]),
			'cookie_hash'		=> $matches[4],
		);
	}

	// If it has a non-guest user, and hasn't expired
	if (isset($cookie) && $cookie['user_id'] > 1 && $cookie['expiration_time'] > $now)
	{
		// If the cookie has been tampered with
		$is_authorized = pun_hash_equals(forum_hmac($cookie['user_id'].'|'.$cookie['expiration_time'], $cookie_seed.'_cookie_hash'), $cookie['cookie_hash']);
		if (!$is_authorized)
		{
			$expire = $now + 31536000; // The cookie expires after a year
			pun_setcookie(1, pun_hash(uniqid(rand(), true)), $expire);
			set_default_user();

			return;
		}

		// Check if there's a user with the user ID and password hash from the cookie
		$result = $db->query('SELECT u.*, g.*, o.logged, o.idle FROM user AS u INNER JOIN '.$db->prefix.'groups AS g ON u.group_id=g.g_id LEFT JOIN '.$db->prefix.'online AS o ON o.user_id=u.id WHERE u.id='.intval($cookie['user_id'])) or error('Unable to fetch user information', __FILE__, __LINE__, $db->error());
		$pun_user = $db->fetch_assoc($result);

		// If user authorisation failed
		$is_authorized = pun_hash_equals(forum_hmac($pun_user['password'], $cookie_seed.'_password_hash'), $cookie['password_hash']);
		if (!isset($pun_user['id']) || !$is_authorized)
		{
			$expire = $now + 31536000; // The cookie expires after a year
			pun_setcookie(1, pun_hash(uniqid(rand(), true)), $expire);
			set_default_user();

			return;
		}

		// Send a new, updated cookie with a new expiration timestamp
		$expire = ($cookie['expiration_time'] > $now + $pun_config['o_timeout_visit']) ? $now + 1209600 : $now + $pun_config['o_timeout_visit'];
		pun_setcookie($pun_user['id'], $pun_user['password'], $expire);

		// Set a default language if the user selected language no longer exists
		if (!file_exists(PUN_ROOT.'lang/'.$pun_user['language']))
			$pun_user['language'] = $pun_config['o_default_lang'];

		// Set a default style if the user selected style no longer exists
		if (!file_exists(PUN_ROOT.'style/'.$pun_user['style'].'.css'))
			$pun_user['style'] = $pun_config['o_default_style'];

		if (!$pun_user['disp_topics'])
			$pun_user['disp_topics'] = $pun_config['o_disp_topics_default'];
		if (!$pun_user['disp_posts'])
			$pun_user['disp_posts'] = $pun_config['o_disp_posts_default'];

		// Define this if you want this visit to affect the online list and the users last visit data
		if (!defined('PUN_QUIET_VISIT'))
		{
			// Update the online list
			if (!$pun_user['logged'])
			{
				$pun_user['logged'] = $now;

				// With MySQL/MySQLi/SQLite, REPLACE INTO avoids a user having two rows in the online table
				switch ($db_type)
				{
					case 'mysql':
					case 'mysqli':
					case 'mysql_innodb':
					case 'mysqli_innodb':
					case 'sqlite':
						$db->query('REPLACE INTO '.$db->prefix.'online (user_id, ident, logged) VALUES('.$pun_user['id'].', \''.$db->escape($pun_user['username']).'\', '.$pun_user['logged'].')') or error('Unable to insert into online list', __FILE__, __LINE__, $db->error());
						break;

					default:
						$db->query('INSERT INTO '.$db->prefix.'online (user_id, ident, logged) SELECT '.$pun_user['id'].', \''.$db->escape($pun_user['username']).'\', '.$pun_user['logged'].' WHERE NOT EXISTS (SELECT 1 FROM '.$db->prefix.'online WHERE user_id='.$pun_user['id'].')') or error('Unable to insert into online list', __FILE__, __LINE__, $db->error());
						break;
				}

				// Reset tracked topics
				set_tracked_topics(null);
			}
			else
			{
				// Special case: We've timed out, but no other user has browsed the forums since we timed out
				if ($pun_user['logged'] < ($now-$pun_config['o_timeout_visit']))
				{
					$db->query('UPDATE user SET last_visit='.$pun_user['logged'].' WHERE id='.$pun_user['id']) or error('Unable to update user visit data', __FILE__, __LINE__, $db->error());
					$pun_user['last_visit'] = $pun_user['logged'];
				}

				$idle_sql = ($pun_user['idle'] == '1') ? ', idle=0' : '';
				$db->query('UPDATE '.$db->prefix.'online SET logged='.$now.$idle_sql.' WHERE user_id='.$pun_user['id']) or error('Unable to update online list', __FILE__, __LINE__, $db->error());

				// Update tracked topics with the current expire time
				if (isset($_COOKIE[$cookie_name.'_track']))
					forum_setcookie($cookie_name.'_track', $_COOKIE[$cookie_name.'_track'], $now + $pun_config['o_timeout_visit']);
			}
		}
		else
		{
			if (!$pun_user['logged'])
				$pun_user['logged'] = $pun_user['last_visit'];
		}

		$pun_user['is_guest'] = false;
		$pun_user['is_admmod'] = $pun_user['g_id'] == PUN_ADMIN || $pun_user['g_moderator'] == '1';
	}
	else
		set_default_user();
}

*/