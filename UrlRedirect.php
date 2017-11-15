<?php

namespace mrssoft\redirect;

use Yii;
use yii\base\Component;
use yii\db\Query;

/**
 *
 * CREATE TABLE `sbs_redirect` (
 * `old_url` VARCHAR(255) NOT NULL,
 * `new_url` VARCHAR(255) NOT NULL,
 * `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 * PRIMARY KEY (`old_url`)
 * )
 * ENGINE=InnoDB;
 *
 */
class UrlRedirect extends Component
{
    /**
     * @var string
     */
    public $tableName = '{{%redirect}}';

    /**
     * @var int
     */
    public $code = 302;

    /**
     * @var string
     */
    public $db = 'db';


    /**
     * @var \yii\db\Connection
     */
    private $_db;

    public function init()
    {
        $this->_db = Yii::$app->get($this->db);
        parent::init();
    }

    /**
     * Add link to base
     * @param string $oldUrl
     * @param string $newUrl
     */
    public function add($oldUrl, $newUrl)
    {
        /** @noinspection MissedFieldInspection */
        $this->_db->createCommand()
                  ->insert($this->tableName, ['old_url' => $oldUrl, 'new_url' => $newUrl])
                  ->execute();
    }

    /**
     * Find old url
     * @param string $oldUrl
     * @return string|null|false
     */
    public function find($oldUrl)
    {
        return (new Query())->select(['new_url'])
                            ->from($this->tableName)
                            ->where(['old_url' => $oldUrl])
                            ->scalar($this->_db);
    }

    /**
     * Clear old data
     * @param mixed $date
     */
    public function clear($date = null)
    {
        if ($date === null) {
            $date = '- 3 month';
        }

        $this->_db->createCommand()
                  ->delete($this->tableName, ['<', 'date', date('Y-m-d', strtotime($date))]);
    }
}
