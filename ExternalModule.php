<?php
/**
 * @file
 * Provides ExternalModule class for Epoch Action Tag.
 */

namespace EpochActionTag\ExternalModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;

/**
 * ExternalModule class for Epoch Action Tag.
 */
class ExternalModule extends AbstractExternalModule {

    /**
     * @inheritdoc
     */
    function redcap_every_page_top($project_id) {
        if ($project_id) {
            $this->includeJs('js/action_tag_helper.js');
        }
    }

    /**
     * @inheritdoc
     */
    function redcap_survey_page_top($project_id, $record = null, $instrument, $event_id, $group_id = null, $survey_hash, $response_id = null, $repeat_instance = 1) {
        $this->setEpochActionTag($instrument);
    }

    /**
     * @inheritdoc
     */
    function redcap_data_entry_form_top($project_id, $record = null, $instrument, $event_id, $group_id = null, $repeat_instance = 1) {
        $this->setEpochActionTag($instrument);
    }

    /**
     * Sets @EPOCH action tag for a given instrument.
     *
     * @param $instrument
     *   The instrument name.
     */
    protected function setEpochActionTag($instrument) {
        global $Proj;

        foreach (array_keys($Proj->forms[$instrument]['fields']) as $field_name) {
            if (strpos(' ' . $Proj->metadata[$field_name]['misc'] . ' ', ' @NOW-EPOCH ') !== false) {
                $Proj->metadata[$field_name]['misc'] .= ' @DEFAULT="' . strtotime(NOW) . '"';
            }
        }
    }

    /**
     * Includes a local JS file.
     *
     * @param string $path
     *   The relative path to the js file.
     */
    protected function includeJs($path) {
        echo '<script src="' . $this->getUrl($path) . '"></script>';
    }
}
