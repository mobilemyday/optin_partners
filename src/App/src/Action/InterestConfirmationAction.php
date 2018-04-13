<?php

namespace App\Action;

use Locale;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use PointOfSale\Model\ConnectedInterestTable;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template;
use Zend\Session\Container;

class InterestConfirmationAction implements ServerMiddlewareInterface
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
		$sessionContainer = new Container('InterestForm');

		$idInterest = $sessionContainer->id;
		$partner = $request->getAttribute('partner');
		$locale = $request->getAttribute('locale');

		if($idInterest)
		{
			$interest = $this->connectedInterestTable->getRow($idInterest);

			if($interest)
			{
				return new HtmlResponse($this->template->render('app::interest-confirmation', [
					'partner' => $partner,
				]));
			}
		}

		$url = $this->urlHlper->generate('interest.form', [
			'locale' => $this->getLocaleUri($locale),
			'partner' => $partner,
		]);
		return new RedirectResponse($url);
    }

	private function getLocaleUri($locale)
	{
		return strtolower(Locale::getRegion($locale)) . '-' . Locale::getPrimaryLanguage($locale);
	}
}
