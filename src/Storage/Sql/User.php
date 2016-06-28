<?php declare(strict_types=1);

namespace Gitilicious\Storage\Sql;

use Gitilicious\Form\Install as InstallationForm;

class User
{
    private $dbConnection;

    public function __construct(\PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function createFromInstallation(InstallationForm $form)
    {
        $query = 'INSERT INTO users';
        $query.= ' (username, name, email, password, admin)';
        $query.= ' VALUES';
        $query.= ' (:username, :name, :email, :password, :admin)';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute([
            'username' => $form['username']->getValue(),
            'name'     => $form['name']->getValue(),
            'email'    => $form['email']->getValue(),
            'password' => $form['password']->getValue(),
            'admin'    => $form['admin']->getValue(),
        ]);
    }
}
