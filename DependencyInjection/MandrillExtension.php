<?php
namespace Solomo\Bundle\MandrillBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;


class MandrillExtension extends Extension {
	
	public function load(array $configs, ContainerBuilder $container){
		
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.xml');
		
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);
		
		$container->setParameter('mandrill.client.endpoint', $config['endpoint']);
		$container->setParameter('mandrill.client.key', $config['key']);
		
	}
}