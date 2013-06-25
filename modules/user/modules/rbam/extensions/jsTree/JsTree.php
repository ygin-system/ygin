<?php
/**
 * CJsTree displays a tree view of hierarchical data.
 *
 * It encapsulates the excellent jsTree component based on CTreeView widget.
 * ({@link http://www.jstree.com/}).
 *
 * To use CJsTree, simply sets {@link data} to the data that you want
 * to present and you are there.
 * @link http://www.yiiframework.com/extension/jstree/#doc Documentation

 *
 * @author Shocky Han <shockyhan@gmail.com>
 * @author Dimitrios Meggidis <tydeas.dr@gmail.com>
 *
 * @version 1.1
 * @package application.extensions

 * @license http://www.yiiframework.com/license/
 */
/**
 * Revision history.
 * 2010-05-14: Dimitrios Meggidis <tydeas.dr@gmail.com>
 * * Add jsTree data property
 * 2009-06-06: Shocky Han <shokyhan@gmail.com>
 * * initial release
*/
class JsTree extends CWidget
{
	/**
	 * @var array the data that can be used to generate the tree view content or used
	 * for the jstree data property.
	 * Each array element corresponds to a tree view node with the following structure:
	 * <ul>
	 * <li>text: string, required, the HTML text associated with this node.</li>
	 * <li>expanded: boolean, optional, whether the tree view node is in expanded.</li>
	 * <li>id: string, optional, the ID identifying the node. This is used
	 *   in dynamic loading of tree view (see {@link url}).</li>
	 * <li>hasChildren: boolean, optional, defaults to false, whether clicking on this
	 *   node should trigger dynamic loading of more tree view nodes from server.
	 *   The {@link url} property must be set in order to make this effective.</li>
	 * <li>children: array, optional, child nodes of this node.</li>
	 * </ul>
	 * Note, anything enclosed between the beginWidget and endWidget calls will
	 * also be treated as tree view content, which appends to the content generated
	 * from this data.
	 */
	public $data;
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile;
	/**
	 * @var string|array the URL to which the treeview can be dynamically loaded (in AJAX).
	 * See {@link CHtml::normalizeUrl} for possible URL formats.
	 * Setting this property will enable the dynamic treeview loading.
	 * When the page is displayed, the browser will request this URL with a GET parameter
	 * named 'source' whose value is 'root'. The server script should then generate the
	 * needed tree view data corresponding to the root of the tree (see {@link saveDataAsJson}.)
	 * When a node has a CSS class 'hasChildren', then expanding this node will also
	 * cause a dynamic loading of its child nodes. In this case, the value of the 'source' GET parameter
	 * is the 'id' property of the node.
	 */
	public $url;
	/**
	 * @var string|integer animation speed. This can be one of the three predefined speeds
	 * ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).
	 * If not set, no animation is used.
	 */
	public $animated;
	/**
	 * @var boolean whether the tree should start with all branches collapsed. Defaults to false.
	 */
	public $collapsed;
	/**
	 * @var string container for a tree-control, allowing the user to expand, collapse and toggle all branches with one click.
	 * In the container, clicking on the first hyperlink will collapse the tree;
	 * the second hyperlink will expand the tree; while the third hyperlink will toggle the tree.
	 * The property should be a valid jQuery selector (e.g. '#treecontrol' where 'treecontrol' is
	 * the ID of the 'div' element containing the hyperlinks.)
	 */
	public $control;
	/**
	 * @var boolean set to allow only one branch on one level to be open (closing siblings which opening).
	 * Defaults to false.
	 */
	public $unique;
	/**
	 * @var string Callback when toggling a branch. Arguments: "this" refers to the UL that was shown or hidden
	 */
	public $toggle;
	/**
	 * @var string Persist the tree state in cookies or the page location. If set to "location", looks for
	 * the anchor that matches location.href and activates that part of the treeview it.
	 * Great for href-based state-saving. If set to "cookie", saves the state of the tree on
	 * each click to a cookie and restores that state on page load.
	 */
	public $persist;
	/**
	 * @var string The cookie name to use when persisting via persist:"cookie". Defaults to 'treeview'.
	 */
	public $cookieId;
	/**
	 * @var boolean Set to skip rendering of classes and hitarea divs, assuming that is done by the serverside. Defaults to false.
	 */
	public $prerendered;
	/**
	 * @var array additional options that can be passed to the constructor of the treeview js object.
	 */
	public $options=array();
	/**
	 * @var array additional HTML attributes that will be rendered in the UL tag.
	 * The default tree view CSS has defined the following CSS classes which can be enabled
	 * by specifying the 'class' option here:
	 * <ul>
	 * <li>treeview-black</li>
	 * <li>treeview-gray</li>
	 * <li>treeview-red</li>
	 * <li>treeview-famfamfam</li>
	 * <li>filetree</li>
	 * </ul>
	 */
	public $htmlOptions;

