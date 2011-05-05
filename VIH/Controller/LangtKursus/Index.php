<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Index extends k_Component
{
    private $dbquery;

    public $map = array(
        'okonomi'              => 'VIH_Controller_LangtKursus_Okonomi',
        'login'                => 'VIH_Controller_LangtKursus_Login_Index',
        'betalingsbetingelser' => 'VIH_Controller_LangtKursus_Betalingsbetingelser'
    );
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function wrapHtml($content)
    {
        $data = array('content' => $content);

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }

    function map($name)
    {
        if (!empty($this->map[$name])) {
            return $this->map[$name];
        }
        return 'VIH_Controller_LangtKursus_Show';
    }

    function renderHtml()
    {
        throw new k_SeeOther('http://vih.dk/langekurser');
    }
}
