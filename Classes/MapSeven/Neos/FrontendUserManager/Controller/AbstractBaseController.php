<?php
namespace MapSeven\Neos\FrontendUserManager\Controller;

/*                                                                                   *
 * This script belongs to the TYPO3 Flow package "MapSeven.Neos.FrontendUserManager".*
 *                                                                                   *
 *                                                                                   */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Neos\Domain\Repository\DomainRepository;
use MapSeven\Neos\FrontendUserManager\Service\NodeHelperService;

/**
 * An action controller with base functionality
 *
 * @Flow\Scope("singleton")
 */
abstract class AbstractBaseController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Context
	 */
	protected $securityContext;

	/**
	 * The pluginService
	 *
	 * @var NodeHelperService
	 * @Flow\Inject
	 */
	protected $nodeHelperService;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @param array $settings
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

}
