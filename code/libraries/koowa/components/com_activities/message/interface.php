<?php
/**
 * Koowa Framework - http://developer.joomlatools.com/koowa
 *
 * @copyright      Copyright (C) 2011 - 2013 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license        GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link           http://github.com/joomlatools/koowa-activities for the canonical source repository
 */

/**
 * Activity Message Interface.
 *
 * @author  Arunas Mazeika <https://github.com/amazeika>
 * @package Koowa\Component\Activities
 */
interface ComActivitiesMessageInterface
{
    /**
     * Set the message parameters
     *
     * @param ComActivitiesMessageParametersInterface $parameters The message parameters.
     * @return ComActivitiesMessageInterface
     */
    public function setParameters(ComActivitiesMessageParametersInterface $parameters);

    /**
     * Get the message parameters
     *
     * @return ComActivitiesMessageParametersInterface The message parameters.
     */
    public function getParameters();

    /**
     * Set the message format
     *
     * @param string $format The message format.
     * @return ComActivitiesMessageInterface
     */
    public function setFormat($format);

    /**
     * Get the message format
     *
     * @return string The message format.
     */
    public function getFormat();

    /**
     * Set the message scripts
     *
     * @param string $scripts Scripts to be included with the message.
     * @return ComActivitiesMessageInterface
     */
    public function setScripts($scripts);

    /**
     * Get the message scripts
     *
     * @return string Scripts to be included with the message.
     */
    public function getScripts();

    /**
     * Set the message translator
     *
     * @param ComActivitiesMessageTranslatorInterface $translator The message translator.
     * @return ComActivitiesMessageInterface
     */
    public function setTranslator(ComActivitiesMessageTranslatorInterface $translator);

    /**
     * Get the message translator
     *
     * @return ComActivitiesMessageTranslatorInterface The message translator.
     */
    public function getTranslator();

    /**
     * Casts an activity message to string.
     *
     * @return string The string representation of an activity message.
     */
    public function toString();
}