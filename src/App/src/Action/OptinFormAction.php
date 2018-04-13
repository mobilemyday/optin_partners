<?php

namespace App\Action;

use Exception;
use DateTime;
use DateTimeZone;
use Locale;
use App\Api\PointOfSale as PointOfSaleApi;
use App\Form\InterestForm;
use App\Form\InterestFormFilter;
use App\Model\CodeType;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use PointOfSale\Model\ConnectedOptin;
use PointOfSale\Model\ConnectedOptinTable;
use PointOfSale\Model\ConnectedForm;
use PointOfSale\Model\ConnectedFormsOldSoftware;
use PointOfSale\Model\ConnectedFormTable;
use PointOfSale\Model\ConnectedFormsOldSoftwareTable;
use PointOfSale\Model\ConnectedInterest;
use PointOfSale\Model\ConnectedInterestTable;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\ServerUrlHelper;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template;
use Zend\Session\Container;

class OptinFormAction implements ServerMiddlewareInterface
{
	/**
	 * @var ServerRequestInterface
	 */
	private $request;

	private $pointOfSaleApi;

	private $connectedFormTable;

	private $connectedInterestTable;

	private $connectedFormsOldSoftwareTable;

	private $connectedOptinTable;

    private $urlHelper;

    private $serverUrlHelper;

    private $template;

    private $interestForm;

    public function __construct(
		InterestForm $interestForm,
		PointOfSaleApi $pointOfSaleApi,
		ConnectedFormTable $connectedFormTable,
		ConnectedInterestTable $connectedInterestTable,
		ConnectedFormsOldSoftwareTable $connectedFormsOldSoftwareTable,
		ConnectedOptinTable $connectedOptinTable,
    	UrlHelper $urlHelper,
    	ServerUrlHelper $serverUrlHelper,
		Template\TemplateRendererInterface $template = null
	)
	{
		$this->interestForm                   = $interestForm;
		$this->pointOfSaleApi                 = $pointOfSaleApi;
		$this->connectedFormTable             = $connectedFormTable;
		$this->connectedInterestTable         = $connectedInterestTable;
		$this->connectedFormsOldSoftwareTable = $connectedFormsOldSoftwareTable;
		$this->connectedOptinTable            = $connectedOptinTable;
		$this->urlHelper                      = $urlHelper;
		$this->serverUrlHelper                = $serverUrlHelper;
		$this->template                       = $template;
	}

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
    	$this->request = $request;

    	$token = $request->getAttribute('token');
		$partner = $request->getAttribute('partner');
		$locale  = $request->getAttribute('locale');

		$interest = $this->connectedInterestTable->fetchByToken($token);

		if(!$interest || $this->connectedOptinTable->isAlreadyOptIn($interest->idPointOfSale))
		{
			if($partner)
			{
				$url = $this->urlHelper->generate('optin.partner.confirmation', [
					'locale' => $this->getLocaleUri($locale),
					'partner' => $partner,
				]);
			}
			else {
				$url = $this->urlHelper->generate('optin.confirmation');
			}

			return new RedirectResponse($url);
		}

		$viewData = [];

		$interestForm = $this->interestForm;

		$filter = new InterestFormFilter();

		$interestForm->setInputFilter($filter->getInputFilter());

		if($request->getMethod() === 'POST')
		{
			$postData = $request->getParsedBody();

			$interestForm->setData($postData);

			if($interestForm->isValid())
			{
				try {
					$idConnectedForm = $this->saveFormData($postData, $interest, $partner, $locale);

					if($idConnectedForm)
					{
						if($partner)
						{
							$url = $this->urlHelper->generate('optin.partner.confirmation', [
								'locale' => $this->getLocaleUri($locale),
								'partner' => $partner,
							]);
						}
						else {
							$url = $this->urlHelper->generate('optin.confirmation');
						}

						return new RedirectResponse($url);
					}
				}
				catch (Exception $exception)
				{
					$viewData['errorMessage'] = $exception->getMessage();
				}
			}
		}
		else {

			$form = $this->connectedFormTable->getRow($interest->idPointOfSaleConnectedForm);
			$oldSoftware = $this->connectedFormsOldSoftwareTable->fetchByFormId($interest->idPointOfSaleConnectedForm);

			$dbData = [
				'code'            => $form->code,
				'sex'             => $form->sex,
				'lastname'        => $form->lastname,
				'firstname'       => $form->firstname,
				'email'           => $form->email,
				'pointOfSaleName' => $form->pointOfSaleName,
				'street'          => $form->street,
				'number'          => $form->number,
				'box'             => $form->box,
				'city'            => $form->city,
				'zip'             => $form->zip,
				'idSoftware'      => ($form->idSoftware) ? $form->idSoftware : 'other',
				'otherSoftware'   => $form->otherSoftware,
				'optin_mmd'       => 1,
				'optin_partner'   => 1,
			];

			if($oldSoftware)
			{
				$dbData['software_has_change'] = 1;
				$dbData['old_idSoftware']      = ($oldSoftware->idSoftware) ? $oldSoftware->idSoftware : 'other';
				$dbData['old_otherSoftware']   = $oldSoftware->otherSoftware;
			}

			$interestForm->setData($dbData);
		}


