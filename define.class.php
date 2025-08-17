<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Radio profile field definition.
 *
 * @package    profilefield_radio
 * @copyright  2025 Santosh N. <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class profile_define_radio
 *
 * @copyright  2025 Santosh N. <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile_define_radio extends profile_define_base {
    /**
     * Adds elements to the form for creating/editing this type of profile field.
     * @param moodleform $form
     */
    public function define_form_specific($form) {
        // Param 1 for radio type contains the options.
        $form->addElement('textarea', 'param1', get_string('profileradiooptions', 'profilefield_radio'),
                          ['rows' => 6, 'cols' => 40]);
        $form->setType('param1', PARAM_TEXT);

        // Default data.
        $form->addElement('text', 'defaultdata', get_string('profiledefaultdata', 'admin'), 'size="50"');
        $form->setType('defaultdata', PARAM_TEXT);
    }

    /**
     * Validates data for the profile field.
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function define_validate_specific($data, $files) {
        $err = [];

        $data->param1 = str_replace("\r", '', $data->param1);

        // Check that we have at least 2 options.
        if (($options = explode("\n", $data->param1)) === false) {
            $err['param1'] = get_string('profileradionooptions', 'profilefield_radio');
        } else if (count($options) < 2) {
            $err['param1'] = get_string('profileradiotoofewoptions', 'profilefield_radio');
        } else if (!empty($data->defaultdata) && !in_array($data->defaultdata, $options)) {
            // Check the default data exists in the options.
            $err['defaultdata'] = get_string('profileradiodefaultnotinoptions', 'profilefield_radio');
        }
        return $err;
    }

    /**
     * Processes data before it is saved.
     * @param array|stdClass $data
     * @return array|stdClass
     */
    public function define_save_preprocess($data) {
        $data->param1 = str_replace("\r", '', $data->param1);

        return $data;
    }

}
