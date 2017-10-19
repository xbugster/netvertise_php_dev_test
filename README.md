
# Netvertise Senior PHP Developer test

Author: Valentin Ruskevych Leaderpvp@gmail.com

Task: check out [event_based_test.odt](event_based_test.odt) in root folder.

Code Date: June 2013

## Project

Event Based Comment System - Netvertize Test


1. Requirement

** Webserver :)
** PHP > 5.3
** PHPUnit > 3.4.5
** MySQL 5.x Database

2. Installation

2.1 Place project into proper folder ( ex. /var/www/events.com/ ).

    ---

2.2 Set up your config

    Config resides within folder /lib/config/, edit config with your favorite text editor.

    Directive "AUTOLOADER" - change the folder containing autoloader only if that folder is moved
    to a different than default place.

    Right after comment "DB Settings", adjust next 4 directives for your requirement, they are all
    prefixed with DB_

    DEFAULT_EVENT - Default event to fire if landing with no action.

    Debug Settings - Standard PHP Settings during development process.

    ---

2.3 Establish Database

    In you project folder you will find a file named: "comments.db.sql", the file is actually
    mysql database dump and we need to restore the default data.

    run next command: "mysqldump -uUSERNAME -p DATABASENAME < /path/to/file/comments.db.sql"

    ---

2.4 Test Run

    Now it is crucial to ensure whether the system performs well on your system, php and other settings.

    The unit tests resides within folder /tests/ in project's directory.

    Head to folder /tests/ ( ex. cd /var/www/events.com/tests/ ), after you arrived to tests directory
    run the test itself with next command: " phpunit --process-isolation ./ "

    Result:
        If you receive the red messages, please go through test's output and fix what is wrong.
        Received the green result?

        My congratulations. you are now ready to proceed development.


3. Design
======
Commander   - Running Chain of commands from receiving request to events execution
UniSubject  - Subject implements SplSubject, also benefits from SplObjectStorage
Observer    - List of classes resides in projectDir/lib/events/observer/ and implements SplObserver, responsible for
              different tasks
EventManager- Singleton responsible for executing proper event, defined by router
Router      - Simply determines the event to be executed, relies on received GET parameter "action"
DbLayer     - Adapter, implements DataLinkInterface


4. Developers Guidelines
======
First and most important - make sure you test code after every change done.
---
Make sure any Adapter you develop implements DataLinkInterface, to prevent Exception as code relies on dependencies.
No matter whether adapter using xml,json,db,flat files,plain text, etc.
---
You could add observer and events within your data storage, they are fetched from DataLink (watch DbLayer Adapter).
Make sure observers implement SplObserver, otherwise exception will be thrown.

