<?php
namespace MapSeven\Neos\FrontendUserManager\Service;

/*                                                                                   *
 * This script belongs to the TYPO3 Flow package "MapSeven.Neos.FrontendUserManager".*
 *                                                                                   *
 *                                                                                   */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ControllerContext;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * Helper methods for Node Handling
 */
class NodeHelperService {

	/**
	 * Returns the Uri of a given node
	 *
	 * @param NodeInterface $node A TYPO3\TYPO3CR\Domain\Model\NodeInterface object to resolve the current document node
	 * @param ControllerContext $controllerContext
	 * @return string The rendered URI or NULL if no URI could be resolved for the given node
	 */
	public function getUriForNode(NodeInterface $node, ControllerContext $controllerContext) {
		if ($node === NULL || !$node instanceof NodeInterface) {
			return NULL;
		}
		$request = $controllerContext->getRequest()->getMainRequest();
		$uriBuilder = clone $controllerContext->getUriBuilder();
		$uriBuilder->setRequest($request);
		return $uriBuilder
				->reset()
				->setCreateAbsoluteUri(TRUE)
				->setFormat($request->getFormat())
				->uriFor('show', array('node' => $node), 'Frontend\Node', 'TYPO3.Neos');
	}
}
