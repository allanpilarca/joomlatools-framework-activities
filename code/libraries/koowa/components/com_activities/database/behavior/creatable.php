<?php
/**
 * Koowa Framework - http://developer.joomlatools.com/koowa
 *
 * @copyright	Copyright (C) 2007 - 2014 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link		http://github.com/joomlatools/koowa for the canonical source repository
 */

/**
 * Creatable Database Behavior
 *
 * @author  Johan Janssens <https://github.com/johanjanssens>
 * @package Koowa\Library\Database
 */
class ComActivitiesDatabaseBehaviorCreatable extends KDatabaseBehaviorCreatable
{
    protected function _initialize(KObjectConfig $config)
    {
        $config->append(array('row_mixin' => true));
        parent::_initialize($config);
    }
}