		$viewData['interestForm'] = $interestForm;
		$viewData['partner'] = $partner;
		$viewData['name'] = 'mobile my day';

        return new HtmlResponse($this->template->render('app::interest', $viewData));
    }

	/**
	 * @param array $postData
	 * @param ConnectedInterest $interest
	 * @param string $partner
	 * @param string $locale
	 * @return int
	 * @throws Exception
	 */
    protected function saveFormData($postData, $interest, $partner, $locale)
	{
		$databaseConnection = $this->connectedFormTable->getConnection();
		$databaseConnection->beginTransaction();

		try {
			$now = new DateTime('now', new DateTimeZone('Europe/Brussels'));

			$connectedForm = new ConnectedForm();

			$connectedForm->idPointOfSaleCodeType = CodeType::ID_APB;
			$connectedForm->code                  = !empty($postData['code']) ? $postData['code'] : null;
			$connectedForm->email                 = !empty($postData['email']) ? $postData['email'] : null;
			$connectedForm->firstname             = !empty($postData['firstname']) ? $postData['firstname'] : null;
			$connectedForm->lastname              = !empty($postData['lastname']) ? $postData['lastname'] : null;
			$connectedForm->sex                   = !empty($postData['sex']) ? $postData['sex'] : null;
			if($postData['idSoftware'] != 'other')
			{
				$connectedForm->idSoftware = !empty($postData['idSoftware']) ? (int)$postData['idSoftware'] : null;
			}
			$connectedForm->otherSoftware         = !empty($postData['otherSoftware']) ? $postData['otherSoftware'] : null;
			$connectedForm->pointOfSaleName       = !empty($postData['pointOfSaleName']) ? $postData['pointOfSaleName'] : null;
			$connectedForm->language              = Locale::getPrimaryLanguage($locale);
			$connectedForm->country               = Locale::getRegion($locale);
			$connectedForm->zip                   = !empty($postData['zip']) ? $postData['zip'] : null;
			$connectedForm->city                  = !empty($postData['city']) ? $postData['city'] : null;
			$connectedForm->street                = !empty($postData['street']) ? $postData['street'] : null;
			$connectedForm->number                = !empty($postData['number']) ? $postData['number'] : null;
			$connectedForm->box                   = !empty($postData['box']) ? $postData['box'] : null;

			$idConnectedForm = $this->connectedFormTable->saveRow($connectedForm);

			if(isset($postData['software_has_change']) && $postData['software_has_change'] == 1)
			{
				$connectedFormOldSoftware = new ConnectedFormsOldSoftware();

				$connectedFormOldSoftware->idPointOfSaleConnectedForm = $idConnectedForm;
				if($postData['old_idSoftware'] != 'other')
				{
					$connectedFormOldSoftware->idSoftware = !empty($postData['old_idSoftware']) ? (int)$postData['old_idSoftware'] : null;
				}
				$connectedFormOldSoftware->otherSoftware = !empty($postData['old_otherSoftware']) ? $postData['old_otherSoftware'] : null;

				$idConnectedFormOldSoftware = $this->connectedFormsOldSoftwareTable->saveRow($connectedFormOldSoftware);
			}


			$pointOfSale = $this->pointOfSaleApi->getByAPB($postData['code']);


			$optin = new ConnectedOptin();

			$serverParams = $this->request->getServerParams();

			$optin->idPointOfSaleConnectedInterest = $interest->id;
			$optin->idPointOfSaleConnectedForm = $idConnectedForm;
			$optin->idPointOfSale = $pointOfSale->id;
			$optin->date = $now->format('Y-m-d H:i:s');
			$optin->ip = (!empty($serverParams['REMOTE_ADDR']))? $serverParams['REMOTE_ADDR'] : null;
			$optin->status = 0;

			$idOptin = $this->connectedOptinTable->saveRow($optin);

			$sessionContainer = new Container('OptinForm');
			$sessionContainer->id = $idOptin;

			$databaseConnection->commit();

			return $idConnectedForm;
		}
		catch (Exception $exception)
		{
			$databaseConnection->rollback();

			error_log($exception->getMessage());

			throw new Exception('An error occurred, please contact us if the problem persist');
		}
	}

	private function getLocaleUri($locale)
	{
		return strtolower(Locale::getRegion($locale)) . '-' . Locale::getPrimaryLanguage($locale);
	}

	protected function getIdClientFromPartner($partner)
	{
		switch ($partner)
		{
			case 'patchpharma':
				return 102;
			default:
				return null;
		}
	}
}
