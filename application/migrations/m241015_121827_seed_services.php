<?php

use yii\db\Migration;

/**
 * Class m241015_121827_seed_services
 */
class m241015_121827_seed_services extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();

        try {
            $this->execute(<<<SQL
            INSERT INTO `services` (`id`, `name`) VALUES
            (1, 'Likes'),
            (2, 'Followers'),
            (3, 'Views'),
            (4, 'Tweets'),
            (5, 'Retweets'),
            (6, 'Comments'),
            (7, 'Custom comments'),
            (8, 'Page Likes'),
            (9, 'Post Likes'),
            (10, 'Friends'),
            (11, 'SEO'),
            (12, 'Mentions'),
            (13, 'Mentions with Hashtags'),
            (14, 'Mentions Custom List'),
            (15, 'Mentions Hashtag'),
            (16, 'Mentions User Followers'),
            (17, 'Mentions Media Likers');
            SQL);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('services');
    }

}
