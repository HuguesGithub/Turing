<?php
namespace core\bean;

if (!defined('ABSPATH')) {
    die('Forbidden');
}
/**
 * Classe WpPageHomeBean
 * @author Hugues
 * @since v1.22.12.29
 * @version v1.22.12.29
 */
class WpPageHomeBean extends WpPageBean
{

    /**
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    public function getContentPage()
    {
        $liAttributes = array(
            self::ATTR_CLASS => 'dropdown-item',
            'data-trigger' => 'click',
        );
        $strOptions = '';
        for ($nb=1; $nb<49; $nb++) {
            $liAttributes['data-criteria-id'] = $nb;
            $strOptions .= $this->getBalise(self::TAG_LI, $nb, $liAttributes);
        }
        
        $arrAllowedRanks = array('A', 'B', 'C', 'D', 'E', 'F');
        $strCriteria = '';
        $btnDropDown  = '<button type="button" class="btn btn-success btn-outline-dark dropdown-toggle ';
        $btnDropDown .= 'text-white fw-bold" data-trigger="dropdown" aria-expanded="false">&nbsp;</button>';
        while (!empty($arrAllowedRanks)) {
            $rk = array_shift($arrAllowedRanks);
            $ulAttributes = array(
                self::ATTR_CLASS=>'dropdown-menu',
                'data-criteria-rank'=>$rk,
                'style'=>'max-height: 200px; overflow: auto;'
            );
            $ul = $this->getBalise(self::TAG_UL, $strOptions, $ulAttributes);
            $div = $this->getBalise(self::TAG_DIV, $btnDropDown.$ul, array(self::ATTR_CLASS=>'btn-group', 'role'=>'group'));
            $labelAttributes = array(self::ATTR_CLASS=>'btn btn-light btn-outline-dark text-success mb-0');
            $label = $this->getBalise(self::TAG_LABEL, $rk, $labelAttributes);
            $div = $this->getBalise(self::TAG_DIV, $label.$div, array(self::ATTR_CLASS=>'col-2 btn-group'));
            $div .= '<div class="col-10 d-flex btn-group text-center criteria" data-criteria-display="'.$rk.'"></div>';
            $strCriteria .= $this->getBalise(self::TAG_DIV, $div, array(self::ATTR_CLASS=>'row mb-1'));
        }

        // Contenu de #panelCodes
        $liAttributes = array(self::ATTR_CLASS=>'list-group-item bg-light btn-outline-dark');
        $ulAttributes = array(self::ATTR_CLASS=>'list-group mb-3');
        $divAttributes = array(self::ATTR_CLASS=>'col-2 offset-1');

        $strCodes = '';
        for ($t=1; $t<=5; $t++) {
            $liAttributes['data-t'] = $t;
            $divColContent = '';
            for ($c=1; $c<=5; $c++) {
                $liAttributes['data-c'] = $c;
                $ulContent = '';
                for ($r=1; $r<=5; $r++) {
                    $liAttributes['data-r'] = $r;
                    $ulContent .= $this->getBalise(self::TAG_LI, $t.$c.$r, $liAttributes);
                }
                $divColContent .= $this->getBalise(self::TAG_UL, $ulContent, $ulAttributes);
            }
            $strCodes .= $this->getBalise(self::TAG_DIV, $divColContent, $divAttributes);
            $divAttributes = array(self::ATTR_CLASS=>'col-2');
        }
        // Fin contenu de #panelCodes
        
        return $this->getRender(self::WEB_PP_BOARD, array($strCriteria, $strCodes));
    }

}
