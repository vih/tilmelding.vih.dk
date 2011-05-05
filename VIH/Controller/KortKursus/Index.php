<?php
if (!defined('KORTEKURSER_STATUS_FÅ_LEDIGE_PLADSER')) {
    define('KORTEKURSER_STATUS_FÅ_LEDIGE_PLADSER', 10);
}

if (!defined('KORTEKURSER_STATUS_UDSOLGT')) {
    define('KORTEKURSER_STATUS_UDSOLGT', 0);
}

class VIH_Controller_KortKursus_Index extends k_Component
{
    private $main;
    private $content;
    private $table;
    private $news_tpl;
    protected $kernel;
    protected $template;

    function __construct(k_TemplateFactory $template, VIH_Intraface_Kernel $kernel, DB_Sql $db_sql)
    {
        $this->template = $template;
        $this->kernel = $kernel;
        $this->db_sql = $db_sql;
    }

    function map($name)
    {
        if ($name == 'golf') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'kajak') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'camp') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'cykel') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'familiekursus') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'sommerhøjskole') {
            return 'VIH_Controller_KortKursus_Group';
        } elseif ($name == 'login') {
            return 'VIH_Controller_KortKursus_Login_Index';
        } elseif ($name == 'praktiskeoplysninger') {
            return 'VIH_Controller_KortKursus_Praktiskeoplysninger';
        } else {
            return 'VIH_Controller_KortKursus_Show';
        }
    }

    function renderHtml()
    {
        return new k_SeeOther('http://vih.dk/kortekurser');
    }

    function getGateway()
    {
        return new VIH_Model_KortKursusGateway($this->db_sql);
    }

    function getSubContent()
    {
        $tpl = $this->template->create('spot');

        $data = array('headline' => 'Brochure',
                      'text' => 'Bestil en brochure fra vores <a href="'.$this->url('/bestilling/').'">bestillingsside</a>.');
        $content = $tpl->render($this, $data);

        $data = array('headline' => 'Praktiske oplysninger',
                      'text' => '<a href="'.$this->url('./praktiskeoplysninger').'">Læs om de praktiske oplysninger</a>.');
        $content .= $tpl->render($this, $data);

        return $content;
    }

    function getWidePictureUrl($identifier)
    {
        $filemanager = new Ilib_Filehandler_Manager($this->kernel);

        try {
            $img = new Ilib_Filehandler_ImageRandomizer($filemanager, array($identifier));
            $file = $img->getRandomImage();
        } catch (Exception $e) {
            return $this->url('/gfx/images/højskole.jpg');
        }

        $instance = $file->createInstance('widepicture');
        $editor_img_uri = $instance->get('file_uri');
        $editor_img_height = $instance->get('height');
        $editor_img_width = $instance->get('width');

        return $this->url('/file.php') . $instance->get('file_uri_parameters');
    }
}
