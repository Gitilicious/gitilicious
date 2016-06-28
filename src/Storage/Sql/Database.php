<?php declare(strict_types=1);

namespace Gitilicious\Storage\Sql;

use Gitilicious\Form\Install as InstallationForm;

class Database
{
    public function createTables(InstallationForm $form)
    {
        $dbConnection = $this->createConnection(
            $form['dbname']->getValue(),
            $form['dbhostname']->getValue(),
            $form['dbusername']->getValue(),
            $form['dbpassword']->getValue()
        );

        $this->createUserTable($dbConnection, $form['dbusername']->getValue());
    }

    private function createConnection(string $name, string $host, string $username, string $password)
    {
        return new \PDO(sprintf('pgsql:dbname=%s;host=%s', $name, $host), $username, $password, [
            \PDO::ATTR_EMULATE_PREPARES   => false,
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }

    private function createUserTable(\PDO $dbConnection, string $username)
    {
        $query = 'CREATE TABLE users (';
        $query.= '    id integer NOT NULL,';
        $query.= '    username character varying(128) NOT NULL,';
        $query.= '    name character varying(128) NOT NULL,';
        $query.= '    email character varying(256) NOT NULL,';
        $query.= '    password character varying(256) NOT NULL,';
        $query.= '    admin boolean DEFAULT false NOT NULL';
        $query.= ');';

        $dbConnection->exec($query);

        $dbConnection->exec(sprintf('ALTER TABLE users OWNER TO %s', $username));
        $dbConnection->exec('CREATE SEQUENCE users_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1');
        $dbConnection->exec(sprintf('ALTER TABLE users_id_seq OWNER TO %s', $username));
        $dbConnection->exec('ALTER SEQUENCE users_id_seq OWNED BY users.id');
        $dbConnection->exec('ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval(\'users_id_seq\'::regclass)');
    }
}
