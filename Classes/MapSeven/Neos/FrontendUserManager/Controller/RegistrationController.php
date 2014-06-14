<?php
namespace MapSeven\Neos\FrontendUserManager\Controller;

/*                                                                                   *
 * This script belongs to the TYPO3 Flow package "MapSeven.Neos.FrontendUserManager".*
 *                                                                                   *
 *                                                                                   */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Security\Account;
use TYPO3\Flow\Security\AccountFactory;
use TYPO3\Flow\Security\AccountRepository;
use TYPO3\Flow\Security\Authentication\TokenInterface;
use TYPO3\Neos\Domain\Model\User;
use TYPO3\Neos\Service\PluginService;
use TYPO3\Party\Domain\Model\ElectronicAddress;
use TYPO3\Party\Domain\Model\PersonName;
use TYPO3\Party\Domain\Repository\PartyRepository;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use MapSeven\Neos\FrontendUserManager\Domain\Model\Registration;

/**
 * Controller that handles the Frontend User Registrations
 */
class RegistrationController extends AbstractBaseController {

	/**
	 * @Flow\Inject
	 * @var AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var PartyRepository
	 */
	protected $partyRepository;

	/**
	 * @Flow\Inject
	 * @var AccountFactory
	 */
	protected $accountFactory;

	/**
	 * The pluginService
	 *
	 * @var PluginService
	 * @Flow\Inject
	 */
	protected $pluginService;

	/**
	 * @return void
	 */
	public function indexAction() {
	}

	/**
	 * creates an account
	 *
	 * @param Registration $registration
	 */
	public function createAction(Registration $registration) {
		$electronicAddress = new ElectronicAddress();
		$electronicAddress->setType(ElectronicAddress::TYPE_EMAIL);
		$electronicAddress->setIdentifier($registration->getEmail());
		$user = new User();
		$user->setName(new PersonName('', $registration->getFirstName(), '', $registration->getLastName(), '', $registration->getUsername()));
		$user->addElectronicAddress($electronicAddress);
		$this->partyRepository->add($user);

		$roleIdentifiers = $this->settings['registration']['defaultRole'];
		$password = $registration->getPassword();
		$password = array_shift($password);
		$account = $this->accountFactory->createAccountWithPassword($registration->getUsername(), $password, $roleIdentifiers, $this->settings['providerName']);
		$user->addAccount($account);
		$this->accountRepository->add($account);

		$this->executePluginSettings($account);
	}

	/**
	 * @param Account $account
	 */
	protected function executePluginSettings(Account $account) {
		/** @var NodeInterface $node */
		$node = $this->request->getInternalArgument('__node');

		$autoLogin = $node->getProperty('autoLogin');
		if ($autoLogin === TRUE) {
			$this->executeAutoLogin($account);
		}

		$redirectNode = $node->getProperty('redirect');
		$this->executeRedirect($node, $redirectNode);
	}

	/**
	 * Executes a login after an account is created - if defined in the plugin settings
	 *
	 * @param Account $account
	 * @return void
	 */
	protected function executeAutoLogin(Account $account) {
		$authenticationTokens = $this->securityContext->getAuthenticationTokensOfType('TYPO3\Flow\Security\Authentication\Token\UsernamePassword');
		if (count($authenticationTokens) === 1) {
			$authenticationTokens[0]->setAccount($account);
			$authenticationTokens[0]->setAuthenticationStatus(TokenInterface::AUTHENTICATION_SUCCESSFUL);
		}
	}

	/**
	 * Executes a redirect to the configured node or to the site node if no node for redirect is set
	 *
	 * @param NodeInterface $node
	 * @param NodeInterface $redirectNode
	 */
	protected function executeRedirect(NodeInterface $node, NodeInterface $redirectNode = NULL) {
		if ($redirectNode === NULL) {
			$redirectNode = $node->getContext()->getCurrentSiteNode();
		}
		$uri = $this->nodeHelperService->getUriForNode($redirectNode, $this->controllerContext);
		$this->redirectToUri($uri);
	}

	/**
	 * @return boolean Disable the default error flash message
	 */
	protected function getErrorFlashMessage() {
		return FALSE;
	}
}
