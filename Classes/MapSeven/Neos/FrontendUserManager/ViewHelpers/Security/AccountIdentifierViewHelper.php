<?php
namespace MapSeven\Neos\FrontendUserManager\ViewHelpers\Security;

/*                                                                                   *
 * This script belongs to the TYPO3 Flow package "MapSeven.Neos.FrontendUserManager".*
 *                                                                                   *
 *                                                                                   */


use TYPO3\Flow\Security\Context;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Account Identifier view helper
 * Returns the Users Fullname or if not set the Account Identifier
 */
class AccountIdentifierViewHelper extends AbstractViewHelper {

	/**
	 * @var Context
	 */
	protected $securityContext;

	/**
	 * Injects the Security Context
	 *
	 * @param Context $securityContext
	 * @return void
	 */
	public function injectSecurityContext(Context $securityContext) {
		$this->securityContext = $securityContext;
	}

	/**
	 * Renders the Users Fullname or the Account Identifier
	 *
	 * @return string the rendered string
	 * @api
	 */
	public function render() {
		$user = $this->securityContext->getPartyByType('TYPO3\Neos\Domain\Model\User');
		/** @var  \TYPO3\Neos\Domain\Model\User $user */
		return ($user->getName() !== NULL) ? $user->getName()->getFullname() : $this->securityContext->getAccount()->getAccountIdentifier();
	}
}
