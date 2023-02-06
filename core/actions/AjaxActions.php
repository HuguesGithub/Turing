<?php
namespace core\actions;

if (!defined('ABSPATH')) {
    die('Forbidden');
}
/**
 * AjaxActions
 * @author Hugues
 * @since v1.22.12.29
 * @version v1.22.12.29
 */
class AjaxActions extends LocalActions
{

    /**
     * Gère les actions Ajax
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    public static function dealWithAjax()
    {
        $obj        = new AjaxActions();
		$criteriaId = $_POST['criteriaId'];
		$fileName   = 'https://turing.jhugues.fr/wp-content/plugins/hj-turing/'.self::WEB_PP_FRAGMENTS.'publique-fragments-criteria-'.$criteriaId.'.tpl';
		return '{"criteria": '.json_encode(vsprintf(file_get_contents($fileName), array())).', "fileName": '.json_encode($fileName).'}';
    }

}
