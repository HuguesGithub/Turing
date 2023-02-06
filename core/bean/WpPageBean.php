<?php
namespace core\bean;

if (!defined('ABSPATH')) {
    die('Forbidden');
}
/**
 * Classe WpPageBean
 * @author Hugues
 * @since v1.22.12.29
 * @version v1.22.12.29
 */
class WpPageBean extends LocalBean
{
    /**
     * WpPost affiché
     */
    protected $WpPage;

    /**
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    public static function getPageBean()
    { return new WpPageHomeBean(); }

}
