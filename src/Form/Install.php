<?php declare(strict_types=1);

namespace Gitilicious\Form;

use CodeCollab\CsrfToken\Token;
use CodeCollab\Form\Field\Text as TextField;
use CodeCollab\Form\Field\Password as PasswordField;
use CodeCollab\Form\Field\Email as EmailField;
use CodeCollab\Form\Field\Select as SelectField;
use CodeCollab\Form\Field\Checkbox as CheckboxField;
use CodeCollab\Form\Validation\Required as RequiredValidator;
use CodeCollab\Form\Validation\Options as OptionsValidator;

class Install extends Csrf
{
    private $baseDirectory;

    public function __construct(Token $csrfToken, string $baseDirectory)
    {
        $this->baseDirectory = $baseDirectory;

        parent::__construct($csrfToken);
    }

    protected function setupFields()
    {
        parent::setupFields();

        $this->addField(new TextField('username', [
            new RequiredValidator(),
        ]));

        $this->addField(new PasswordField('password', [
            new RequiredValidator(),
        ]));

        $this->addField(new PasswordField('password2', [
            new RequiredValidator(),
        ]));

        $this->addField(new TextField('name', [
            new RequiredValidator(),
        ]));

        $this->addField(new EmailField('email', [
            new RequiredValidator(),
        ]));

        $this->addField(new TextField('repodir', [
            new RequiredValidator(),
        ], realpath($this->baseDirectory . '/repositories')));

        $this->addField(new TextField('gitbinary', [
            new RequiredValidator(),
        ], '/usr/bin/git'));

        $this->addField(new SelectField('theme', [
            new RequiredValidator(),
            new OptionsValidator(['Default']),
        ]));

        $this->addField(new SelectField('language', [
            new RequiredValidator(),
            new OptionsValidator(['en_US']),
        ]));

        $this->addField(new TextField('dbname', [
            new RequiredValidator(),
        ]));

        $this->addField(new TextField('dbhostname', [
            new RequiredValidator(),
        ]));

        $this->addField(new TextField('dbusername', [
            new RequiredValidator(),
        ]));

        $this->addField(new TextField('dbpassword', [
            new RequiredValidator(),
        ]));

        $this->addField(new SelectField('mailtransport', [
            new RequiredValidator(),
            new OptionsValidator(['none', 'sendmail', 'smtp']),
        ]));

        $this->addField(new TextField('mailusername'));

        $this->addField(new TextField('mailpassword'));

        $this->addField(new TextField('mailhostname'));

        $this->addField(new TextField('mailport'));

        $this->addField(new CheckboxField('mailssl'));
    }

    public function validate()
    {
        parent::validate();

        if ($this->fieldset['password']->getValue() !== $this->fieldset['password2']->getValue()) {
            $this->fieldset['password']->invalidate('nomatch');
            $this->fieldset['password2']->invalidate('nomatch');

            $this->valid = false;
        }
    }
}
