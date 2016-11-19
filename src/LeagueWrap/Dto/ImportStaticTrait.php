<?php

namespace LeagueWrap\Dto;

use LeagueWrap\StaticOptimizer;

trait ImportStaticTrait
{
    /**
     * Sets all the static fields in the current dto in the fields
     * and aggrigates it with the child dto fields.
     *
     * @return array
     */
    protected function getStaticFields()
    {
        $splHash = spl_object_hash($this);
        $fields = [
            $splHash => [],
        ];
        foreach ($this->staticFields as $field => $data) {
            if (!isset($this->info[$field])) {
                continue;
            }
            $fieldValue = $this->info[$field];
            if (!isset($fields[$splHash][$data])) {
                $fields[$splHash][$data] = [];
            }
            $fields[$splHash][$data][] = $fieldValue;
        }

        $fields += parent::getStaticFields();

        return $fields;
    }

    /**
     * Takes a result array and attempts to fill in any needed
     * static data.
     *
     * @param staticOptimizer $optimizer
     *
     * @return void
     */
    protected function addStaticData(StaticOptimizer $optimizer)
    {
        $splHash = spl_object_hash($this);
        $info = $optimizer->getDataFromHash($splHash);
        foreach ($this->staticFields as $field => $data) {
            if (!isset($this->info[$field])) {
                continue;
            }
            $infoArray = $info[$data];
            $fieldValue = $this->info[$field];
            $staticData = $infoArray[$fieldValue];

            // Static data can contain more than one items
            $this->info[$data.'StaticData'][] = $staticData;
        }

        // Fix for backwards compatibility (https://github.com/LeaguePHP/LeagueWrap/issues/4)
        // StaticData fields that have only one value (like Champion) should be accessible directly like
        // `$champion->championStaticData->name` instead of `$champion->championStaticData[0]->name`
        foreach ($this->info as $key => $value) {
            if (strpos($key, 'StaticData') !== false && count($value) === 1) {
                $this->info[$key] = $this->info[$key][0];
            }
        }

        parent::addStaticData($optimizer);
    }
}
