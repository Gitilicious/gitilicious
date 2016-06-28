<?php declare(strict_types=1);

namespace Gitilicious\Form;

use CodeCollab\Form\BaseForm;
use CodeCollab\Form\Field\Csrf as CsrfField;
use CodeCollab\Form\Validation\Required as RequiredValidator;
use CodeCollab\Form\Validation\Match as MatchValidator;

class Csrf extends BaseForm
{
    /**
     * Sets up the fields of the form
     */
    protected function setupFields()
    {
        $this->addField(new CsrfField('csrfToken', [
            new RequiredValidator(),
            new MatchValidator(base64_encode($this->csrfToken->get())),
        ], base64_encode($this->csrfToken->get())));
    }
}
