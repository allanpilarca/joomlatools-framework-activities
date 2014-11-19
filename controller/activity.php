<?php
/**
 * Nooku Framework - http://nooku.org/framework
 *
 * @copyright   Copyright (C) 2011 - 2014 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://github.com/nooku/nooku-activities for the canonical source repository
 */

/**
 * Activity Controller.
 *
 * @author  Arunas Mazeika <https://github.com/amazeika>
 * @package Koowa\Component\Activities
 */
class ComActivitiesControllerActivity extends KControllerModel
{
    /**
     * Constructor.
     *
     * @param KObjectConfig $config Configuration options.
     */
    public function __construct(KObjectConfig $config)
    {
        parent::__construct($config);

        $this->getObject('translator')->load('com:activities');
    }

    protected function _initialize(KObjectConfig $config)
    {
        $config->append(array(
            'behaviors' => array('purgeable')
        ));

        $aliases = array(
            'com:activities.model.activities'               => array(
                'path' => array('model'),
                'name' => KStringInflector::pluralize($this->getIdentifier()->getName())
            ),
            'com:activities.controller.behavior.purgeable'  => array(
                'path' => array('controller', 'behavior'),
                'name' => 'purgeable'
            ),
            'com:activities.controller.permission.activity' => array('path' => array('controller', 'permission')),
            'com:activities.controller.toolbar.activity'    => array('path' => array('controller', 'toolbar'))
        );

        foreach ($aliases as $identifier => $alias)
        {
            $alias = array_merge($this->getIdentifier()->toArray(), $alias);

            $manager = $this->getObject('manager');

            // Register the alias if a class for it cannot be found.
            if (!$manager->getClass($alias, false)) {
                $manager->registerAlias($identifier, $alias);
            }
        }

        parent::_initialize($config);
    }

    /**
     * Method to set a view object attached to the controller
     *
     * @param   mixed   $view An object that implements KObjectInterface, KObjectIdentifier object
     *                  or valid identifier string
     * @return  object  A KViewInterface object or a KObjectIdentifier object
     */
    public function setView($view)
    {
        $view = parent::setView($view);

        if ($view instanceof KObjectIdentifier && $this->getRequest()->getFormat() !== 'html')
        {
            $manager = $this->getObject('manager');

            // Set the view identifier as an alias of the component view.
            if (!$manager->getClass($view, false))
            {
                $identifier = $view->toArray();
                $identifier['package'] = 'activities';
                unset($identifier['domain']);

                $manager->registerAlias($identifier, $view);
            }
        }

        return $view;
    }

    /**
     * Overridden for forcing the package model state.
     */
    public function getRequest()
    {
        $request = parent::getRequest();

        // Force set the 'package' in the request
        $request->query->package = $this->getIdentifier()->package;

        return $request;
    }

    /**
     * Set the IP address if we are adding a new activity.
     *
     * @param KControllerContextInterface $context A command context object.
     * @return KModelEntityInterface
     */
    protected function _beforeAdd(KControllerContextInterface $context)
    {
        $context->request->data->ip = $this->getObject('request')->getAddress();
    }
}
