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
interface ConstantsInterface
{
    /////////////////////////////////////////////////
    // Action Ajax
    const AJAX_ACTION            = 'ajaxAction';
    
    /////////////////////////////////////////////////
    // Attributs
    const ATTR_CLASS             = 'class';
    const ATTR_DATA_AJAX         = 'data-ajax';
    const ATTR_DATA_TARGET       = 'data-target';
    const ATTR_DATA_TRIGGER      = 'data-trigger';
    const ATTR_DATA_TYPE         = 'data-type';
    const ATTR_HREF              = 'href';
    const ATTR_ID                = 'id';
    const ATTR_NAME              = 'name';
    const ATTR_SELECTED          = 'selected';
    const ATTR_STYLE             = 'style';
    const ATTR_TITLE             = 'title';
    const ATTR_TYPE              = 'type';
    const ATTR_VALUE             = 'value';
    
    /////////////////////////////////////////////////
    // Css
    const CSS_BTN_DARK           = 'btn-dark';
    const CSS_DISABLED           = 'disabled';
    
    /////////////////////////////////////////////////
    // Constantes
    const CST_ACTION             = 'action';
    const CST_ACTIVE             = 'active';
    const CST_ALL                = 'all';
    const CST_AMP                = '&amp;';
    const CST_BLANK              = ' ';
    const CST_CHECKED            = 'checked';
    const CST_CHILDREN           = 'children';
    const CST_CONFIRM            = 'confirm';
    const CST_CSV_EXPORT         = 'csvExport';
    const CST_CURPAGE            = 'curPage';
    const CST_DELETE             = 'delete';
    const CST_DISABLED           = 'disabled';
    const CST_EDIT               = 'edit';
    const CST_EOL                = "\r\n";
    const CST_ERR_LOGIN          = 'err_login';
    const CST_EXPORT             = 'export';
    const CST_ICON               = 'icon';
    const CST_IDS                = 'ids';
    const CST_LABEL              = 'label';
    const CST_NBSP               = '&nbsp;';
    const CST_ONGLET             = 'onglet';
    const CST_POST_ACTION        = 'postAction';
    const CST_RIGHT              = 'right';
    const CSV_SEP                = ';';
    const CST_SUBONGLET          = 'subOnglet';
    const CST_TEXT_WHITE         = 'text-white';
    const CST_WRITE              = 'write';
    
    /////////////////////////////////////////////////
    // Icons
    const I_ANGLE_LEFT           = 'angle-left';
    const I_ANGLES_LEFT          = 'angles-left';
    const I_CARET_LEFT           = 'caret-left';
    const I_CARET_RIGHT          = 'caret-right';
    const I_CHALKBOARD           = 'chalkboard';
    const I_CIRCLE               = 'circle';
    const I_DELETE               = 'trash-can';
    const I_DESKTOP              = 'desktop';
    const I_DOWNLOAD             = 'download';
    const I_EDIT                 = 'pen-to-square';
    const I_FILTER_CIRCLE_XMARK  = 'filter-circle-xmark';
    const I_REFRESH              = 'arrows-rotate';
    const I_SCHOOL               = 'school';
    const I_SQUARE_CHECK         = 'square-check';
    const I_SQUARE_XMARK         = 'square-xmark';
    const I_USER_GRADUATE        = 'user-graduate';
    const I_USERS                = 'users';
    
    /////////////////////////////////////////////////
    // Notifications
    const NOTIF_DANGER           = 'danger';
    const NOTIF_SUCCESS          = 'success';
    const NOTIF_WARNING          = 'warning';

    /////////////////////////////////////////////////
    // Tags
    const TAG_A                   = 'a';
    const TAG_BUTTON              = 'button';
    const TAG_DIV                 = 'div';
    const TAG_I                   = 'i';
    const TAG_INPUT               = 'input';
    const TAG_LABEL               = 'label';
    const TAG_LI                  = 'li';
    const TAG_OPTION             = 'option';
    const TAG_P                   = 'p';
    const TAG_SELECT             = 'select';
    const TAG_STRONG              = 'strong';
    const TAG_TD                  = 'td';
    const TAG_TH                  = 'th';
    const TAG_TR                  = 'tr';
    const TAG_UL                  = 'ul';
    
    /////////////////////////////////////////////////
    // Divers
    const VERSION                = 'v1.22.12.29';
}
