<?php

namespace board\migrations;

use yii\db\Migration;

/**
 * Class m180508_162811_user_add_board_columns
 */
class m180508_162811_user_add_board_columns extends Migration
{

	public $tableName = 'user';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
    	$this->addColumn($this->tableName, 'group_id', $this->integer(10)->unsigned()->notNull()->defaultValue(3));

    	$this->addColumn($this->tableName, 'title', $this->string(50));

    	$this->addColumn($this->tableName, 'realname', $this->string(40));

    	$this->addColumn($this->tableName, 'url', $this->string(100));

    	$this->addColumn($this->tableName, 'jabber', $this->string(80));

    	$this->addColumn($this->tableName, 'icq', $this->string(12));

    	$this->addColumn($this->tableName, 'msn', $this->string(80));

    	$this->addColumn($this->tableName, 'aim', $this->string(30));

    	$this->addColumn($this->tableName, 'yahoo', $this->string(30));

    	$this->addColumn($this->tableName, 'location', $this->string(30));

    	$this->addColumn($this->tableName, 'signature', $this->text());

    	$this->addColumn($this->tableName, 'disp_topics', $this->integer(3)->unsigned());

    	$this->addColumn($this->tableName, 'disp_posts', $this->integer(3)->unsigned());

    	$this->addColumn($this->tableName, 'email_setting', $this->integer(1)->notNull()->defaultValue(1));

    	$this->addColumn($this->tableName, 'notify_with_post', $this->integer(1)->notNull()->defaultValue(0));

    	$this->addColumn($this->tableName, 'auto_notify', $this->integer(1)->notNull()->defaultValue(0));

    	$this->addColumn($this->tableName, 'show_smilies', $this->integer(1)->notNull()->defaultValue(1));

    	$this->addColumn($this->tableName, 'show_img', $this->integer(1)->notNull()->defaultValue(1));

    	$this->addColumn($this->tableName, 'show_img_sig', $this->integer(1)->notNull()->defaultValue(1));

    	$this->addColumn($this->tableName, 'show_avatars', $this->integer(1)->notNull()->defaultValue(1));

    	$this->addColumn($this->tableName, 'show_sig', $this->integer(1)->notNull()->defaultValue(1));

    	$this->addColumn($this->tableName, 'timezone', $this->float()->notNull()->defaultValue(0));

    	$this->addColumn($this->tableName, 'dst', $this->integer(1)->notNull()->defaultValue(0));

    	$this->addColumn($this->tableName, 'time_format', $this->integer(1)->notNull()->defaultValue(0));

    	$this->addColumn($this->tableName, 'date_format', $this->integer(1)->notNull()->defaultValue(0));

    	$this->addColumn($this->tableName, 'language', $this->string(25)->notNull()->defaultValue('Russian'));

    	$this->addColumn($this->tableName, 'style', $this->string(25)->notNull()->defaultValue('Air'));

    	$this->addColumn($this->tableName, 'num_posts', $this->integer(10)->unsigned()->notNull()->defaultValue(0));

    	$this->addColumn($this->tableName, 'last_post', $this->integer(10)->unsigned());

    	$this->addColumn($this->tableName, 'last_search', $this->integer(10)->unsigned());

    	$this->addColumn($this->tableName, 'last_email_sent', $this->integer(10)->unsigned());

    	$this->addColumn($this->tableName, 'last_report_sent', $this->integer(10)->unsigned());

    	$this->addColumn($this->tableName, 'registration_ip', $this->string(39)->notNull()->defaultValue('0.0.0.0'));

    	$this->addColumn($this->tableName, 'last_visit', $this->integer(10)->unsigned()->notNull()->defaultValue(0));

    	$this->addColumn($this->tableName, 'admin_note', $this->string(30));

    	$this->addColumn($this->tableName, 'activate_string', $this->string(80));

    	$this->addColumn($this->tableName, 'activate_key', $this->string(8));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
    	$this->dropColumn($this->tableName, 'group_id');

    	$this->dropColumn($this->tableName, 'title');

    	$this->dropColumn($this->tableName, 'realname');

    	$this->dropColumn($this->tableName, 'url');

    	$this->dropColumn($this->tableName, 'jabber');

    	$this->dropColumn($this->tableName, 'icq');

    	$this->dropColumn($this->tableName, 'msn');

    	$this->dropColumn($this->tableName, 'aim');

    	$this->dropColumn($this->tableName, 'yahoo');

    	$this->dropColumn($this->tableName, 'location');

    	$this->dropColumn($this->tableName, 'signature');

    	$this->dropColumn($this->tableName, 'disp_topics');

    	$this->dropColumn($this->tableName, 'disp_posts');

    	$this->dropColumn($this->tableName, 'email_setting');

    	$this->dropColumn($this->tableName, 'notify_with_post');

    	$this->dropColumn($this->tableName, 'auto_notify');

    	$this->dropColumn($this->tableName, 'show_smilies');

    	$this->dropColumn($this->tableName, 'show_img');

    	$this->dropColumn($this->tableName, 'show_img_sig');

    	$this->dropColumn($this->tableName, 'show_avatars');

    	$this->dropColumn($this->tableName, 'show_sig');

    	$this->dropColumn($this->tableName, 'timezone');

    	$this->dropColumn($this->tableName, 'dst');

    	$this->dropColumn($this->tableName, 'time_format');

    	$this->dropColumn($this->tableName, 'date_format');

    	$this->dropColumn($this->tableName, 'language');

    	$this->dropColumn($this->tableName, 'style');

    	$this->dropColumn($this->tableName, 'num_posts');

    	$this->dropColumn($this->tableName, 'last_post');

    	$this->dropColumn($this->tableName, 'last_search');

    	$this->dropColumn($this->tableName, 'last_email_sent');

    	$this->dropColumn($this->tableName, 'last_report_sent');

    	$this->dropColumn($this->tableName, 'registration_ip');

    	$this->dropColumn($this->tableName, 'last_visit');

    	$this->dropColumn($this->tableName, 'admin_note');

    	$this->dropColumn($this->tableName, 'activate_string');

    	$this->dropColumn($this->tableName, 'activate_key');
    }

}