<?php
class VIH_Controller_Info_Organisation extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Organisation';
        $meta['description'] = 'En beskrivelse af Vejle Idrætshøjskoles organisation - herunder beslutningsprocedurer.';
        $meta['keywords'] = 'Vejle, Idrætshøjskole, organisation, repræsentantskab, beslutningsprocedure, besluttende organer';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';

        $tpl = $this->template->create('Info/organisation');
        return $tpl->render($this);
    }
}