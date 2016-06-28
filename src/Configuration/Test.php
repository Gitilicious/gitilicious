<?php declare(strict_types=1);

namespace Gitilicious\Configuration;

class Test
{
    const MINIMUM_VERSION = '0.1.1';

    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;

        $this->validate();
    }

    private function validate()
    {
        $requiredOptions = ['version', 'initialized', 'theme'];

        foreach ($requiredOptions as $requiredOption) {
            if (!array_key_exists($requiredOption, $this->configuration)) {
                throw new InvalidConfigurationException(
                    'Configuration could not be parsed. Missing required key: ' . $requiredOption
                );
            }
        }
    }

    public function isInstalled(): bool
    {
        return $this->configuration['initialized'];
    }
}
