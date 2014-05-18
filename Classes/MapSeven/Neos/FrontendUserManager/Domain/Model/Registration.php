<?php
namespace MapSeven\Neos\FrontendUserManager\Domain\Model;

/*                                                                                   *
 * This script belongs to the TYPO3 Flow package "MapSeven.Neos.FrontendUserManager".*
 *                                                                                   *
 *                                                                                   */

use TYPO3\Flow\Annotations as Flow;

/**
 * Domain Model of a Registration
 *
 */
class Registration {

	/**
	 * @var string
	 * @Flow\Validate(type="Label")
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=255 })
	 * @Flow\Validate(type="\TYPO3\Neos\Validation\Validator\AccountExistsValidator", options={ "authenticationProviderName"=PROVIDER_NAME})
	 */
	protected $username = '';

	/**
	 * @var array
	 * @Flow\Validate(type="\TYPO3\Neos\Validation\Validator\PasswordValidator", options={ "allowEmpty"=0, "minimum"=6, "maximum"=255 })
	 */
	protected $password = array();

	/**
	 * @var string
	 * @Flow\Validate(type="EmailAddress")
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $email = '';

	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=255 })
	 */
	protected $firstName = '';

	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=255 })
	 */
	protected $lastName = '';

	/**
	 * @param string $username
	 * @return void
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param array $password
	 * @return void
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return array
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $firstName
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @param string $lastName
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}
}