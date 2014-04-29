<?php
namespace MapSeven\Neos\FrontendUserManager;

/*                                                                                   *
 * This script belongs to the TYPO3 Flow package "MapSeven.Neos.FrontendUserManager".*
 *                                                                                   *
 *                                                                                   */

use TYPO3\Flow\Configuration\ConfigurationManager;
use TYPO3\Flow\Core\Bootstrap;
use TYPO3\Flow\Package\Package as BasePackage;

/**
 * The FrontendUserManager Package
 *
 */
class Package extends BasePackage {

	/**
	 *
	 * @param \TYPO3\Flow\Core\Bootstrap $bootstrap The current bootstrap
	 * @return void
	 */
	public function boot(Bootstrap $bootstrap) {
		$dispatcher = $bootstrap->getSignalSlotDispatcher();
		/**
		 * define a constant PROVIDER_NAME from the settings
		 * so the providerName can be used as constant in the Neos AccountExistsValidator as option
		 */
		$dispatcher->connect('TYPO3\Flow\Configuration\ConfigurationManager', 'configurationManagerReady', function(ConfigurationManager $configurationManager) {
			$settings = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_SETTINGS, 'MapSeven.Neos.FrontendUserManager');
			define('PROVIDER_NAME', $settings['providerName']);
		});
	}
}
