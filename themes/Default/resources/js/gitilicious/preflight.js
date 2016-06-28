/**
 * Preflight installation modal
 */
(function($) {
    'use strict';

    function Preflight() {
        this.passed = true;

        this.tests = [
            'checkDatabaseConnection',
            'checkDatabaseEmpty',
            'createTable',
            'dropTable',
            'repoDirectoryPermissions',
            'testMail'
        ];
    }

    Preflight.prototype.start = function() {
        $.get('/preflight', function(modal) {
            $('body').append(modal);

            $('#preflightModal').on('hidden.bs.modal', function () {
                $('#preflightModal').remove();
            });

            $('#preflightModal').modal('show');

            this.runTests();
        }.bind(this), 'html');
    };

    Preflight.prototype.scrollIntoView = function() {
        var $resultPanel = $('#preflightModal').find('.modal-body');

        $resultPanel.scrollTop($resultPanel[0].scrollHeight);
    };

    Preflight.prototype.runTests = function() {
        if (!this.tests.length || !this.passed) {
            this.finish();

            return;
        }

        var currentTest = this.tests.shift();

        this[currentTest]();
    };

    Preflight.prototype.runTest = function(url, data) {
        $.get(url, function(test) {
            $('#preflightModal .modal-body').append(test);

            this.scrollIntoView();

            $.post(url + '/test', data, function(result) {
                $('#preflightModal .modal-body').append(result.result);

                if (result.criticalError) {
                    this.passed = false;
                }

                this.scrollIntoView();
                this.runTests();
            }.bind(this), 'json');
        }.bind(this), 'html');
    };

    Preflight.prototype.finish = function() {
        $('[data-dismiss="modal"]').removeProp('disabled');

        if (this.passed) {
            $('[type="submit"]').removeProp('disabled');
        }
    };

    Preflight.prototype.checkDatabaseConnection = function() {
        this.runTest('/preflight/database-connection', {
            hostname: $('[name="dbhostname"]').val(),
            name:  $('[name="dbname"]').val(),
            username:  $('[name="dbusername"]').val(),
            password:  $('[name="dbpassword"]').val()
        });
    };

    Preflight.prototype.checkDatabaseEmpty = function() {
        this.runTest('/preflight/empty-database', {
            hostname: $('[name="dbhostname"]').val(),
            name:  $('[name="dbname"]').val(),
            username:  $('[name="dbusername"]').val(),
            password:  $('[name="dbpassword"]').val()
        });
    };

    Preflight.prototype.createTable = function() {
        this.runTest('/preflight/create-table', {
            hostname: $('[name="dbhostname"]').val(),
            name:  $('[name="dbname"]').val(),
            username:  $('[name="dbusername"]').val(),
            password:  $('[name="dbpassword"]').val()
        });
    };

    Preflight.prototype.dropTable = function() {
        this.runTest('/preflight/drop-table', {
            hostname: $('[name="dbhostname"]').val(),
            name:  $('[name="dbname"]').val(),
            username:  $('[name="dbusername"]').val(),
            password:  $('[name="dbpassword"]').val()
        });
    };

    Preflight.prototype.repoDirectoryPermissions = function() {
        this.runTest('/preflight/repo-directory', {
            directory: $('[name="repodir"]').val()
        });
    };

    Preflight.prototype.testMail = function() {
        if ($('[name="mailtransport"]').val() === 'sendmail') {
            this.runTest('/preflight/sendmail', {
                address: $('[name="email"]').val(),
                name:  $('[name="name"]').val()
            });
        }
    };

    $('form.install').on('submit', function(e) {
        e.preventDefault();

        new Preflight().start();
    });
}(jQuery));