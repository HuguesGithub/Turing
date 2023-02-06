<?php
namespace core\bean;

use core\interfaceimpl\ConstantsInterface;
use core\interfaceimpl\UrlInterface;

if (!defined('ABSPATH')) {
    die('Forbidden');
}
/**
 * Classe UtilitiesBean
 * @author Hugues
 * @since v1.22.12.29
 * @version v1.22.12.29
 */
class UtilitiesBean implements ConstantsInterface, UrlInterface
{
    
    /**
     * @param array $attributes
     * @return string
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    private function getExtraAttributes($attributes)
    {
        $extraAttributes = '';
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $extraAttributes .= ' '.$key.'="'.$value.'"';
            }
        }
        return $extraAttributes;
    }
    
    /**
     * @param string $balise
     * @param string $label
     * @param array $attributes
     * @return string
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    protected function getBalise($balise, $label='', $attributes=array())
    {
        $strBalise = '<'.$balise.$this->getExtraAttributes($attributes);
        if (in_array($balise, array(self::TAG_INPUT))) {
            $strBalise .= '/>';
        } else {
            $strBalise .= '>'.$label.'</'.$balise.'>';
        }
        return $strBalise;
    }
    
    /**
     * @param string $label
     * @param array $attributes
     * @return string
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    protected function getButton($label, $attributes=array())
    {
        $buttonAttributes = array(
            self::ATTR_TYPE => self::TAG_BUTTON,
            self::ATTR_CLASS => 'btn btn-default btn-sm',
        );
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if (!isset($buttonAttributes[$key])) {
                    $buttonAttributes[$key]  = $value;
                } elseif ($key==self::ATTR_CLASS) {
                    $buttonAttributes[$key] .= ' '.$value;
                }
            }
        }
        return $this->getBalise(self::TAG_BUTTON, $label, $buttonAttributes);
    }
    
    /**
     * @param string $label
     * @param array $attributes
     * @return string
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    protected function getDiv($label, $attributes=array())
    { return $this->getBalise(self::TAG_DIV, $label, $attributes); }
    
    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    protected function getIcon($tag, $prefix='', $label='')
    {
        if ($prefix!='') {
            $prefix .= ' ';
        }
        $prefix .= 'fa-solid fa-';
        return $this->getBalise(self::TAG_I, $label, array(self::ATTR_CLASS=>$prefix.$tag));
    }
    
    /**
     * @param string $label
     * @param string $href
     * @param string $classe
     * @param array $extraAttributes
     * @return string
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    public function getLink($label, $href, $classe, $extraAttributes=array())
    {
        $attributes = array(
            self::ATTR_HREF => $href,
            self::ATTR_CLASS => $classe,
        );
        if (!empty($extraAttributes)) {
            foreach ($extraAttributes as $key => $value) {
                $attributes[$key]  = $value;
            }
        }
        return $this->getBalise(self::TAG_A, $label, $attributes);
    }
    
    /**
     * @param string $urlTemplate
     * @param array $args
     * @return string
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    protected function getRender($urlTemplate, $args=array())
    { return vsprintf(file_get_contents(PLUGIN_PATH.$urlTemplate), $args); }
    
    /**
     * @param string $label
     * @param array $attributes
     * @return string
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    protected function getTh($label, $attributes=array())
    {
        $buttonAttributes = array(
            'scope' => 'col',
        );
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $buttonAttributes[$key]  = $value;
            }
        }
        return $this->getBalise(self::TAG_TH, $label, $buttonAttributes);
    }
}
