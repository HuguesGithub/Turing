<?php
namespace core\actions;

use core\interfaceimpl\ConstantsInterface;
use core\interfaceimpl\UrlInterface;

if (!defined('ABSPATH')) {
    die('Forbidden');
}
/**
 * LocalActions
 * @author Hugues
 * @since v1.22.12.29
 * @version v1.22.12.29
 */
class LocalActions implements ConstantsInterface, UrlInterface
{
    /**
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    public function getToastContentJson($type, $title, $msg)
    { return '{"toastContent": '.json_encode($this->getToastContent($type, $title, $msg)).'}'; }

    /**
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    public function getToastContent($type, $title, $msg)
    {
        $strContent  = '<div class="toast fade show bg-'.$type.'">';
        $strContent .= '  <div class="toast-header">';
        $strContent .= '    <i class="fa-solid fa-exclamation-circle mr-2"></i>';
        $strContent .= '    <strong class="me-auto">'.$title.'</strong>';
        $strContent .= '  </div>';
        $strContent .= '  <div class="toast-body">'.$msg.'</div>';
        $strContent .= '</div>';
        return $strContent;
    }
    
    /**
     * @since v1.22.12.29
     * @version v1.22.12.29
     */
    public function getDismissableButton($notif, $msg)
    {
        $strContent  = '<div class="alert alert-'.$notif.' alert-dismissible fade show" role="alert">';
        $strContent .= $msg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $strContent .= '<span aria-hidden="true">×</span></button></div>';
        return $strContent;
    }
}
