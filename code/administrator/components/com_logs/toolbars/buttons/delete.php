<?php
/**
* @version      $Id$
* @category		Nooku
* @package		Nooku Components
* @subpackage	Logs
* @copyright    Copyright (C) 2007 - 2011 Johan Janssens. All rights reserved.
* @license      GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
*/

/**
 * Delete button class for a toolbar
 *
 * @author      Israel Canasa <raeldc@gmail.com>
 * @category	Nooku
 * @package    	Nooku_Components
 * @subpackage 	Logs
 */
class ComLogsToolbarButtonDelete extends ComDefaultToolbarButtonDefault
{
    
    public function getOnClick()
	{
		return "$$('.-koowa-grid').each(function(form){
            form.addEvent('before.delete', function(e){
                this.options.url = 'index.php?option=com_logs&view=log';
            });
        });";
	}
}