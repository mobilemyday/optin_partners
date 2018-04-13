<?php

namespace App\Action;

use App\Actito;
use App\Api\PointOfSale as PointOfSaleApi;
use Exception;
use DateTime;
use DateTimeZone;
use Locale;
use App\Form\InterestForm;
use App\Form\InterestFormFilter;
use App\Model\CodeType;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use PointOfSale\Model\ConnectedInterestEmail;
use PointOfSale\Model\ConnectedInterestEmailTable;
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

class InterestFormAction implements ServerMiddlewareInterface
{
	private $pointOfSaleApi;

	private $connectedFormTable;

	private $connectedInterestTable;

	private $connectedInterestEmailTable;

	private $connectedFormsOldSoftwareTable;

	private $connectedOptinTable;

    private $urlHelper;

    private $serverUrlHelper;

    private $template;

    private $interestForm;

    private $actitoApi;

    public function __construct(
		InterestForm $interestForm,
		PointOfSaleApi $pointOfSaleApi,
		ConnectedFormTable $connectedFormTable,
		ConnectedInterestTable $connectedInterestTable,
		ConnectedInterestEmailTable $connectedInterestEmailTable,
		ConnectedFormsOldSoftwareTable $connectedFormsOldSoftwareTable,
		ConnectedOptinTable $connectedOptinTable,
    	UrlHelper $urlHelper,
    	ServerUrlHelper $serverUrlHelper,
		Template\TemplateRendererInterface $template = null,
		Actito $actitoApi
	)
	{
		$this->interestForm                   = $interestForm;
		$this->pointOfSaleApi                 = $pointOfSaleApi;
		$this->connectedFormTable             = $connectedFormTable;
		$this->connectedInterestTable         = $connectedInterestTable;
		$this->connectedInterestEmailTable    = $connectedInterestEmailTable;
		$this->connectedFormsOldSoftwareTable = $connectedFormsOldSoftwareTable;
		$this->connectedOptinTable            = $connectedOptinTable;
		$this->urlHelper                      = $urlHelper;
		$this->serverUrlHelper                = $serverUrlHelper;
		$this->template                       = $template;
		$this->actitoApi                      = $actitoApi;
	}

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
		$viewData = [];

		$partner = $request->getAttribute('partner');
		$locale  = $request->getAttribute('locale');

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
					$idConnectedForm = $this->saveFormData($postData, $partner, $locale);

					if($idConnectedForm)
					{
						if($partner)
						{
							$url = $this->urlHelper->generate('interest.partner.confirmation', [
								'locale' => $this->getLocaleUri($locale),
								'partner' => $partner,
							]);
						}
						else {
							$url = $this->urlHelper->generate('interest.confirmation');
						}

						return new RedirectResponse($url);
					}
				}
				catch (Exception $exception)
				{
					$viewData['errorMessage'] = $exception->getMessage();
				}
			}
			else {
				error_log(print_r($interestForm->getMessages(), true));
			}
		}


		$viewData['interestForm'] = $interestForm;
		$viewData['partner'] = $partner;
		$viewData['name'] = 'mobile my day';

        return new HtmlResponse($this->template->render('app::interest', $viewData));
    }

    protected function saveFormData($postData, $partner, $locale)
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

			$interest = new ConnectedInterest();

			$now = new DateTime('now', new DateTimeZone('Europe/Brussels'));

			$interest->idPointOfSaleConnectedForm = $idConnectedForm;
			$interest->typeSource                 = 'website';
			$interest->idClient                   = $this->getIdClientFromPartner($partner);
			$interest->idPointOfSale              = ($pointOfSale) ? $pointOfSale->id : null;
			$interest->date                       = $now->format('Y-m-d H:i:s');
			$interest->isErrorPointOfSale         = ($pointOfSale) ? 0 : 1;
			$interest->token                      = bin2hex(random_bytes(15));
			//$interest->isErrorEmail               = '';
			$interest->isAlreadyOptin             = ($pointOfSale) ? (int)$this->connectedOptinTable->isAlreadyOptIn($pointOfSale->id) : 0;
			$interest->status                     = 0;

			$sessionContainer = new Container('InterestForm');

			$idInterest = $this->connectedInterestTable->saveRow($interest);

			$path = $this->urlHelper->generate('optin.form', [
				'locale' => $this->getLocaleUri($locale),
				'partner' => $partner,
				'token' => $interest->token,
			]);
			$url = $this->serverUrlHelper->generate($path);

			$idMail = $this->sendInterestEmail(
				$postData['email'],
				Locale::getPrimaryLanguage($locale),
				$postData['firstname'],
				$postData['lastname'],
				$url
			);

			$interestEmail                                 = new ConnectedInterestEmail();
			$interestEmail->idPointOfSaleConnectedInterest = $idInterest;
			$interestEmail->idMail                         = $idMail;

			$this->connectedInterestEmailTable->saveRow($interestEmail);

			$sessionContainer->id = $idInterest;

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

	private function sendInterestEmail($email, $language, $firstname, $lastname, $url)
	{
		$profile = $this->actitoApi->getProfileByEmail($email);

		if(!isset($profile->profileId))
		{
			$idProfile = $this->actitoApi->saveUser($email, $language, $firstname, $lastname);
		}
		else {
			$idProfile = $profile->profileId;
		}

		$idMail = $this->actitoApi->getIdMail('interest');

		return $this->actitoApi->sendTransactionalEmail($idProfile, $idMail, [
			'token' => [$url],
			'TOKEN' => [$url],
		]);
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