	/*
	 * internal data for jsTree
	 */
	public $baseUrl;	// jsTree install folder. registering scripts & css's under this folder.

	/**
	 * jsTree properties.
	 * (@link <http://www.jstree.com/reference/_documentation/3_configuration.html>)
	 */
	public $selected;
	public $opened;
	public $languages;
	public $path;
	public $cookies;
	public $ui;
	public $rules;
	public $lang;
	public $callback;
	public $theme;
        public $type;
        public $plugins=array();
        private $defaultPlugins=array('themes','json_data');
	
	/**
	 * Initializes the widget.
	 * This method registers all needed client scripts and renders
	 * the tree view content.
	 */
    public function init()
    {
        if(isset($this->htmlOptions['id']))
            $id=$this->htmlOptions['id'];
        else
            $id=$this->htmlOptions['id']=$this->getId();
        if($this->url!==null)
            $this->url=CHtml::normalizeUrl($this->url);

        $dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);

        $cs=Yii::app()->getClientScript();
        $cs->registerScriptFile($this->baseUrl.'/jquery.jstree.js');

        $options=$this->getClientOptions();
        $options['plugins']=array_merge($this->defaultPlugins,$this->plugins);
        
        
        
        $options['json_data']['data']=$this->data;
        $options=CJSON::encode($options);
        
        //$cs->registerScript('Yii.CJsTree#'.$id,"$(function () { $(\"#{$id}\").tree($options); });");
        $cs->registerScript('Yii.CJsTree#'.$id,"$(\"#{$id}\").jstree($options);");

        if($this->cssFile !== null && $this->cssFile !== false)
            $cs->registerCssFile($this->cssFile);
				echo CHtml::tag('div',$this->htmlOptions,false,false)."\n";
    }



	/**
	 * Ends running the widget.
	 */
	public function run()
	{ 
		/*$this->body = "<ul>\n";
		//$this->body=$this->body.self::saveDataAsHtml($this->data);
                $this->body=$this->body.self::saveDataAsJson($this->data);
		$this->body=$this->body."\n</ul>";*/
		echo '</div>';
	}
	/**
	 * @return array the javascript options
	 */
	protected function getClientOptions()
	{
		$options=$this->options;
                
                //$optionsParams=array('selected','opened','languages','path','cookies','ui','rules','lang','callback');
                $optionsParams=array('selected','opened','languages','path','cookies','ui','rules','lang','callback','plugins','theme');
                
                if (!isset($this->data[0]) )
                {
                    
                    //If $this->data is not $data but options.
                    $optionsParams[]='data';
                    
                }
                
		foreach( $optionsParams as $name )
		{
			if($this->$name!==null)
				$options[$name]=$this->$name;
		}
                
		return $options;
	}

	/**
	 * Generates tree view nodes in HTML from the data array.
	 * @param array the data for the tree view (see {@link data} for possible data structure).
	 * @return string the generated HTML for the tree view
	 */
	public static function saveDataAsHtml($data)
	{
		$html='';
		if(is_array($data))
		{
			foreach($data as $node)
			{
				if(!isset($node['text']))
					continue;
				//$node['data']=$node['text'];
				$id=isset($node['id']) ? (' id="'.$node['id'].'"') : '';
				if(isset($node['expanded']))
					$css=$node['expanded'] ? 'open' : 'closed';
				else
					$css='';
				if(isset($node['hasChildren']) && $node['hasChildren'])
				{
					if($css!=='')
						$css.=' ';
					$css.='hasChildren';
				}
				if($css!=='')
					$css=' class="'.$css.'"';
				if(isset($node['rel']))
					$css=$css.' rel="'.$node['rel'].'"';
				$html.="<li{$id}{$css}>{$node['text']}";
				if(isset($node['children']))
				{
					$html.="\n<ul>\n";
					$html.=self::saveDataAsHtml($node['children']);
					$html.="</ul>\n";
				}
				$html.="</li>\n";
			}
		}
		return $html;
	}

	/**
	 * Saves tree view data in JSON format.
	 * This method is typically used in dynamic tree view loading
	 * when the server code needs to send to the client the dynamic
	 * tree view data.
	 * @param array the data for the tree view (see {@link data} for possible data structure).
	 * @return string the JSON representation of the data
	 */
	public static function saveDataAsJson($data)
	{
		if(empty($data))
			return '[]';
		else
			return CJSON::encode($data);

	}
}
