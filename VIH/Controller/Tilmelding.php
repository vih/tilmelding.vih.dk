<?php
class VIH_Controller_Tilmelding extends k_Component
{
    public $map = array(
        'langekurser'  => 'VIH_Controller_LangtKursus_Index',
        'kortekurser'  => 'VIH_Controller_KortKursus_Index',
        'bestilling'   => 'VIH_Controller_MaterialeBestilling_Index',
        'file'         => 'Ilib_Filehandler_Controller_Viewer');
    protected $dbquery;
    protected $template;
    protected $kernel;

    function __construct(k_TemplateFactory $template, VIH_Intraface_Kernel $kernel)
    {
        $this->template = $template;
        $this->kernel = $kernel;
    }

    function map($name)
    {
        return $this->map[$name];
    }

    function renderHtml()
    {
        return new k_SeeOther('http://vih.dk');
    }

    function wrapHtml($content)
    {
        $model = array(
            'content' => $content,
            'navigation' => array(
                array('url' => 'http://vih.dk/langekurser', 'navigation_name' => 'Lange kurser'),
                array('url' => 'http://vih.dk/kortekurser', 'navigation_name' => 'Korte kurser')
            ),
            'url' => $this->url('/'),
            'site_info' => '<a href="'.$this->url('/kontakt') .'">Vejle Idrætshøjskole</a> Ørnebjervej 28 7100 Vejle Tlf. 7582 0811 ' . email('kontor@vih.dk'),
            'name' => 'Vejle Idrætshøjskole',
            'navigation_section' => array(
                array('url' => 'http://kursuscenter.vih.dk/', 'navigation_name' => 'Kursuscenter'),
                array('url' => 'http://elevforeningen.vih.dk/', 'navigation_name' => 'Elevforeningen'),
                array('url' => 'http://vies.dk/', 'navigation_name' => 'Efterskole')
            ),
            'trail' => $this->document->trail,
            'title' => $this->document->title()
        );

        $tpl = $this->template->create('body');
        $content = $tpl->render($this, $model);

        $data = array(
            'content' => $content,
            'meta' => $this->document->meta,
            'styles' => $this->document->styles(),
            'scripts' => $this->document->scripts(),
            'feeds' => $this->document->rss,
            'body_id' => $this->document->body_id,
            'protocol' => $this->document->protocol,
            'body_class' => $this->document->body_class,
            'theme' => $this->document->theme,
            'title' => $this->document->title()
        );

        $tpl = $this->template->create('main');
        return $tpl->render($this, $data);
    }

    function getSidePicture()
    {
        if (!empty($this->document->sidepicture)) {
            return ' style="background-image: url('.$this->document->sidepicture.')"';
        }

        if (!strstr($this->document->body_class, 'sidepicture')) {
            return '';
        }

        if (strstr($this->document->body_class, 'widepicture')) {
            $size = 'widepicture';
            $standard = $this->url('/gfx/images/hojskole.jpg');
        } elseif (strstr($this->document->body_class, 'sidepicture')) {
            $size = 'sidepicture';
            $standard = $this->url('/gfx/images2/sidepic3.jpg');
        } else {
            return '';
        }

        $module = $this->kernel->module('filemanager');
        $filemanager = new Ilib_Filehandler_Manager($this->kernel);

        if (!empty($this->document->theme)) {
            $keywords = array('worthshowing', $this->document->theme);
        } else {
            $keywords = array('worthshowing');
        }

        try {
            require_once 'Intraface/modules/filemanager/ImageRandomizer.php';
            $img = new ImageRandomizer($filemanager, $keywords);
            $file = $img->getRandomImage();
            $instance = $file->getInstance($size);
            $editor_img_uri = $this->url('/file.php') . $instance->get('file_uri_parameters');
            return ' style="background-image: url('.$editor_img_uri.')"';
        } catch (Exception $e) {
            return ' style="background-image: url('.$standard.')"';
        }
    }

    function getHighlight()
    {
        $keywords = array('topbar');
        if (!is_array($keywords)) {
            throw new Exception('parameter should be an array with keywords');
        }

        $keyword_ids = array();
        foreach ($keywords as $keyword) {
            $keyword_object = new Ilib_Keyword(new VIH_News);
            // @todo: This is not really good, but the only way to identify keyword on name!
            $keyword_ids[] = $keyword_object->save(array('keyword' => $keyword));
        }

        $this->getDBQuery()->setKeyword((array)$keyword_ids);

        $db = $this->getDBQuery()->getRecordset("nyhed.id", "", false);

        $news = array();

        while ($db->nextRecord()) {
            $news[] = new VIH_News($db->f('id'));
        }

        if (empty($news)) {
            return '<p>Spørgsmål til højskoleophold eller rundvisning<span>Kontakt Peter Sebastian på 2929 6387 eller ps@vih.dk.</span></p>';
        } else {
            return '<p>'.$news[0]->get('title').'<span>'.$news[0]->get('tekst').'</span></p>';
        }
    }

    function getSubContent()
    {
        return '<h2>Sidelinjen</h2><p>This will be some side content later on</p>';
    }

    function getDBQuery()
    {
        if ($this->dbquery) {
            return $this->dbquery;
        }
        $dbquery = new Ilib_DBQuery("nyhed", "nyhed.active = 1");
        return ($this->dbquery = $dbquery);
    }
}
