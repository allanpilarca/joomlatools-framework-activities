<?php
/**
 * Nooku Framework - http://nooku.org/framework
 *
 * @copyright	Copyright (C) 2011 - 2014 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link		http://github.com/nooku/nooku-activities for the canonical source repository
 */

/**
 * Activity Translator.
 *
 * @author  Arunas Mazeika <https://github.com/amazeika>
 * @package Koowa\Component\Activities
 */
class ComActivitiesActivityTranslator extends KTranslatorAbstract implements KObjectSingleton
{
    /**
     * Associative array containing previously calculated overrides.
     *
     * @var array
     */
    protected $_overrides = array();

    /**
     * Translates an activity format.
     *
     * @param string $string The activity format to translate.
     * @param array  $tokens An array of format tokens.
     *
     * @return string The translated activity format.
     */
    public function translate($format, array $tokens = array())
    {
        $parameters = array();

        foreach ($tokens as $key => $value)
        {
            if ($value instanceof ComActivitiesActivityObjectInterface && $value->getObjectName()) {
                $value = $value->getObjectName();
            }

            if (is_scalar($value)) {
                $parameters[$key] = $value;
            }
        }

        $override = $this->_getOverride($format, $parameters);

        return parent::translate($override, array());
    }

    /**
     * Get an activity format override.
     *
     * @param  string $format     The activity format.
     * @param  array  $parameters Associative array containing format replacements to look for overrides.
     *
     * @return string The activity format override. The original activity format if no overrides where found.
     */
    protected function _getOverride($format, $parameters = array())
    {
        $override = $format;

        if ($parameters)
        {
            $key = $this->_getOverrideKey($format, $parameters);

            if (!isset($this->_overrides[$key]))
            {
                foreach ($this->_getOverrides($format, $parameters) as $candidate)
                {
                    // Check if the override is translatable.
                    if ($this->isTranslatable($candidate))
                    {
                        $override = $candidate;
                        break;
                    }
                }

                $this->_overrides[$key] = $override;
            } else $override = $this->_overrides[$key];
        }

        return $override;
    }

    /**
     * Get an activity format override key.
     *
     * @param  string $format     The activity format.
     * @param  array  $parameters Associative array containing format replacements to look for overrides.
     *
     * @return string The override key.
     */
    protected function _getOverrideKey($format, $parameters = array())
    {
        $result = $format;

        foreach ($parameters as $key => $value) {
            $result = str_replace(sprintf('{%s}', $key), $value, $result);
        }

        return $result;
    }

    /**
     * Returns a list of activity format overrides.
     *
     * @param  string $format     The activity format.
     * @param  array  $parameters Associative array containing format replacements to look for overrides.
     *
     * @return array A list of override strings.
     */
    protected function _getOverrides($format, $parameters = array())
    {
        $overrides = array();

        if (!empty($parameters))
        {
            // Get the power set of the set of parameters and construct a list of string overrides from it.
            foreach ($this->_getPowerSet(array_keys($parameters)) as $subset)
            {
                $override = $format;

                foreach ($subset as $key) {
                    $override = str_replace(sprintf('{%s}', $key), $parameters[$key], $override);
                }

                $overrides[] = $override;
            }
        }

        return $overrides;
    }

    /**
     * Returns the power set of a set represented by the elements contained in an array.
     *
     * The elements are ordered from size (subsets with more elements first) for convenience.
     *
     * @param     array $set        The set to get the power set from.
     * @param     int   $min_length The minimum amount of elements that a subset from the power set may contain.
     *
     * @return array The power set represented by an array of arrays containing elements from the provided set.
     */
    protected function _getPowerSet(array $set = array(), $min_length = 1)
    {
        $elements = count($set);
        $size     = pow(2, $elements);
        $members  = array();

        for ($i = 0; $i < $size; $i++)
        {
            $b      = sprintf("%0" . $elements . "b", $i);
            $member = array();
            for ($j = 0; $j < $elements; $j++) {
                if ($b{$j} == '1') $member[] = $set[$j];
            }

            if (count($member) >= $min_length)
            {
                if (!isset($members[count($member)])) {
                    $members[count($member)] = array();
                }

                // Group members by number of elements they contain.
                $members[count($member)][] = $member;
            }
        }

        // Sort members by number of elements (key value).
        ksort($members, SORT_NUMERIC);

        $power = array();

        // We want members with greater amount of elements first.
        foreach (array_reverse($members) as $subsets) {
            $power = array_merge($power, $subsets);
        }

        return $power;
    }
}
