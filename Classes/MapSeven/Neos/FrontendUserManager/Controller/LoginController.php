<?php
namespace MapSeven\Neos\FrontendUserManager\Controller;

/*                                                                                   *
 * This script belongs to the TYPO3 Flow package "MapSeven.Neos.FrontendUserManager".*
 *                                                                                   *
 *                                                                                   */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Security\Authentication\Controller\AbstractAuthenticationController;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use MapSeven\Neos\FrontendUserManager\Service\NodeHelperService;

/**
 * Controller that handles the frontend login
 */
class LoginController extends AbstractAuthenticationController {

	/**
	 * The pluginService
	 *
	 * @var NodeHelperService
	 * @Flow\Inject
	 */
	protected $nodeHelperService;

	/**
	 * @return void
	 */
	public function indexAction() {
	}

	/**
	 * @param ActionRequest $originalRequest The request that was intercepted by the security framework, NULL if there was none
	 * @return void
	 */
	protected function onAuthenticationSuccess(ActionRequest $originalRequest = NULL) {
		/** @var NodeInterface $node */
		$node = $this->request->getInternalArgument('__node');
		if ($node->getNodeType()->getName() === 'MapSeven.Neos.FrontendUserManager:Login') {
			$redirectNode = $node->getProperty('redirect');
			if ($redirectNode === NULL) {
				$redirectNode = $node->getContext()->getCurrentSiteNode();
			}
		} else {
			$redirectNode = $node;
		}
		$uri = $this->nodeHelperService->getUriForNode($redirectNode, $this->controllerContext);
		$this->redirectToUri($uri);
	}

}