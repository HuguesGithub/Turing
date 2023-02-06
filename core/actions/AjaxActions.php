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
        $criteriaId = $_POST['criteriaId'];
        if ($criteriaId>=1 && $criteriaId<=23) {
            $fileName = self::URL_PLUGIN.self::WEB_PP_FRAGMENTS.'publique-fragments-criteria-'.$criteriaId.'.tpl';
            $criteriaContent = vsprintf(file_get_contents($fileName), array());
        } else {
            $fileName = 'publique-fragments-criteria-'.$criteriaId.'.tpl';
            $criteriaContent = 'Le fichier '.$fileName.' n\'existe pas.';
        }
        return '{"criteria": '.json_encode($criteriaContent).', "fileName": '.json_encode($fileName).'}';
    }

}
