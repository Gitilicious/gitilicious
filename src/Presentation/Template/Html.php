<?php declare(strict_types=1);

namespace Gitilicious\Presentation\Template;

use CodeCollab\Template\Html as BaseTemplate;
use CodeCollab\Theme\Loader;
use CodeCollab\I18n\Translator;
use CodeCollab\Authentication\Authentication;
use CodeCollab\CsrfToken\Token;

class Html extends BaseTemplate
{
    private $theme;

    private $translator;

    protected $user;

    protected $csrfToken;

    public function __construct(
        string $basePage,
        Loader $theme,
        Translator $translator,
        Authentication $user,
        Token $csrfToken
    )
    {
        parent::__construct($basePage);

        $this->theme      = $theme;
        $this->translator = $translator;
        $this->user       = $user;
        $this->csrfToken  = $csrfToken;
    }

    public function render(string $template, array $data = []): string
    {
        return parent::render($this->theme->load($template), $data);
    }

    public function renderPage(string $template, array $data = []): string
    {
        $content = $this->render($template, $data);

        $output = '';

        try {
            ob_start();

            require $this->theme->load($this->basePage);
        } finally {
            $output = ob_get_clean();
        }

        return $output;
    }

    protected function translate(string $key, array $data = []): string
    {
        return $this->translator->translate($key, $data);
    }
}
