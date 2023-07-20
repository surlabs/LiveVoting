<?php

namespace LiveVoting\Cache;

use ActiveRecord;
use ActiveRecordList;
use arConnector;
use arException;
use ilLiveVotingPlugin;
use LiveVoting\Utils\LiveVotingTrait;
use srag\DIC\LiveVoting\DICTrait;
use stdClass;

/**
 * Class arConnectorCache
 *
 * @package LiveVoting\Cache
 * @author  nschaefli
 */
class arConnectorCache extends arConnector
{

    use DICTrait;
    use LiveVotingTrait;
    const PLUGIN_CLASS_NAME = ilLiveVotingPlugin::class;
    private $arConnectorDB;
    private $cache;
    const CACHE_TTL_SECONDS = 1800;


    /**
     * arConnectorCache constructor.
     *
     * @param arConnector $arConnectorDB
     */
    public function __construct(arConnector $arConnectorDB)
    {
        $this->arConnectorDB = $arConnectorDB;
        $this->cache = xlvoCacheFactory::getInstance();
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return mixed
     */
    public function nextID(ActiveRecord $ar)
    {
        return $this->arConnectorDB->nextID($ar);
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return mixed
     */
    public function checkConnection(ActiveRecord $ar): bool
    {
        return $this->arConnectorDB->checkConnection($ar);
    }


    /**
     * @param ActiveRecord  $ar
     * @param               $fields
     *
     * @return bool
     */
    public function installDatabase(ActiveRecord $ar, $fields): bool
    {
        return $this->arConnectorDB->installDatabase($ar, $fields);
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return bool
     */
    public function updateDatabase(ActiveRecord $ar): bool
    {
        return $this->arConnectorDB->updateDatabase($ar);
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return true
     */
    public function resetDatabase(ActiveRecord $ar): bool
    {
        return $this->arConnectorDB->resetDatabase($ar);
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return void
     */
    public function truncateDatabase(ActiveRecord $ar): bool
    {
        $this->arConnectorDB->truncateDatabase($ar);
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return mixed
     *
     */
    public function checkTableExists(ActiveRecord $ar): bool
    {
        return $this->arConnectorDB->checkTableExists($ar);
    }


    /**
     * @param ActiveRecord  $ar
     * @param               $field_name
     *
     * @return mixed
     */
    public function checkFieldExists(ActiveRecord $ar, $field_name): bool
    {
        return $this->arConnectorDB->checkFieldExists($ar, $field_name);
    }


    /**
     * @param ActiveRecord  $ar
     * @param               $field_name
     *
     * @return bool
     * @throws arException
     */
    public function removeField(ActiveRecord $ar, $field_name): bool
    {
        return $this->arConnectorDB->removeField($ar, $field_name);
    }


    /**
     * @param ActiveRecord  $ar
     * @param               $old_name
     * @param               $new_name
     *
     * @return bool
     * @throws arException
     */
    public function renameField(ActiveRecord $ar, $old_name, $new_name): bool
    {
        return $this->arConnectorDB->renameField($ar, $old_name, $new_name);
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return void
     */
    public function create(ActiveRecord $ar): void
    {
        $this->arConnectorDB->create($ar);
        $this->storeActiveRecordInCache($ar);
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return array
     */
    public function read(ActiveRecord $ar): array
    {
        if ($this->cache->isActive()) {
            $key = $ar->getConnectorContainerName() . "_" . $ar->getPrimaryFieldValue();
            $cached_value = $this->cache->get($key);
            if (is_array($cached_value)) {
                return $cached_value;
            }

            if ($cached_value instanceof stdClass) {
                return [$cached_value];
            }
        }

        $results = $this->arConnectorDB->read($ar);

        if ($this->cache->isActive()) {
            $key = $ar->getConnectorContainerName() . "_" . $ar->getPrimaryFieldValue();

            $this->cache->set($key, $results, self::CACHE_TTL_SECONDS);
        }

        return $results;
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return void
     */
    public function update(ActiveRecord $ar): void
    {
        $this->arConnectorDB->update($ar);
        $this->storeActiveRecordInCache($ar);
    }


    /**
     * @param ActiveRecord $ar
     *
     * @return void
     */
    public function delete(ActiveRecord $ar): void
    {
        $this->arConnectorDB->delete($ar);

        if ($this->cache->isActive()) {
            $key = $ar->getConnectorContainerName() . "_" . $ar->getPrimaryFieldValue();
            $this->cache->delete($key);
        }
    }


    /**
     * @param ActiveRecordList $arl
     *
     * @return mixed
     */
    public function readSet(ActiveRecordList $arl): array
    {
        return $this->arConnectorDB->readSet($arl);
    }


    /**
     * @param ActiveRecordList $arl
     *
     * @return int
     */
    public function affectedRows(ActiveRecordList $arl): int
    {
        return $this->arConnectorDB->affectedRows($arl);
    }


    /**
     * @param $value
     * @param $type
     *
     * @return string
     */
    public function quote($value, $type): string
    {
        return $this->arConnectorDB->quote($value, $type);
    }


    /**
     * @param ActiveRecord $ar
     */
    public function updateIndices(ActiveRecord $ar): void
    {
        $this->arConnectorDB->updateIndices($ar);
    }


    /**
     * Stores an active record into the xlvoCache.
     *
     * @param ActiveRecord $ar
     *
     * @return void
     */
    private function storeActiveRecordInCache(ActiveRecord $ar)
    {
        if ($this->cache->isActive()) {
            $key = $ar->getConnectorContainerName() . "_" . $ar->getPrimaryFieldValue();
            $value = $ar->__asStdClass();

            $this->cache->set($key, $value, self::CACHE_TTL_SECONDS);
        }
    }
}
