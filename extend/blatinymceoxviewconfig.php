<?php

/*
 * TinyMCE Editor for OXID eShop CE 4.5
 * Copyright (C) 2016  bestlife AG
 * info:  oxid@bestlife.ag
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>
 *
 * Marat Bedoev
 */

class blaTinyMceOxViewConfig extends blaTinyMceOxViewConfig_parent
{
    
    protected $_aTinyMCE_classes = array(
        "article_main",
        "category_text",
        "content_main",
        "newsletter_main",
        "news_text"
        );
        
    protected $_aTinyMCE_plaincms = array(
        "oxadminorderplainemail",
        "oxadminordernpplainemail", // bestellbenachrichtigung admin + fremdländer
        "oxuserorderplainemail",
        "oxuserordernpplainemail",
        "oxuserorderemailendplain", // bestellbenachrichtigung user + fremdländer + abschluss
        "oxordersendplainemail", // versandbestätigung
        "oxregisterplainemail",
        "oxregisterplainaltemail", // registrierung
        "oxupdatepassinfoplainemail", // passwort update
        "oxnewsletterplainemail", // newsletter
        "oxemailfooterplain", // email fußtext
        "oxrighttocancellegend",
        "oxrighttocancellegend2", // widerrufsrecht
        "oxstartmetadescription",
        "oxstartmetakeywords" // META Tags
        );

    protected $_aTinyMCE_buttons = array(
        "undo redo",
        "bold italic underline strikethrough",
        "alignleft aligncenter alignright alignjustify",
        "bullist numlist",
        "outdent indent",
        "blockquote",
        "removeformat",
        "subscript",
        "superscript",
        "formatselect",
        "fontselect",
        "fontsizeselect",
        "subscript superscript"
        );
        
    protected $_aTinyMCE_plugins = array(
            'advlist',
            'anchor',
            'autolink',
            'autoresize',
            'charmap',
            'code',
            'colorpicker',
            'fullscreen',
            'hr',
            'image',
            'imagetools',
            'insertdatetime',
            'link',
            'lists',
            'media',
            'nonbreaking',
            'pagebreak',
            'paste',
            'preview',
            'searchreplace',
            'spellchecker',
            'table',
            'textcolor',
            'visualblocks',
            'wordcount'
        );

