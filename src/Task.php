<?php
class Task
{
    private $description;
    private $id;

    function __construct($description, $id = null)
    {
        $this->description = $description;
        $this->id = $id;
    }

    function setDescription($new_description)
    {
        $this->description = (string) $new_description;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getId()
    {
      return $this->id;
    }

    function setId($new_id)
    {
      $this->id = (int) $new_id;
    }

    function save()
    {
      $GLOBALS['DB']->query("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}');");
      $statement = $GLOBALS['DB']->query("SELECT LAST_INSERT_ID();");
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      $this->setId(mysql_insert_id());
    }

    static function getAll()
    {
      $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
      $tasks = array();
      foreach($returned_tasks as $task) {
        $description = $task['description'];
        $id = $task['id'];
        $new_task = new Task($description, $id);
        array_push($tasks, $new_task);
      }
      return $tasks;
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM tasks;");
    }
}
?>
