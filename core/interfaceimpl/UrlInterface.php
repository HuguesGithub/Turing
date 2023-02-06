<?php
namespace core\interfaceimpl;

if (!defined('ABSPATH')) {
    die('Forbidden');
}
/**
 * @author Hugues
 * @since v1.22.12.29
 * @version v1.22.12.29
 */
interface UrlInterface
{
    // Plug-in
    const URL_PLUGIN       = 'https://turing.jhugues.fr/wp-content/plugins/hj-turing/';
    
    // Directories
    const WEB_PAGES_PUBLIC = 'web/pages/publique/';
    const WEB_PP_FRAGMENTS = self::WEB_PAGES_PUBLIC.'fragments/';
    
    // Files
    const WEB_PP_BOARD     = self::WEB_PAGES_PUBLIC.'publique-board.tpl';
}