    public function loadTinyMce()
    {
        $cfg        = $this->getConfig();
        $oLang      = oxLang::getInstance();
        $blEnabled  = in_array($this->getActiveClassName(), $this->_aTinyMCE_classes);
        $blPlainCms = in_array($cfg->getActiveView()->getViewDataElement("edit")->oxcontents__oxloadid->value, $this->_aTinyMCE_plaincms);

        if (!$blEnabled)
        {
            return;
        }
        if ($blPlainCms)
        {
            return "this is a plain cms. nix gut html!";
        }

        // processind editor config & other stuff
        $sLang = $oLang->getLanguageAbbr($oLang->getTplLanguage());
        // array to assign shops lang abbreviations to lang file names of tinymce: shopLangAbbreviation => fileName (without .js )
        $aLang = array(
            "cs" => "cs",
            "da" => "da",
            "de" => "de",
            "fr" => "fr_FR",
            "it" => "it",
            "nl" => "nl",
            "ru" => "ru"
        );


        // default config
        $aDefaultConfig = array(
            'selector'                => '"textarea:not(.mceNoEditor)"',
            'language'                => '"' . (in_array($sLang, $aLang) ? $aLang[$sLang] : 'en') . '"',
            //'spellchecker_language'   => '"' . (in_array($sLang, $aLang) ? $aLang[$sLang] : 'en') . '"',
            'nowrap'                  => 'true',
            'entity_encoding'         => '"raw"',
            // http://www.tinymce.com/wiki.php/Configuration:entity_encoding
            'height'                  => 300,
            'menubar'                 => 'false',
            'document_base_url'       => '"' . $this->getBaseDir() . '"',
            // http://www.tinymce.com/wiki.php/Configuration:document_base_url
            'relative_urls'           => 'false',
            // http://www.tinymce.com/wiki.php/Configuration:relative_urls

            'plugin_preview_width'    => 'window.innerWidth',
            'plugin_preview_height'   => 'window.innerHeight-90',
            'code_dialog_width'       => 'window.innerWidth-50',
            'code_dialog_height'      => 'window.innerHeight-130',
            'image_advtab'            => 'true',
            'imagetools_toolbar'      => '"rotateleft rotateright | flipv fliph | editimage imageoptions"',
            'moxiemanager_fullscreen' => 'true',
            'insertdatetime_formats'  => '[ "%d.%m.%Y", "%H:%M" ]',
            'nonbreaking_force_tab'   => 'true',
            // http://www.tinymce.com/wiki.php/Plugin:nonbreaking
            'autoresize_max_height'   => '400'
        );
        //merging with custom config
        $aConfig = ($aCustomCfg = $this->_getTinyCustConfig()) ? array_merge($aDefaultConfig,$aCustomCfg) : $aDefaultConfig;


        // default plugins and their buttons
        $aPluginsControls = array(
            'advlist'        => false,
            'anchor'         => 'anchor',
            'autolink'       => false,
            'autoresize'     => false,
            'charmap'        => 'charmap',
            'code'           => 'code',
            'colorpicker'    => false,
            //'emoticons'      => 'emoticons',
            'fullscreen'     => 'fullscreen',
            'hr'             => 'hr',
            'image'          => 'image',
            'imagetools'     => false,
            'insertdatetime' => 'insertdatetime',
            'link'           => 'link unlink',
            'lists'          => false,
            'media'          => 'media',
            'nonbreaking'    => false,
            'pagebreak'      => 'pagebreak',
            'paste'          => 'pastetext',
            'preview'        => 'preview',
            'searchreplace'  => 'searchreplace',
            //'spellchecker'   => 'spellchecker',
            'table'          => 'table',
            'textcolor'      => 'forecolor backcolor',
            'visualblocks'   => false,
            //'visualchars'    => 'visualchars',
            'wordcount'      => false
        );

        $aPlugins = $cfg->getConfigParam("aTinyMCE_plugins");
        if (empty($aPlugins) || !is_array($aPlugins)) $aPlugins = array_keys($aPluginsControls);
        if ($this->getActiveClassName() == "newsletter_main")
        {
            $aPlugins["legacyoutput"] = false;
            $aPlugins["fullpage"]     = "fullpage";
        }

        $aConfig['plugins'] = '"' . implode(' ', $aPlugins) . '"';

        // external plugins
        if ($aExtPlugins = $this->_getTinyExtPlugins())
        {
            $aConfig['external_plugins'] = '{ ';
            foreach ($aExtPlugins AS $plugin => $file)
            {
                $aConfig['external_plugins'] .= '"' . $plugin . '": "' . $file . '", ';
            }
            $aConfig['external_plugins'] .= ' }';
        }

        // default tollbar buttons
        $aDefaultButtons = array(
            "undo redo",
            "bold italic underline strikethrough",
            "alignleft aligncenter alignright alignjustify",
            "bullist numlist",
            "outdent indent",
            "blockquote",
            "removeformat",
            "subscript",
            "superscript",
            "formatselect",
            "fontselect",
            "fontsizeselect",
            "subscript superscript"
        );
        $aButtons = $this->_getTinyToolbarControls();
        if (!is_array($aButtons) || empty($aButtons)) $aButtons = $aDefaultButtons;

        // buttons for plugins, enable only if plugin is active
        $aPluginButtons = array_values(array_intersect_key($aPluginsControls, array_flip($aPlugins)));

        $aButtons = array_merge($aButtons, $aPluginButtons);

        $aConfig['toolbar'] = '"' . implode(" | ", $aButtons) . '"';


        // compile the whole config stuff
        $sConfig = '';
        foreach ($aConfig AS $param => $value)
        {
            $sConfig .= "$param: $value, ";
        }

        // add init script
        $sInit = 'tinymce.init({ ' . $sConfig . ' });';

        $sCopyLongDescFromTinyMCE = 'function copyLongDescFromTinyMCE(sIdent)
{
    var editor = tinymce.get("editor_"+sIdent);
    if (editor && editor.isHidden() !== true)
    {
        console.log("copy content from tinymce");
        var content = editor.getContent().replace(/\[{([^\]]*?)}\]/g, function(m) { return m.replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&amp;/g, "&") });
        document.getElementsByName("editval[" + sIdent + "]").item(0).value = content;
        return true;
    }
    return false;
}

var origCopyLongDesc = copyLongDesc;
copyLongDesc = function(sIdent)
{
    if ( copyLongDescFromTinyMCE( sIdent ) ) return;
    console.log("tinymce disabled, copy content from regular textarea");
    origCopyLongDesc( sIdent );
}';

        // adding scripts to template
        /*
        $smarty = oxUtilsView::getSmarty();
        $sSufix = ($smarty->_tpl_vars["__oxid_include_dynamic"]) ? '_dynamic' : '';

        $aScript   = (array)$cfg->getGlobalParameter('scripts' . $sSufix);
        $aScript[] = $sCopyLongDescFromTinyMCE;
        $aScript[] = $sInit;
        $cfg->setGlobalParameter('scripts' . $sSufix, $aScript);

        $aInclude      = (array)$cfg->getGlobalParameter('includes' . $sSufix);
        $aInclude[3][] = $this->getModuleUrl('bla-tinymce', 'tinymce/tinymce.min.js');
        $cfg->setGlobalParameter('includes' . $sSufix, $aInclude);
        */

        return '<li style="margin-left: 50px;">
                    <script type="text/javascript" src="'.$this->getModuleUrl('bla-tinymce', 'tinymce/tinymce.min.js').'"></script>
                    <script type="text/javascript">
                    '.$sCopyLongDescFromTinyMCE.'
                    '.$sInit.'
                    </script>
                    <button style="border: 1px solid #0089EE; color: #0089EE;padding: 3px 10px; margin-top: -10px; background: white;" onclick="tinymce.each(tinymce.editors, function(editor) { if(editor.isHidden()) { editor.show(); } else { editor.hide(); } });">
                        <span>TinyMCE zeigen/verstecken</span>
                    </button>
                </li>';
        // javascript:tinymce.execCommand(\'mceToggleEditor\',false,\'editor1\');
    }

    protected function _getTinyToolbarControls()
    {
        $aControls = $this->_aTinyMCE_buttons;
        return $aControls;
    }

    protected function _getTinyExtPlugins()
    {
        $aPlugins = $this->_aTinyMCE_external_plugins;
        return $aPlugins;
    }

    protected function _getTinyCustConfig()
    {
        return false;
    }
}
