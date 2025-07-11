phpquery 0.1
========

PHPQuery Terminal is a PHP terminal that works with Ajax and PHP Classes. Really easy to use. Write a command and the
class with the same name will be executed. Also, you can send it a few commands that will be used as parameters.

For use the PHPQuery terminal you need to login. In this example I have created a test user. Username: test. Password:
test.

Use the help command for learn to use it.

PHPQuery Terminal idea was based in UNIX behavior. You can add new classes, create and edit it. In this version are
available a few commands only example about how to use it.

Example for most simple command (hello.php):

class helloworld extends Command{
public function init($params){
$result = "Hello!";
$this->data = $result;
}
}

To use this command is really simple. Only write "hello" in the PHPQuery Terminal.

For more information and download new versions please visit http://www.andoitz.com
