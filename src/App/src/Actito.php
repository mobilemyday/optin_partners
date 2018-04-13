<?php

namespace App;

use Exception;

class Actito extends HttpClient
{
	const NEW_PASSWORD_REQUEST_MAIL_ID = 30;

	protected $baseUrl = 'https://api.actito.com/ActitoWebServices/ws/v4';

	protected $config;

	public function __construct(array $config)
	{
		if(!$config || empty($config) || empty($config['actito']))
		{
			throw new Exception('APP configuration should be set');
		}

		$this->config = $config['actito'];

		if(empty($this->config['auth']))
		{
			throw new Exception('Actito auth configuration is missing');
		}
	}

	/**
	 * @param string $mail
	 * @return int
	 * @throws Exception
	 */
	public function getIdMail($mail)
	{
		if(!isset($this->config['mails']))
		{
			throw new Exception('Mail configuration is missing');
		}

		$mailConfig = $this->config['mails'];

		if(!isset($mailConfig[$mail]))
		{
			throw new Exception(sprintf('Mail "%s" configuration is missing', $mail));
		}

		$idMail = $mailConfig[$mail]['idMail'];

		return (int)$idMail;
	}

	/**
	 * @param string $mail
	 * @param string $setting
	 * @param mixed $default
	 * @return mixed
	 */
	public function getSetting($mail, $setting, $default = null)
	{
		$value = $default;

		if(
			isset($this->config['mails'])
			&& isset($this->config['mails'][$mail])
			&& isset($this->config['mails'][$mail]['settings'])
			&& isset($this->config['mails'][$mail]['settings'][$setting])
		)
		{
			$value = $this->config['mails'][$mail]['settings'][$setting];
		}

		return $value;
	}

	/**
	 * @param $idProfile
	 * @param $idCampaign
	 * @param array $params
	 * @return bool|mixed
	 */
	public function sendTransactionalEmail($idProfile, $idCampaign, $params = [])
	{
		$data = [];

		if(count($params))
		{
			foreach ($params as $key => $value)
			{
				$data[] = (object)[
					'key' => $key,
					'values' => $value,
				];
			}
		}

		$entity = $this->config['entity'];
		$username = $this->config['auth']['username'];
		$password = $this->config['auth']['password'];

		$url = $this->getBaseUrl() . sprintf('/entity/%s/mail/%s/profile/%s', $entity, $idCampaign, $idProfile);

		$this->setUrl($url);
		$this->setClient();

		curl_setopt($this->client, CURLOPT_USERPWD, $username . ":" . $password);

		$response = $this->post($data, true);

		if($response)
		{
			try {
				$object = json_decode($response);

				if($object && isset($object->interactionId))
				{
					return $object->interactionId;
				}
				else {
					error_log(print_r($object, true));
				}
			}
			catch (Exception $exception)
			{
				error_log($exception->getMessage());
			}
		}
		return null;
	}

	public function getProfileByEmail($email)
	{
		$entity = $this->config['entity'];
		$table = $this->config['table'];
		$username = $this->config['auth']['username'];
		$password = $this->config['auth']['password'];

		$url = $this->getBaseUrl() . sprintf('/entity/%s/table/%s/profile/%s', $entity, $table, "emailAddress=$email");

		$this->setUrl($url);
		$this->setClient();

		curl_setopt($this->client, CURLOPT_USERPWD, $username . ":" . $password);

		$response = $this->get();

		if($response)
		{
			try {
				$object = json_decode($response);

				return $object;
			}
			catch (Exception $exception)
			{
				error_log($exception->getMessage());
				return false;
			}
		}
		return false;
	}

	public function getTransactionalEmails()
	{
		$entity = $this->config['entity'];
		$table = $this->config['table'];
		$username = $this->config['auth']['username'];
		$password = $this->config['auth']['password'];

		$url = $this->getBaseUrl() . sprintf('/entity/%s/mail?type=CONTINUOUS', $entity);

		$this->setUrl($url);
		$this->setClient();

		curl_setopt($this->client, CURLOPT_USERPWD, $username . ":" . $password);

		$response = $this->get();

		if($response)
		{
			try {
				$response = json_decode($response);

				$mails = [];

				if(isset($response->mailDocuments) && count($response->mailDocuments))
				{
					foreach ($response->mailDocuments as $mailDocument)
					{
						if($mailDocument->targetTable == $table)
						{
							$mails[] = $mailDocument;
						}
					}
				}

				return $mails;
			}
			catch (Exception $exception)
			{
				return false;
			}
		}
		return false;
	}

	public function getEmailDetails($name)
	{
		$entity = $this->config['entity'];
		$username = $this->config['auth']['username'];
		$password = $this->config['auth']['password'];

		$url = $this->getBaseUrl() . sprintf('/entity/%s/mail/%s', $entity, $name);

		$this->setUrl($url);
		$this->setClient();

		curl_setopt($this->client, CURLOPT_USERPWD, $username . ":" . $password);

		$response = $this->get();

		if($response)
		{
			try {
				$response = json_decode($response);
				return $response;
			}
			catch (Exception $exception)
			{
				return false;
			}
		}
		return false;
	}

	public function saveUser($email, $language, $firstname = '', $lastname = '')
	{
		$data = (object)[
			'attributes' => [
				(object)array(
					"name" => "firstName",
					"value" => $firstname
				),
				(object)array(
					"name" => "lastName",
					"value" => $lastname
				),
				(object)array(
					"name" => "emailAddress",
					"value" => $email
				),
				(object)array(
					"name" => "motherLanguage",
					"value" => $language
				)
			],
			'subscriptions' => [],
			'segmentations' => [],
		];

		$entity = $this->config['entity'];
		$table = $this->config['table'];
		$username = $this->config['auth']['username'];
		$password = $this->config['auth']['password'];

		$url = $this->getBaseUrl() . sprintf('/entity/%s/table/%s/profile', $entity, $table);

		$this->setUrl($url);
		$this->setClient();

		curl_setopt($this->client, CURLOPT_USERPWD, $username . ":" . $password);

		$response = $this->post($data, true);

		if($response)
		{
			try {
				$response = json_decode($response);

				if($response && isset($response->profileId))
				{
					return $response->profileId;
				}

				return false;
			}
			catch (Exception $exception)
			{
				return false;
			}
		}
		return false;
	}
}