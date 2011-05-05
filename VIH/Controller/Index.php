<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Index extends k_Component
{
    public $i18n = array(
        'January' => 'januar',
        'Februrary' => 'februar',
        'March' => 'marts',
        'May' => 'maj',
        'June' => 'juni',
        'July' => 'juli',
        'October' => 'oktober'
    );
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        throw new k_SeeOther('http://vih.dk');

    }

    function getSubContent()
    {
        $tpl = $this->template->create('News/sidebar-featured');

        $data = array('nyheder' => $tpl->render($this, array('nyheder' => VIH_News::getList('', 1, 'Høj'))),
                      'kurser' => VIH_Model_LangtKursus::getNext());

        $tpl = $this->template->create('frontpage-sidebar');
        return $tpl->render($this, $data);
    }
}
