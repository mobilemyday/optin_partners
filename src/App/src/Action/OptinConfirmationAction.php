<?php

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use PointOfSale\Model\ConnectedInterestTable;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template;

class OptinConfirmationAction implements ServerMiddlewareInterface
{
    private $connectedInterestTable;

    private $urlHlper;

    private $template;

    public function __construct(
		ConnectedInterestTable $connectedInterestTable,
		UrlHelper $urlHelper,
		Template\TemplateRendererInterface $template = null)
    {
		$this->connectedInterestTable = $connectedInterestTable;
		$this->urlHlper               = $urlHelper;
		$this->template               = $template;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
		$partner = $request->getAttribute('partner');

		return new HtmlResponse($this->template->render('app::optin-confirmation', [
			'partner' => $partner,
		]));
    }
}
