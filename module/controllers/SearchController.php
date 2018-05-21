<?php

namespace modules\board\controllers;

class SearchController extends \yii\web\Controller
{

/*

			// If it's a search for new posts since last visit
			if ($action == 'show_new')
			{
				if ($pun_user['is_guest'])
					message($lang_common['No permission'], false, '403 Forbidden');

				$result = $db->query('

				SELECT t.id FROM '.$db->prefix.'topics AS t 
					LEFT JOIN '.$db->prefix.'forum_perms AS fp ON (fp.forum_id=t.forum_id AND fp.group_id='.$pun_user['g_id'].') 
				WHERE (fp.read_forum IS NULL 
					OR fp.read_forum=1) 
					AND t.last_post>'.$pun_user['last_visit'].' 
					AND t.moved_to IS NULL'.(isset($_GET['fid']) ? ' 
					AND t.forum_id='.intval($_GET['fid']) : '').' 
					ORDER BY t.last_post DESC') or error('Unable to fetch topic list', __FILE__, __LINE__, $db->error());
				$num_hits = $db->num_rows($result);

				if (!$num_hits)
					message($lang_search['No new posts']);
			}

*/

	public function actionShowNew()
	{

	}

}