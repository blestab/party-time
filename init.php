<?php
require 'vendor/autoload.php';

class App extends \atk4\ui\App {
  function __construct($is_admin = false) {

    parent::__construct('My Party App');

    // Depending on the use, select appropriate layout for our pages
    if ($is_admin) {
      $this->initLayout('Admin');
      $this->layout->leftMenu->addItem(['Dashboard','icon'=>'birthday cake'], ['dashboard']);
      $this->layout->leftMenu->addItem(['Guests','icon'=>'users'], ['admin']);
    } else {
      $this->initLayout('Centered');
    }
    $this->dbConnect('mysql://root:@localhost/party-app');
  }

}

class Guest extends \atk4\data\Model {
  public $table = 'guest';
  function init() {
    parent::init();

    $this->addFields([
      ['name','required'=>true],
      'surname',
      ['phone','required'=>true],
      'email'
    ]);
    $this->addField('age', ['required'=>true]);
    $this->addField('units_of_drink', ['ui'=>[
      'hint'=>'Bring Your Own Drink - how many bottles will you bring?'
      ]]);
    $this->addField('gender', ['enum' => ['female', 'male']]);
  }
}

class Dashboard extends \atk4\ui\View {
  public $defaultTemplate = __DIR__.'/dashboard.html';

  function setModel($m) {
    $model = parent::setModel($m);
    $total_guests = $model->action('count')->getOne();
    //$total_females = $model->addCondition('gender', 'female')->action('count')->getOne();
    //$total_males = $model->addCondition('gender', 'male')->action('count')->getOne();
    $units_of_drink = $model->action('fx', ['sum','units_of_drink'])->getOne();
    $this->template['guests'] = $total_guests;
    $this->template['male'] = $total_males ?? 0;
    $this->template['female'] = $total_females ?? 0;
    $this->template['unk'] = $total_guests - $total_females - $total_males;
    $this->template['drinks'] = $units_of_drink ?? 0;

    return $model;
  }
}
