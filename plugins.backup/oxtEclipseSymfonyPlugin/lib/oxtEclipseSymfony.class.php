<?php
class oxtEclipseSymfony
{
  /**
   * Calls counter, we catch event for every application and environment. We need file generated only once.
   * @var int
   */
  static private $calls = 0;

  /**
   * Ant build file
   * @var string
   */
  const BUILD_FILE = 'symfony-build.xml';

  /**
   * Recreate ant build file on	 'cache:clear' call
   * @param sfEvent $event
   */
  static public function createAntBuildFile(sfEvent $event)
  {
    if (self::$calls || ($event['env'] != 'dev')) //generate file only once and only for dev environment
      return false;
    self::$calls ++;

    $event->getSubject()->logSection('file+', self::BUILD_FILE);
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $dom->appendChild($projectXML = $dom->createElement('project'));

    $projectXML->appendChild($propertyXML = $dom->createElement('property'));
    $propertyXML->setAttribute('name', 'symfony.command');
    $sf_command_line = (isset($_SERVER['_'])
    	&& (preg_match('/php$/', $_SERVER['_'])
    		|| ($_SERVER['_'] == './symfony')))
    	? './symfony'
    	: 'symfony';
    $propertyXML->setAttribute('value', $sf_command_line);

    $dispatcher = new sfEventDispatcher();
    $application = new sfSymfonyCommandApplication($dispatcher, null, array('symfony_lib_dir' => realpath(dirname(__FILE__).'/../../../')));

    $tasks = $application->getTasks();
    ksort($tasks);
    foreach ($tasks as $name => $task)
    {
      $projectXML->appendChild($targetXML = $dom->createElement('target'));
      $targetXML->setAttribute('name', $name);
      $targetXML->setAttribute('description', $task->getBriefDescription());
      $task_arguments = array();
      foreach ($task->getArguments() as $argument)
        if ($argument->isRequired())
        {
          $targetXML->appendChild($inputXML = $dom->createElement('input'));
          $inputXML->setAttribute('message', $argument->getHelp());
          $argument_name = 'symfony.' . $task->getNamespace() . '.' . $task->getName() . '.' . $argument->getName();
          $task_arguments[] = $argument_name;
          $inputXML->setAttribute('addproperty', $argument_name);
          $default = $argument->getDefault();
          if ($default)
            $inputXML->setAttribute('defaultvalue', $default);
        }
      $targetXML->appendChild($execXML = $dom->createElement('exec'));
      $execXML->setAttribute('dir', '');
      $execXML->setAttribute('executable', '${symfony.command}');
      $execXML->appendChild($argXML = $dom->createElement('arg'));
      $task_command = $task->getNamespace()
        ? $task->getNamespace() . ':' . $task->getName()
        : $task->getName();
      $argXML->setAttribute('value', $task_command);
      foreach ($task_arguments as $argument)
      {
        $execXML->appendChild($argXML = $dom->createElement('arg'));
        $argXML->setAttribute('value', '${' . $argument . '}');
      }
    }

    file_put_contents(self::BUILD_FILE, $dom->saveXml());
    return false; //we do not stop cache:clear
  }
}