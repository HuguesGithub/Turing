<?php
/**
 * Plugin Name: HJ - Turing Machine
 * Description: Site Web Turing Machine
 * @author Hugues
 * @since 1.22.12.29
 * @version 1.22.12.29
 */
define('PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_PACKAGE', 'Turing');
session_start([]);

class Turing
{
  public function __construct()
  {
    add_filter('template_include', array($this,'template_loader'));
  }

  public function template_loader()
  {
    wp_enqueue_script('jquery');
    return PLUGIN_PATH.'web/pages/publique/main-publique-page.php';
  }
}
$Turing = new Turing();

/**
#######################################################################################
###  Autoload des classes utilisées
### Description: Gestion de l'inclusion des classes
#######################################################################################
*/
spl_autoload_register(PLUGIN_PACKAGE.'_autoloader');
function turing_autoloader($classname)
{
    $matches = array();
    $arr = array(
        'Actions' => 'actions',
        'Bean' => 'bean',
        'Class' => 'domain',
        'DaoImpl' => 'daoimpl',
        'Interface' => 'interfaceimpl',
        'Services' => 'services',
    );
    $pattern = "/(Actions|Bean|Class|DaoImpl|Interface|Services)/";
    if (preg_match($pattern, $classname, $matches)) {
        if (strpos($classname, '\\')!==false) {
            $classname = substr($classname, strrpos($classname, '\\')+1);
        }

        $filePath = PLUGIN_PATH.'core/'.$arr[$matches[1]].'/'.$classname.'.php';
        if (isset($arr[$matches[1]]) && file_exists($filePath)) {
            include_once($filePath);
        }
    }
}
/**
#######################################################################################
### Ajout d'une action Ajax
### Description: Entrance point for Ajax Interaction.
#######################################################################################
*/
add_action('wp_ajax_dealWithAjax', 'dealWithAjax_callback');
add_action('wp_ajax_nopriv_dealWithAjax', 'dealWithAjax_callback');
function dealWithAjax_callback()
{
    echo core\actions\AjaxActions::dealWithAjax();
    die();
}


/**
#######################################################################################
### Gestion des Exceptions
### Description: Met en forme les exceptions
#######################################################################################
*/
function exception_handler($objException)
{
  echo
    '<div class="card border-danger" style="max-width: 100%;margin-right: 15px;">'.
    '  <div class="card-header bg-danger text-white"><strong>'.$objException->getMessage().'</strong></div>'.
    '  <div class="card-body text-danger">'.
    '    <p>Une erreur est survenue dans le fichier <strong>'.$objException->getFile().
    '</strong> à la ligne <strong>'.$objException->getLine().'</strong>.</p>'.
    '    <ul class="list-group">';

  $arrTraces = $objException->getTrace();
    foreach ($arrTraces as $trace) {
        echo '<li class="list-group-item">Fichier <strong>'.$trace['file'];
        echo '</strong> ligne <em>'.$trace['line'].'</em> :<br>';
        if (is_array($trace['args'])) {
            echo $trace['function'].'()</li>';
        } else {
            echo $trace['class'].$trace['type'].$trace['function'].'('.implode(', ', $trace['args']).')</li>';
        }
    }

  echo
    '    </ul>'.
    '  </div>'.
    '  <div class="card-footer"></div>'.
    '</div>';
}
set_exception_handler('exception_handler');

